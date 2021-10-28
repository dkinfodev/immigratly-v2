@extends('layouts.master')
@section('pageheader')
<!-- Content -->
<div class="">
    <div class="content container" style="height: 25rem;">
        <!-- Page Header -->
        <div class="page-header page-header-light page-header-reset">
            <div class="row align-items-center">
                <div class="col">
                    <h1 class="page-header-title">{{$pageTitle}}</h1>
                </div>
            </div>
            <!-- End Row -->
        </div>
        <!-- End Page Header -->
    </div>
</div> 
<!-- End Content -->
@endsection

@section("style")
<style>
   .all_services li {
   padding: 16px;
   border-bottom: 1px solid #ddd;
   }
   .sub_services li {
   border-bottom: none;
   }
</style>
@endsection
@section('content')
<!-- Content -->
<!-- Content -->
<div class="documents">
   <!-- Page Header -->
   <div class="page-header">
      <div class="row align-items-end mb-3">
         <div class="col-sm mb-2 mb-sm-0">
            <nav aria-label="breadcrumb">
               <ol class="breadcrumb breadcrumb-no-gutter">
                  <li class="breadcrumb-item"><a class="breadcrumb-link" href="{{ baseUrl('/') }}">Dashboard</a></li>
                  <li class="breadcrumb-item"><a class="breadcrumb-link" href="{{ baseUrl('/cases') }}">Cases</a></li>
                  <li class="breadcrumb-item"><a class="breadcrumb-link" href="{{ baseUrl('/cases/case-documents/documents/'.base64_encode($record->id)) }}">Documents</a></li>
                  <li class="breadcrumb-item active" aria-current="page">{{$pageTitle}}</li>
               </ol>
            </nav>
            <h1 class="page-header-title">{{$pageTitle}}</h1>
            <div clas="d-block">
               @if(!empty($service->Service($service->service_id)))
                <h4 class="text-primary p-2">{{$service->Service($service->service_id)->name}}</h4>
               @else
                <h4 class="text-primary p-2">Service not found</h4>
               @endif
            </div>
         </div>
         <div class="col-sm-auto">
            <div class="btn-group" role="group">
               <a class="btn btn-primary"  href="javascript:;" data-toggle="collapse" data-target="#collapseOne" aria-expanded="true" aria-controls="collapseOne"><i class="tio-upload-on-cloud mr-1"></i> Upload</a>
            </div>
         </div>
      </div>
      <div id="collapseOne" class="collapse" aria-labelledby="headingOne">
        <div class="card-body">
          <!-- Dropzone -->
            <div id="attachFilesLabel" class="js-dropzone dropzone-custom custom-file-boxed"
               data-hs-dropzone-options='{
                  "url": "<?php echo baseUrl('cases/case-documents/upload-documents/'.base64_encode($record->id)) ?>?_token=<?php echo csrf_token() ?>&folder_id=<?php echo $document->unique_id ?>&doc_type=<?php echo $doc_type ?>",
                  "thumbnailWidth": 100,
                  "thumbnailHeight": 100
               }'
            >
               <div class="dz-message custom-file-boxed-label">
                  <img class="avatar avatar-xl avatar-4by3 mb-3" src="./assets/svg/illustrations/browse.svg" alt="Image Description">
                  <h5 class="mb-1">Drag and drop your file here</h5>
                  <p class="mb-2">or</p>
                  <span class="btn btn-sm btn-white">Browse files</span>
               </div>
            </div>
            <!-- End Dropzone -->
        </div>
      </div>
      <!-- End Row -->
      <!-- Nav -->
      <!-- Nav -->
      <div class="js-nav-scroller hs-nav-scroller-horizontal">
         <span class="hs-nav-scroller-arrow-prev" style="display: none;">
         <a class="hs-nav-scroller-arrow-link" href="javascript:;">
         <i class="tio-chevron-left"></i>
         </a>
         </span>
         <span class="hs-nav-scroller-arrow-next" style="display: none;">
         <a class="hs-nav-scroller-arrow-link" href="javascript:;">
         <i class="tio-chevron-right"></i>
         </a>
         </span>
      </div>
      <!-- End Nav -->
   </div>
   <!-- End Page Header -->
   <!-- Card -->
   <div class="card">
      <!-- Header -->
      <div class="card-header">
         <div class="row justify-content-between align-items-center flex-grow-1">
            <!-- <div class="col-12 col-md">
               <form>
                  <div class="input-group input-group-merge input-group-borderless">
                     <div class="input-group-prepend">
                        <div class="input-group-text">
                           <i class="tio-search"></i>
                        </div>
                     </div>
                     <input id="datatableSearch" type="search" class="form-control" placeholder="Search users" aria-label="Search users">
                  </div>
               </form>
            </div> -->
            <div class="col-auto">
               <div class="d-flex align-items-center">
                  <div id="datatableCounterInfo" class="mr-2" style="display: none;">
                     <div class="d-flex align-items-center">
                        <span class="font-size-sm mr-3">
                        <span id="datatableCounter">0</span>
                        Selected
                        </span>
                        <a class="btn btn-sm btn-outline-danger" data-href="{{ baseUrl('cases/case-documents/delete-multiple') }}" onclick="deleteMultiple(this)" href="javascript:;">
                        <i class="tio-delete-outlined"></i> Delete
                        </a>
                     </div>
                  </div>
               </div>
            </div>
         </div>
      </div>
      <!-- End Header -->
      <!-- Table -->
      <!-- Sidebar -->
      <div id="activitySidebar" class="hs-unfold-content sidebar sidebar-bordered sidebar-box-shadow">
         <div class="card card-lg sidebar-card sidebar-scrollbar">
            <div class="card-header">
               <h4 class="card-header-title">Document Chats</h4>
               <!-- Toggle Button -->
               <a class="js-hs-unfold-invoker btn btn-icon btn-xs btn-ghost-dark ml-2" href="javascript:;"
                  data-hs-unfold-options='{
                  "target": "#activitySidebar",
                  "type": "css-animation",
                  "animationIn": "fadeInRight",
                  "animationOut": "fadeOutRight",
                  "hasOverlay": true,
                  "smartPositionOff": true
                  }'>
               <i class="tio-clear tio-lg"></i>
               </a>
               <!-- End Toggle Button -->
            </div>
            <!-- Body -->
            <div class="card-body sidebar-body">
               <div class="chat_window">
                  <ul class="messages">
                     
                  </ul>
                  <div class="doc_chat_input bottom_wrapper clearfix">
                     <div class="message_input_wrapper">
                        <input class="form-control msg_textbox" id="message_input" placeholder="Type your message here..." />
                        <input type="file" name="chat_file" id="chat-attachment" style="display:none" />
                     </div>
                     <div class="btn-group send-btn">
                        <button type="button" class="btn btn-primary btn-pill send-message">
                          <i class="tio-send"></i>
                        </button>
                        <button type="button" class="btn btn-info btn-pill send-attachment">
                          <i class="tio-attachment"></i>
                        </button>
                     </div>
                  </div>
               </div>
               <div class="message_template">
                  <li class="message">
                     <div class="avatar"></div>
                     <div class="text_wrapper">
                        <div class="text"></div>
                     </div>
                  </li>
               </div>
            </div>
            <!-- End Body -->
         </div>
      </div>
      <!-- End Sidebar -->  
      <div class="table-responsive datatable-custom">
         <table id="datatable" class="table table-borderless table-thead-bordered card-table">
            <thead class="thead-light">
               <tr>
                  <th scope="col" class="table-column-pr-0">
                     <div class="custom-control custom-checkbox">
                        <input id="datatableCheckAll" type="checkbox" class="custom-control-input">
                        <label class="custom-control-label" for="datatableCheckAll"></label>
                     </div>
                  </th>
                  <th scope="col" class="table-column-pl-0">Document Name</th>
                  <!-- <th scope="col">Folder</th> -->
                  <th scope="col"><i class="tio-chat-outlined"></i></th>
                  <!-- <th scope="col">Members</th> -->
                  <th scope="col"></th>
               </tr>
            </thead>
            <tbody>
               @foreach($case_documents as $key => $doc)
               <tr>
                  <td class="table-column-pr-0">
                     <div class="custom-control custom-checkbox">
                        <input type="checkbox" class="custom-control-input row-checkbox" id="row-{{$key}}" value="{{ base64_encode($doc->id) }}">
                        <label class="custom-control-label" for="row-{{$key}}"></label>
                     </div>
                  </td>
                  <td class="table-column-pl-0">
                     <?php 
                        $doc_url = $file_url."/".$doc->FileDetail->file_name; 
                        $url = baseUrl('cases/case-documents/view-document/'.$case_id.'/'.$doc->unique_id.'?url='.$doc_url.'&file_name='.$doc->FileDetail->file_name.'&p='.$subdomain);
                     ?>
                     <a class="d-flex align-items-center" href="{{$url}}">
                        <?php 
                           $fileicon = fileIcon($doc->FileDetail->original_name);
                           echo $fileicon;
                           $filesize = file_size($file_dir."/".$doc->FileDetail->file_name);
                        ?>
                        <div class="ml-3">
                           <span class="d-block h5 text-hover-primary mb-0">{{$doc->FileDetail->original_name}}</span>
                           <ul class="list-inline list-separator small file-specs">
                              <li class="list-inline-item">Added on {{dateFormat($doc->created_at)}}</li>
                              <li class="list-inline-item">{{$filesize}}</li>
                           </ul>
                        </div>
                     </a>
                  </td>
                  <!-- <td><a class="badge badge-soft-primary p-2" href="#">Marketing team</a></td> -->
                  <td width="10%">
                     <!-- Toggle -->
                     <div class="hs-unfold">
                        <a onclick="fetchChats('{{ $doc->case_id }}','{{ $doc->unique_id }}')" class="js-hs-unfold-invoker text-body" href="javascript:;"
                           data-hs-unfold-options='{
                           "target": "#activitySidebar",
                           "type": "css-animation",
                           "animationIn": "fadeInRight",
                           "animationOut": "fadeOutRight",
                           "hasOverlay": true,
                           "smartPositionOff": true
                           }'>
                        <i class="tio-chat-outlined"></i> {{count($doc->Chats)}}
                        </a>
                     </div>
                     <!-- End Toggle -->
                       
                  </td>
                  <!-- <td>
                     <div class="avatar-group avatar-group-xs avatar-circle">
                        <span class="avatar" data-toggle="tooltip" data-placement="top" title="Ella Lauda">
                        <img class="avatar-img" src="./assets/img/160x160/img9.jpg" alt="Image Description">
                        </span>
                        <span class="avatar" data-toggle="tooltip" data-placement="top" title="David Harrison">
                        <img class="avatar-img" src="./assets/img/160x160/img3.jpg" alt="Image Description">
                        </span>
                        <span class="avatar avatar-soft-dark" data-toggle="tooltip" data-placement="top" title="Antony Taylor">
                        <span class="avatar-initials">A</span>
                        </span>
                        <span class="avatar avatar-soft-info" data-toggle="tooltip" data-placement="top" title="Sara Iwens">
                        <span class="avatar-initials">S</span>
                        </span>
                        <span class="avatar" data-toggle="tooltip" data-placement="top" title="Finch Hoot">
                        <img class="avatar-img" src="./assets/img/160x160/img5.jpg" alt="Image Description">
                        </span>
                        <span class="avatar avatar-light avatar-circle" data-toggle="tooltip" data-placement="top" title="Sam Kart, Amanda Harvey and 1 more">
                        <span class="avatar-initials">+3</span>
                        </span>
                     </div>
                  </td> -->
                  <td>
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
                        <div id="action-{{$key}}" class="hs-unfold-content dropdown-unfold dropdown-menu dropdown-menu-right" style="min-width: 13rem;">
                           
                           <!-- <a class="dropdown-item" href="javascript:;" onclick="showPopup('<?php echo baseUrl('cases/case-documents/file-move-to/'.base64_encode($doc->id)).'/'.base64_encode($record->id).'/'.base64_encode($document->id) ?>')">
                           <i class="tio-folder-add dropdown-item-icon"></i>
                           Move to
                           </a> -->
                           <a class="dropdown-item" href="{{$doc_url}}" download>
                           <i class="tio-download-to dropdown-item-icon"></i>
                           Download
                           </a>
                           <a class="dropdown-item text-danger" href="javascript:;" onclick="confirmAction(this)" data-href="{{baseUrl('cases/case-documents/delete/'.base64_encode($doc->id))}}">
                           <i class="tio-delete-outlined dropdown-item-icon"></i>
                           Delete
                           </a>
                        </div>
                     </div>
                     <!-- End Unfold -->
                  </td>
               </tr>
               @endforeach
            </tbody>
         </table>

         @if(count($case_documents) <= 0)
         <div class="text-danger text-center p-2">
            No documents available
         </div>
         @endif
      </div>
      <!-- End Table -->
   </div>
   <!-- End Card -->
</div>
<!-- End Content -->

<!--DOC-->
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
               <!--  <div id="shot-sidebar-app" class="shot-sidebar-app">
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
                        <!----
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
                </div> -->
            </div>
        </div>
    </div>
</div>
<!--END DOC -->

@endsection
@section('javascript')
<link rel="stylesheet" href="assets/vendor/mCustomScrollbar/jquery.mCustomScrollbar.css" />
<script src="assets/vendor/mCustomScrollbar/jquery.mCustomScrollbar.min.js"></script>
<script src="assets/vendor/dropzone/dist/min/dropzone.min.js"></script>
<script type="text/javascript">
   var is_error = false;
   var case_id = '';
   var document_id = '';
   $(document).ready(function(){
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
      $(".send-message").click(function(){
         // var case_id = $("#activitySidebar").data("case-id");
         // var document_id = $("#activitySidebar").data("document-id");
         var message = $("#message_input").val();
         if(message != ''){
            $.ajax({
              type: "POST",
              url: "{{ baseUrl('cases/case-documents/send-chats') }}",
              data:{
                  _token:csrf_token,
                  case_id:case_id,
                  document_id:document_id,
                  message:message,
                  type:"text",
              },
              dataType:'json',
              beforeSend:function(){
                 // var html = '<div class="text-center"><div class="spinner-border" role="status"><span class="sr-only">Loading...</span></div>';
                 // $("#activitySidebar .messages").html(html);
                 $("#message_input,.send-message,.send-attachment").attr('disabled','disabled');
              },
              success: function (response) {
                  if(response.status == true){
                     $("#message_input,.send-message,.send-attachment").removeAttr('disabled');
                     $("#message_input").val('');
                     $("#activitySidebar .messages").html(response.html);
                     $(".messages").mCustomScrollbar();
                     $(".messages").animate({ scrollTop: $(".messages")[0].scrollHeight}, 1000);
                     $(".doc_chat_input").show();
                     fetchChats(case_id,document_id);
                  }else{
                     errorMessage(response.message);
                  }
              },
              error:function(){

               $("#message_input,.send-message,.send-attachment").removeAttr('disabled');
               internalError();
              }
            });
         }
      })
   });
   $(".send-attachment").click(function(){
      document.getElementById('chat-attachment').click();
   });
   $("#chat-attachment").change(function(){
      var formData = new FormData();
      formData.append("_token",csrf_token);
      formData.append("case_id",case_id);
      formData.append("document_id",document_id);
      formData.append('attachment', $('#chat-attachment')[0].files[0]);
      var url  = "{{ baseUrl('cases/case-documents/send-chat-file') }}";
      $.ajax({
         url:url,
         type:"post",
         data:formData,
         cache: false,
         contentType: false,
         processData: false,
         dataType:"json",
         beforeSend:function(){
            $("#message_input,.send-message,.send-attachment").attr('disabled','disabled');
         },
         success: function (response) {
            if(response.status == true){
               $("#message_input,.send-message,.send-attachment").removeAttr('disabled');
               $("#chat-attachment").val('');
               $("#activitySidebar .messages").html(response.html);
               $(".messages").mCustomScrollbar();
               $(".messages").animate({ scrollTop: $(".messages")[0].scrollHeight}, 1000);
               $(".doc_chat_input").show();
               fetchChats(case_id,document_id);
            }else{
               errorMessage(response.message);
            }
         },
         error:function(){
            $("#message_input,.send-message,.send-attachment").removeAttr('disabled');
            internalError();
         }
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
            if(response.status == true){
               $("#message_input,.send-message,.send-attachment").removeAttr('disabled');
               $("#activitySidebar .messages").html(response.html);
               setTimeout(function(){
                  $("#activitySidebar .messages").mCustomScrollbar();
                  $("#activitySidebar .messages").animate({ scrollTop: $(".messages")[0].scrollHeight}, 1000);
               },800);
               
               $(".doc_chat_input").show();
            }else{
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
                //fetchChats(case_id, document_id);
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
</script>
@endsection