@extends('layouts.master')

@section('breadcrumb')
<!-- Content -->
<ol class="breadcrumb breadcrumb-no-gutter">
  <li class="breadcrumb-item"><a class="breadcrumb-link" href="{{ baseUrl('/') }}">Dashboard</a></li>
  <li class="breadcrumb-item active" aria-current="page">{{$pageTitle}}</li>
</ol>
<!-- End Content -->
@endsection



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
                <div class="col-sm-auto">
                    <div role="group">
                        @if($user_detail->dropbox_auth != '')
                        <a class="btn btn-outline-primary"
                            onclick="showPopup('<?php echo baseUrl('documents/dropbox/folder/'.$document->unique_id) ?>')"
                            href="javascript:;"><i class="tio-google-drive mr-1"></i> Upload from Dropbox</a>
                        @endif
                        @if($user_detail->google_drive_auth != '')
                        <a class="btn btn-outline-primary"
                            onclick="showPopup('<?php echo baseUrl('documents/google-drive/folder/'.$document->unique_id) ?>')"
                            href="javascript:;"><i class="tio-google-drive mr-1"></i> Upload from Google Drive</a>
                        @endif
                        <a class="upload-btn btn btn-info collapsed" href="javascript:;" data-toggle="collapse" data-target="#collapseOne"
                            aria-expanded="true" aria-controls="collapseOne"><i class="tio-upload-on-cloud mr-1"></i>
                            Upload
                            <span class="ml-2 card-btn-toggle">
                                <i class="fa fa-plus plus text-white"></i>
                                <i class="fa fa-minus minus text-white"></i>
                            </span>
                        </a>
                        <a class="btn btn-primary" href="{{ baseUrl('/documents') }}">Back</a>
                    </div>
                </div>
            </div>
            <!-- End Row -->
        </div>
        <!-- End Page Header -->
    </div>
</div>
<!-- End Content -->
@endsection
@section('content')

<link rel="stylesheet" href="assets/vendor/mCustomScrollbar/jquery.mCustomScrollbar.css" />

<link rel="stylesheet" href="assets/css/jquery.mThumbnailScroller.css">
<style>
.all_services li {
    padding: 16px;
    border-bottom: 1px solid #ddd;
}

.sub_services li {
    border-bottom: none;
}
.dz-error-message {
    color: red;
}
.upload-btn .btn-default{
    display:none;
}
.upload-btn.collapsed .plus{
    display: block !important;
}
.upload-btn:not(.collapsed) .plus{
    display:none !important;
}
.upload-btn.collapsed .minus {
    display: none;
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
<div class="files">
    <div id="collapseOne" class="collapse" aria-labelledby="headingOne">
        <div class="card-body">
            <div class="float-right">
                <button type="button" onclick="clearDropzone()" class="btn btn-outline-danger mb-3"><i class="tio-delete"></i> Clear Files</button>
            </div>
            <div class="clearfix"></div>
            <!-- Dropzone -->
            <div id="attachFilesLabel" class="js-dropzone dropzone-custom custom-file-boxed"
                data-hs-dropzone-options='{
                "url": "<?php echo baseUrl('documents/files/upload-documents') ?>?_token=<?php echo csrf_token() ?>&folder_id=<?php echo $document->unique_id ?>",
                "thumbnailWidth": 100,
                "thumbnailHeight": 100,
                "maxFilesize":18,
                "acceptedFiles":"{{$ext_files}}"
            }'>
                <div class="dz-message custom-file-boxed-label">
                    <img class="avatar avatar-xl avatar-4by3 mb-3" src="./assets/svg/illustrations/browse.svg"
                        alt="Image Description">
                    <h5 class="mb-1">Drag and drop your file here</h5>
                    <p class="mb-2">or</p>
                    <span class="btn btn-sm btn-white">Browse files</span>
                </div>
            </div>
            <!-- End Dropzone -->
        </div>
    </div>
    <!-- Page Header -->
</div>

    <!-- End Page Header -->
    <!-- Card -->
    <div class="caard">
        <!-- Header -->
          
            <div class="">
            
            <ul class="list-group">
                <!-- List Item -->
                @foreach($user_documents as $key => $doc)
                  <?php 
                     $doc_url = $file_url."/".$doc->FileDetail->file_name; 
                     $url = baseUrl('documents/files/view-document/'.$doc->unique_id.'?url='.$doc_url.'&file_name='.$doc->FileDetail->file_name.'&folder_id='.$document->unique_id);
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
                                <a data-href="{{$url}}" onclick="previewDocument(this)" data-filename="{{$doc->FileDetail->original_name}}" data-documentid="{{ $doc->unique_id }}"  class="text-dark" href="javascript:;" data-toggle="modal"
                                    data-target=".bd-example-modal-fs">{{$doc->FileDetail->original_name}}</a>
                            </h5>
                            <ul class="list-inline list-separator small">
                                <li class="list-inline-item">Added on {{dateFormat($doc->created_at)}}</li>
                                <li class="list-inline-item">{{$filesize}}</li>
                                
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

                                    <a class="dropdown-item" href="{{$doc_url}}" download>
                                    <i class="tio-download-to dropdown-item-icon"></i>
                                    Download
                                    </a>
                                    <a class="dropdown-item" href="javascript:;" onclick="showPopup('<?php echo baseUrl('documents/files/file-move-to/'.$doc->unique_id) ?>')">
                                      <i class="tio-folder-add dropdown-item-icon"></i>
                                    Move to
                                    </a>

                                    <a class="dropdown-item" href="javascript:;" onclick="showPopup('<?php echo baseUrl('documents/files/rename-file/'.$doc->file_id) ?>')">
                                        <i class="tio-edit dropdown-item-icon"></i>
                                        Rename
                                    </a>
                                    <div class="dropdown-divider"></div>
                                    <a class="dropdown-item text-danger" href="javascript:;" onclick="confirmAction(this)" data-href="{{baseUrl('documents/files/delete/'.base64_encode($doc->id))}}">
                                    <i class="tio-delete-outlined dropdown-item-icon"></i>
                                    Delete
                                    </a>
                                    
                                </div>
                            </div>
                            <!-- End Unfold -->
                            <!-- End Unfold -->
                        </div>
                    </div>
                    <!-- End Row -->
                </li>
                @endforeach
                <!-- End List Item -->

            </ul>

            </div>
        </div>    
        
    </div>
<!-- End Card -->
</div>
<!-- End Content -->
<!-- DOC -->
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
                            @foreach($user_documents as $key => $doc)
                            <?php 
                                
                                 $doc_url = $file_url."/".$doc->FileDetail->file_name;
                                

                                 $url = baseUrl('documents/files/view-document/'.$doc->unique_id.'?url='.$doc_url.'&file_name='.$doc->FileDetail->file_name.'&folder_id='.$document->unique_id);

                            ?>
                                <li class="{{ $doc->unique_id }}">
                                    <a onclick="previewDocument(this)" data-filename="{{ $doc->FileDetail->original_name }}" data-documentid="{{ $doc->unique_id }}" class="card card-sm card-hover-shadow text-center" href="javascript:;" data-href="{{$url}}">
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
                        <div id="document-preview"></div>
                        <!-- <iframe src="https://immigratly.com/public/uploads/professional/abc9/documents/39672-Document Checklist SOWP - student.pdf" style="margin:0 auto;width:100%;height: 100vh;" frameborder="0"></iframe> -->
                    </div>
                </div>
                <div id="shot-sidebar-app" class="shot-sidebar-app">
                    <!-- <div class="shot-sidebar-open-contents">
                        <div class="comment-document active-comment">
                            <a href="javascript:;" onclick="viewChats()" id="comment-trigger"
                                class="comment-document-link">
                                <span class="comment-document-counter"></span>
                                <img class="avatar avatar-4by3 comment-document-image"
                                    src="assets/svg/message/chat-blue.svg" alt="Image Description">
                            </a>
                        </div>
                    </div> -->
                    <div class="shot-actions-toolbar-wrapper">
                        <!---->
                    </div>
                    <div class="shot-sidebar sidebar-open">
                        <!-- <div class="shot-sidebar-content">
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
                        </div> -->
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<!-- END DOC -->

@endsection
@section('javascript')

<link rel="stylesheet" href="assets/css/jquery.mThumbnailScroller.css">
<script src="assets/vendor/mCustomScrollbar/jquery.mCustomScrollbar.min.js"></script>
<script src="assets/vendor/dropzone/dist/min/dropzone.min.js"></script>
<script src="assets/js/jquery.slidereveal.js"></script>
<script src="assets/js/jquery.mThumbnailScroller.js"></script>

<script type="text/javascript">

   var document_id;
   var is_error = false;
   var sample1;

$(document).ready(function() {
    //initSelect();
      
      $("#document-preview-thumbs-content").mThumbnailScroller({
        axis: "y",
        type: "click-50",
        theme: "buttons-out"
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

});
var is_error = false;
var dropzone;
dropzone = $.HSCore.components.HSDropzone.init('#attachFilesLabel');
dropzone.on("success", function(file, response) {
    if (response.status == false) {
        is_error = true;
    }
});
dropzone.on('addedfile', function(file) {
    is_error = false;
});
dropzone.on("queuecomplete", function() {
   
    if (is_error == true) {
        errorMessage("Error while upload file");
    } else {
        // successMessage("Files uploaded successfully");
        // clearDropzone();
        loadData();
    }
});
dropzone.on('complete', function(file) {
  
});
function clearDropzone(){
    dropzone.removeAllFiles(true);
}

function deleteFiles() {
    if ($(".row-checkbox:checked").length > 0) {
        var files = [];
        $(".row-checkbox:checked").each(function() {
            files.push($(this).val());
        })
        $.ajax({
            type: "POST",
            url: BASEURL + '/cases/remove-documents',
            data: {
                _token: csrf_token,
                files: files,
            },
            dataType: 'json',
            beforeSend: function() {
                showLoader();
            },
            success: function(data) {
                if (data.status == true) {
                    // location.reload();
                } else {
                    errorMessage('Error while pin the folder');
                }
            },
            error: function() {
                internalError();
            }
        });
    } else {
        errorMessage("No files selected");
    }
}

function previewDocument(e){
    var url = $(e).attr("data-href");
    // case_id = $(e).attr("data-caseid");
    var file_name = $(e).attr("data-filename")
    document_id = $(e).attr("data-documentid");
    $("#document-preview-thumbs-content .mTSThumbContainer").removeClass("active");
    $("#document-preview-thumbs-content ."+document_id).addClass("active");
    $(".document-content .document_id").val(document_id);
    // $(".document-content .case_id").val(case_id);
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
            //$("#message_input,.send-message,.send-attachment").removeAttr(
              //  'disabled');
            internalError();
        }
    });
}



</script>
@endsection