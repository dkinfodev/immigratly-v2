@extends('layouts.master')

@section('breadcrumb')
<!-- Content -->
<ol class="breadcrumb breadcrumb-no-gutter">
  <li class="breadcrumb-item"><a class="breadcrumb-link" href="{{ baseUrl('/') }}">Dashboard</a></li>
  <!-- <li class="breadcrumb-item"><a class="breadcrumb-link" href="{{ baseUrl('/cases') }}">Cases</a></li> -->
  <li class="breadcrumb-item active" aria-current="page">{{$pageTitle}}</li>
</ol>
<!-- End Content -->
@endsection

@section('content')
<style>
ul.nav.nav-tabs.dependents-list {
    margin-bottom: 35px;
    text-transform: capitalize;
}
.all_services li {
   padding: 16px;
   border-bottom: 1px solid #ddd;
}
.sub_services li {
   border-bottom: none;
}
</style>
<!-- Content -->

<!-- Content -->
@include(roleFolder().'.cases.case-navbar')

@if($record->case_type == 'group')
<div class="row">
   <div class="col-md-12">
      <ul class="nav nav-tabs dependents-list" role="tablist">
            <li>
          
               @if(!empty($record->Client($record->client_id)))
               <?php
               $client = $record->Client($record->client_id);
               ?>
               <a href="{{ baseUrl('cases/case-documents/'.$doc_type.'/'.$case_id.'/'.$doc_id) }}" class="nav-link {{($dependent_id == '')?'active':''}}">{{$client->first_name." ".$client->last_name}}</a>
               @else
               <a href="{{ baseUrl('cases/case-documents/'.$doc_type.'/'.$case_id.'/'.$doc_id) }}" class="nav-link {{($dependent_id == '')?'active':''}}">Client not found</a>
               @endif
            </li>
            @foreach($dependents as $dependent)
               @if(!empty($dependent->Dependent($dependent->dependent_id)))
               <li class="nav-item">
                  <?php 
                     $case_dependent = $dependent->Dependent($dependent->dependent_id);
                  ?>
                  <a href="{{ baseUrl('cases/case-documents/'.$doc_type.'/'.$case_id.'/'.$doc_id.'?dependent_id='.$dependent->dependent_id.'&visa_service='.$dependent->visa_service_id) }}" class="nav-link {{($dependent_id == $dependent->dependent_id)?'active':''}}">{{$case_dependent->given_name}}</a>
               </li>
               @endif
            @endforeach
      </ul>
   </div>
</div>
@endif
<div class="">
    <div class="row">
        <div class="col-lg-9 mb-5 mb-lg-0">
            <div id="collapseOne" class="collapse" aria-labelledby="headingOne">
                <div class="card-body">
                    <!-- Dropzone -->
                    <div id="attachFilesLabel" class="js-dropzone dropzone-custom custom-file-boxed"
                           data-hs-dropzone-options='{
                              "url": "<?php echo baseUrl('cases/case-documents/upload-documents/'.base64_encode($record->id)) ?>?_token=<?php echo csrf_token() ?>&folder_id=<?php echo $document->unique_id ?>&doc_type=<?php echo $doc_type ?>&user_type=<?php echo $user_type ?>&dependent_id=<?php echo $dependent_id ?>",
                              "thumbnailWidth": 100,
                              "thumbnailHeight": 100
                           }'
                        >
                        <div class="dz-message custom-file-boxed-label">
                            <img class="avatar avatar-xl avatar-4by3 mb-3" src="assets/svg/illustrations/browse.svg"
                                alt="Image Description">
                            <h5 class="mb-1">Drag and drop your file here</h5>
                            <p class="mb-2">or</p>
                            <span class="btn btn-sm btn-white">Browse files</span>
                        </div>
                    </div>
                    <!-- End Dropzone -->
                </div>
            </div>
            <!-- List Group -->
            <ul class="list-group">
                <!-- List Item -->
                @foreach($case_documents as $key => $doc)
                  <?php 
                     $doc_url = $file_url."/".$doc->FileDetail->file_name; 
                     $url = baseUrl('cases/case-documents/preview-document/'.$case_id.'/'.$doc->unique_id.'?url='.$doc_url.'&file_name='.$doc->FileDetail->file_name.'&p='.$subdomain);
                  ?>
                <li class="list-group-item">
                    <div class="row align-items-center gx-2">
                        <div class="col-auto">
                           <?php 
                              $fileicon = fileIcon($doc->FileDetail->original_name);
                              echo $fileicon;
                              $filesize = file_size($file_dir."/".$doc->FileDetail->file_name);
                           ?>
                        </div>

                        <div class="col">
                            <h5 class="mb-0">
                                <a data-href="{{$url}}" onclick="previewDocument(this)" data-filename="{{$doc->FileDetail->original_name}}" data-caseid="{{$case_id}}" data-documentid="{{ $doc->unique_id }}"  class="text-dark" href="javascript:;" data-toggle="modal"
                                    data-target=".bd-example-modal-fs">{{$doc->FileDetail->original_name}}</a>
                            </h5>
                            <ul class="list-inline list-separator small">
                                <li class="list-inline-item">Added on {{dateFormat($doc->created_at)}}</li>
                                <li class="list-inline-item">{{$filesize}}</li>
                                <?php       
                                    $doc_chats = countUnreadDocChat($case_id,$subdomain,\Auth::user()->role,$doc->folder_id,$doc->unique_id);
                                    if($doc_chats > 0){
                                ?>
                                    <li class="list-inline-item text-danger">{{$doc_chats}} chats</li>
                                <?php } ?>
                            </ul>
                        </div>

                        <div class="col-auto">
                            <!-- Unfold -->
                            <div class="hs-unfold">
                                <a class="js-hs-unfold-invoker btn btn-sm btn-white" href="javascript:;"
                                    data-hs-unfold-options='{
                                    "target": "#action-{{$key}}",
                                    "type": "css-animation"
                                    }'>
                                    <span class="d-none d-sm-inline-block mr-1">More</span>
                                    <i class="tio-chevron-down"></i>
                                </a>
                                <div id="action-{{$key}}"
                                    class="hs-unfold-content dropdown-unfold dropdown-menu dropdown-menu-right"
                                    style="min-width: 13rem;">

                                    <a class="dropdown-item" download href="{{ $doc_url }}">
                                        <i class="tio-download-to dropdown-item-icon"></i>
                                        Download
                                    </a>
                                    <a class="dropdown-item" onclick="showPopup('<?php echo baseUrl('cases/case-documents/rename-file/'.$doc->file_id) ?>')">
                                        <i class="tio-edit dropdown-item-icon"></i>
                                        Rename
                                    </a>
                                    <a class="dropdown-item text-danger" href="javascript:;"
                                        onclick="confirmAction(this)" data-href="{{baseUrl('cases/case-documents/delete/'.base64_encode($doc->id))}}">
                                        <i class="tio-delete-outlined dropdown-item-icon"></i>
                                        Delete
                                    </a>
                                    
                                </div>
                            </div>
                            <!-- End Unfold -->
                        </div>
                    </div>
                    <!-- End Row -->
                </li>
                @endforeach
                <!-- End List Item -->

            </ul>
            <!-- End List Group -->

            <!-- Sticky Block End Point -->
            <div id="stickyBlockEndPoint"></div>
        </div>

        <div id="stickyBlockStartPoint" class="col-lg-3">
            
         <div role="group">

            <a class="btn btn-primary w-100" href="javascript:;" data-toggle="collapse" data-target="#collapseOne"
                  aria-expanded="true" aria-controls="collapseOne"><i class="tio-upload-on-cloud mr-1"></i>
                  Upload</a>
         </div>

        </div>
        <!-- End Row -->
    </div>
</div>
<div class="modal fade bd-example-modal-fs" tabindex="-1" role="dialog" aria-labelledby="myExtraLargeModalLabel"
    aria-hidden="true">
    <div class="modal-dialog modal-fs" role="document">
        <div class="modal-content min-vh-lg-100">

            <div class="modal-header">
                <h5 class="modal-title h4" id="myExtraLargeModalLabel">Preview Document</h5>
                <button type="button" class="btn btn-xs btn-icon btn-ghost-secondary" data-dismiss="modal"
                    aria-label="Close">
                    <i class="tio-clear tio-lg"></i>
                </button>
            </div>
            <div class="modal-body">
                <div class="document-view-container">
                    <div class="document-toolbar">
                        <h5 class="document-view-title" style="color:#666">
                            Document title here
                        </h5>
                    </div>


                    <div class="document-preview-thumbs">
                        
                        <div id="document-preview-thumbs-content">
                            <ul>
                            @foreach($case_documents as $key => $doc)
                            <?php 
                                $doc_url = $file_url."/".$doc->FileDetail->file_name; 
                                $doc_id = '';
                                $url = baseUrl('cases/case-documents/preview-document/'.$case_id.'/'.$doc->unique_id.'?url='.$doc_url.'&file_name='.$doc->FileDetail->file_name.'&p='.$subdomain.'&doc_type='.$doc_type.'&folder_id='.$doc_id);
                            ?>
                                <li class="{{ $doc->unique_id }}">
                                    <a onclick="previewDocument(this)" data-filename="{{ $doc->FileDetail->original_name }}" data-caseid="{{$case_id}}" data-documentid="{{ $doc->unique_id }}" class="card card-sm card-hover-shadow text-center" href="javascript:;" data-href="{{$url}}">
                                        <div class="card-body">
                                        <?php 
                                             $fileicon = fileIcon($doc->FileDetail->original_name);
                                             echo $fileicon;
                                             $filesize = file_size($file_dir."/".$doc->FileDetail->file_name);
                                          ?>
                                        </div>
                                        <div class="card-footer border-top-0">
                                            <h6>{{$doc->FileDetail->original_name}}</h6>
                                        </div>
                                    </a>
                                </li>
                            @endforeach
                            </ul>
                        </div>
                    </div>


                    <div class="document-content">
                        <input type="hidden" name="document_id" class="document_id" />
                        <input type="hidden" name="case_id" class="case_id" />
                        <div id="document-preview"></div>
                        <!-- <iframe src="https://immigratly.com/public/uploads/professional/abc9/documents/39672-Document Checklist SOWP - student.pdf" style="margin:0 auto;width:100%;height: 100vh;" frameborder="0"></iframe> -->
                    </div>
                </div>
                <div id="shot-sidebar-app" class="shot-sidebar-app">
                    <div class="shot-sidebar-open-contents">
                        <div class="comment-document active-comment">
                            <a href="javascript:;" onclick="viewChats()" id="comment-trigger"
                                class="comment-document-link">
                                <span class="comment-document-counter"></span>
                                <img class="avatar avatar-4by3 comment-document-image"
                                    src="assets/svg/message/chat-blue.svg" alt="Image Description">
                            </a>
                        </div>
                    </div>
                    <div class="shot-actions-toolbar-wrapper">
                        <!---->
                    </div>
                    <div class="shot-sidebar sidebar-open">
                        <div class="shot-sidebar-content">
                            <h5 class="document-feedback-title">
                                Document Feedback
                            </h5> 
                            <a href="javascript:;" id="send-message-close-manually">Hide Me</a>
                            <div class="send-message-box">
                                <div class="send-message-container">
                                    <div class="form-group">
                                        <div class="row">
                                            <div class="col">
                                                <label class="input-label" id="send-message" for="message_input">Send a message</label>
                                                <input type="file" name="chat_file" id="chat-attachment" style="display:none" />
                                            </div>
                                            <div class="col text-right">
                                                <span class="text-primary uploaded-file"></span>
                                                <a href="javascript:;" class="text-info send-attachment">
                                                    <i class="tio-attachment"></i>
                                                </a>
                                            </div>
                                        </div>
                                        <textarea id="message_input" class="form-control"
                                            placeholder="Type your message" rows="2"></textarea>
                                    </div>
                                </div>
                            </div>
                            <div infinite-scroll-distance="10" infinite-scroll-listen-for-event="infiniteScroll"
                                class="sidebar-scrolling-container">
                                <div class="shot-sidebar-contents">
                                    <div id="document-chats" class="shot-sidebar-actions display-flex justify-space-between"></div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- End Content -->
@endsection
@section('javascript')
<link rel="stylesheet" href="assets/vendor/mCustomScrollbar/jquery.mCustomScrollbar.css" />
<script src="assets/vendor/mCustomScrollbar/jquery.mCustomScrollbar.min.js"></script>
<script src="assets/vendor/dropzone/dist/min/dropzone.min.js"></script>
<link rel="stylesheet" href="assets/css/jquery.mThumbnailScroller.css">
<script src="assets/js/jquery.slidereveal.js"></script>
<script src="assets/js/jquery.mThumbnailScroller.js"></script>

<script type="text/javascript">
   var case_id;
   var document_id;
   var is_error = false;
   var sample1;
   $(document).ready(function(){

      $("#document-preview-thumbs-content").mThumbnailScroller({
      axis: "y",
      type: "click-50",
      theme: "buttons-out"
      });


      $("#shot-sidebar-app").slideReveal({
         trigger: $("#comment-trigger"),
         autoEscape: false,
         width: 380,
         push: true,
         top: 34,
         position: "right",
         speed: 700
      });
      sample1 = $("#shot-sidebar-app").slideReveal({
         trigger: $("#comment-trigger"),
         autoEscape: false,
         width: 380,
         push: true,
         top: 34,
         position: "right",
         speed: 700
      })
      $("#send-message-close-manually").click(function () {
      sample1.slideReveal("hide");
      });
      $('.js-nav-tooltip-link').tooltip({
         boundary: 'window'
      })
      $('.js-hs-action').each(function() {
         var unfold = new HSUnfold($(this)).init();
      });
      
      $('.js-hs-action').each(function () {
       var unfold = new HSUnfold($(this)).init();
      });
      $(".row-checkbox").change(function(){
         if($(".row-checkbox:checked").length > 0){
            $("#datatableCounterInfo").show();
         }else{
            $("#datatableCounterInfo").hide();
         }
         $("#datatableCounter").html($(".row-checkbox:checked").length);
      });
      $(".send-attachment").click(function() {
        document.getElementById('chat-attachment').click();
    });
    $("#send-message").click(function() {

        var message = $("#message_input").val();
        
        var formData = new FormData();
        formData.append("_token", csrf_token);
        formData.append("case_id", case_id);
        formData.append("document_id", document_id);
        formData.append("doc_type", '{{ $doc_type}}');
        formData.append("subdomain", "{{$subdomain}}");
        formData.append("message", message);
        if($('#chat-attachment')[0].files[0] != undefined){
            formData.append('attachment', $('#chat-attachment')[0].files[0]);
            formData.append("type", 'file');
            var url  = "{{ baseUrl('cases/case-documents/send-chat-file') }}";
        }else{
            formData.append("type", 'text');
            var url  = "{{ baseUrl('cases/case-documents/send-chats') }}";
        }
        

        // formData.append('attachment', $('#chat-attachment')[0].files[0]);
        if (message != '') {
            $.ajax({
                type: "POST",
                url: url,
                data:formData,
                cache: false,
                contentType: false,
                processData: false,
                // data: {
                //     _token: csrf_token,
                //     case_id: case_id,
                //     document_id: document_id,
                //     message: message,
                //     doc_type: "{{ $doc_type}}",
                //     type: "text",
                //     subdomain: "{{$subdomain}}"
                // },
                dataType: 'json',
                beforeSend: function() {
                    // var html = '<div class="text-center"><div class="spinner-border" role="status"><span class="sr-only">Loading...</span></div>';
                    // $("#activitySidebar .messages").html(html);
                    $("#message_input,.send-message,.send-attachment").attr('disabled','disabled');
                },
                success: function(response) {
                    if (response.status == true) {
                        $("#message_input").val('');
                        $("#activitySidebar .messages").html(response.html);
                        $("#message_input,.send-message,.send-attachment").removeAttr('disabled');
                        $("#chat-attachment").val('');
                        $(".uploaded-file").html('');
                        // $(".messages").mCustomScrollbar();
                        // $(".messages").animate({
                        //     scrollTop: $(".messages")[0].scrollHeight
                        // }, 1000);
                        $(".doc_chat_input").show();
                        fetchChats(case_id, document_id);
                    } else {
                        errorMessage(response.message);
                    }
                },
                error: function() {
                    $("#message_input,.send-message,.send-attachment").removeAttr(
                        'disabled');
                    internalError();
                }
            });
        }
    });

    $("#chat-attachment").change(function() {
        var filename = $('#chat-attachment')[0].files.length ? $('#chat-attachment')[0].files[0].name : "";
        $(".uploaded-file").html(filename);
        // var formData = new FormData();
        // formData.append("_token", csrf_token);
        // formData.append("case_id", case_id);
        // formData.append("document_id", document_id);
        // formData.append("subdomain", "{{$subdomain}}");
        // formData.append('attachment', $('#chat-attachment')[0].files[0]);
        // var url  = "{{ baseUrl('cases/case-documents/send-chat-file') }}";
        // $.ajax({
        //     url: url,
        //     type: "post",
        //     data: formData,
        //     cache: false,
        //     contentType: false,
        //     processData: false,
        //     dataType: "json",
        //     beforeSend: function() {
        //         $("#message_input,.send-message,.send-attachment").attr('disabled',
        //             'disabled');
        //     },
        //     success: function(response) {
        //         if (response.status == true) {
        //             $("#message_input,.send-message,.send-attachment").removeAttr(
        //                 'disabled');
        //             $("#chat-attachment").val('');
        //             $("#activitySidebar .messages").html(response.html);
        //             // $(".messages").mCustomScrollbar();
                    
        //             $(".doc_chat_input").show();
        //             fetchChats(case_id, document_id);
        //         } else {
        //             errorMessage(response.message);
        //         }
        //     },
        //     error: function() {
        //         $("#message_input,.send-message,.send-attachment").removeAttr('disabled');
        //         internalError();
        //     }
        // });
    });
   });
   $('.dropzone-custom').each(function () {
      var dropzone = $.HSCore.components.HSDropzone.init('#' + $(this).attr('id'));
      dropzone.on("success", function(file,response) {
        if(response.status == false){
            is_error = true;
         }
      });
      dropzone.on("queuecomplete", function() {
         if(is_error == true){
            errorMessage("Error while upload file");
         }else{
            location.reload();
         }
      });
      
   });      

   function deleteFiles(){
      if($(".row-checkbox:checked").length > 0){
         var files = [];
         $(".row-checkbox:checked").each(function(){
            files.push($(this).val());
         })
         $.ajax({
           type: "POST",
           url: BASEURL + '/cases/remove-documents',
           data:{
               _token:csrf_token,
               files:files,
           },
           dataType:'json',
           beforeSend:function(){
               showLoader();
           },
           success: function (data) {
               if(data.status == true){
                  location.reload();
               }else{
                  errorMessage('Error while pin the folder');
               }
           },
           error:function(){
             internalError();
           }
         });
      }else{
         errorMessage("No files selected");
      }
   }
   function fetchChats(c_id,d_id){
      case_id = c_id;
      document_id = d_id;
      $("#activitySidebar").attr("data-case-id",'');
      $("#activitySidebar").attr("data-document-id",'');
      $.ajax({
        type: "POST",
        url: "{{ baseUrl('cases/case-documents/fetch-chats') }}",
        data:{
            _token:csrf_token,
            case_id:case_id,
            document_id:document_id,
        },
        dataType:'json',
        beforeSend:function(){
         $("#activitySidebar").attr("data-case-id",case_id);
         $("#activitySidebar").attr("data-document-id",document_id);
           // var html = '<div class="text-center"><div class="spinner-border" role="status"><span class="sr-only">Loading...</span></div>';
           // $("#activitySidebar .messages").html(html);
           $("#message_input").val('');
           $("#message_input,.send-message,.send-attachment").attr('disabled','disabled');
        },
        success: function (response) {
         if (response.status == true) {
                $("#message_input,.send-message,.send-attachment").removeAttr('disabled');
                $("#document-chats").html(response.html);
                if(response.unread_chat != ''){
                    $(".comment-document-counter").show();
                    $(".comment-document-counter").html(response.unread_chat);
                }else{
                    $(".comment-document-counter").hide();
                }
                $(".doc_chat_input").show();
            } else {
                errorMessage(response.message);
            }
        },
        error:function(){
         $("#activitySidebar .messages").html('');
         internalError();
        }
      });
   }
   function previewDocument(e){
    var url = $(e).attr("data-href");
    case_id = $(e).attr("data-caseid");
    var file_name = $(e).attr("data-filename")
    document_id = $(e).attr("data-documentid");
    $("#document-preview-thumbs-content .mTSThumbContainer").removeClass("active");
    $("#document-preview-thumbs-content ."+document_id).addClass("active");
    $(".document-content .document_id").val(document_id);
    $(".document-content .case_id").val(case_id);
    $(".document-view-title").html(file_name);
    sample1.slideReveal("hide");
    $.ajax({
        type: "GET",
        url: url,
        dataType: 'json',
        beforeSend: function() {
            showLoader();
        },
        success: function(response) {
            hideLoader();
            if (response.status == true) {
                $("#document-preview").html(response.content);
                fetchChats(case_id, document_id);
            } else {
                errorMessage(response.message);
            }
        },
        error: function() {
            $("#message_input,.send-message,.send-attachment").removeAttr(
                'disabled');
            internalError();
        }
    });
}
function viewChats(){
    var dc_id = $(".document-content .document_id").val();
    var cid = $(".document-content .case_id").val();
    fetchChats(cid, dc_id);
}
</script>
@endsection