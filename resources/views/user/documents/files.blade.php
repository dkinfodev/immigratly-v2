@extends('layouts.master')
@section("style")
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
</style>
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
<!-- Content -->
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
  
    <!-- End Page Header -->
    <!-- Card -->
    <div class="card">
        <!-- Header -->
        <div class="card-header">
            <div class="row">
                <div class="col-auto">
                    <div class="d-block align-items-center">
                        <div id="datatableCounterInfo" class="mr-2" style="display: none;">
                            <div class="d-flex align-items-center float-right">
                                <span class="font-size-sm mr-3">
                                    <span id="datatableCounter">0</span>
                                    Selected
                                </span>
                                <a class="btn btn-sm btn-outline-danger"
                                    data-href="{{ baseUrl('documents/files/delete-multiple') }}"
                                    onclick="deleteMultiple(this)" href="javascript:;">
                                    <i class="tio-delete-outlined"></i> Delete
                                </a>
                            </div>
                            <div class="d-flex align-items-center float-right mr-3">
                                <a class="btn btn-sm btn-outline-primary"
                                    onclick="showPopup('<?php echo baseUrl('documents/files/move-files/'.$document->unique_id) ?>')"
                                    href="javascript:;">
                                    <i class="tio-folder-add dropdown-item-icon"></i> Move To
                                </a>
                            </div>
                        </div>


                    </div>
                </div>
            </div>
            <div class="clearfix"></div>
            <div class="row justify-content-between align-items-center flex-grow-1">
               
                <div class="col-sm-6 col-md-4 mb-3 mb-sm-0">
                    <form>
                        <!-- Search -->
                        <div class="input-group input-group-merge input-group-flush">
                            <div class="input-group-prepend">
                                <div class="input-group-text">
                                    <i class="tio-search"></i>
                                </div>
                            </div>
                            <input id="datatableSearch" type="search" class="form-control"
                                placeholder="Search File" aria-label="Search File">
                        </div>
                        <!-- End Search -->
                    </form>
                </div>

                <div class="col-sm-6">
                    <div class="row mt-3">
                        <div class="col-md-6">
                            <div class="form-group">
                                <select class="select2" onchange="loadData()" id="sort_by">
                                    <option value="">Sort By</option>
                                    <option value="added_by_asc">Created at Ascending</option>
                                    <option value="added_by_desc">Created at Descending</option>
                                    <option value="name_asc">Name Ascending</option>
                                    <option value="name_desc">Name Descending</option>
                                </select>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <select class="select2" onchange="loadData()" id="file_type">
                                    <option value="">File Type</option>
                                    @for($i = 0;$i < count($extensions);$i++)
                                    <option value="{{$extensions[$i]}}">{{$extensions[$i]}}</option>
                                    @endfor
                                </select>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <!-- End Header -->
        <!-- Table -->

        <div class="datatable-custom">
            <table class="datatable table table-borderless table-thead-bordered card-table">
                <thead class="thead-light">
                    <tr>
                        <th scope="col" class="table-column-pr-0">
                            <div class="custom-control custom-checkbox">
                                <input id="datatableCheckAll" type="checkbox" class="custom-control-input">
                                <label class="custom-control-label" for="datatableCheckAll"></label>
                            </div>
                        </th>
                        <th scope="col" class="table-column-pl-0">Document Name</th>
                        <th scope="col">
                            
                        </th>
                    </tr>
                </thead>
                <tbody></tbody>
            </table>

            
    </div>
    <!-- End Table -->
</div>
<!-- End Card -->
</div>
<!-- End Content -->
<!-- End Content -->
@endsection
@section('javascript')
<script src="assets/vendor/dropzone/dist/min/dropzone.min.js"></script>
<script type="text/javascript">
$(document).ready(function() {
    initSelect();
    loadData();
    $("#datatableSearch").blur(function(){
       if($("#datatableSearch").val() == ''){
          loadData();
       }
    })
    $("#datatableSearch").keyup(function(){
      var value = $(this).val();
      if(value == ''){
         loadData();
      }
      if(value.length > 3){
         loadData();
      }
   });
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
loadData();
function loadData() {
    var search = $("#datatableSearch").val();
    var sort_by = $("#sort_by").val();
    var file_type = $("#file_type").val();
    $.ajax({
        url: BASEURL + '/documents/files/list-ajax',
        data: {
            folder_id: "{{ $document->unique_id }}",
            search: search,
            file_type:file_type,
            sort_by:sort_by
        },
        dataType: 'json',
        beforeSend: function() {
            showLoader();
        },
        success: function(data) {
            if (data.status == true) {
                $(".datatable tbody").html(data.contents);
               
                $(".row-checkbox").change(function() {
                    if ($(".row-checkbox:checked").length > 0) {
                        $("#datatableCounterInfo").show();
                    } else {
                        $("#datatableCounterInfo").hide();
                    }
                    $("#datatableCounter").html($(".row-checkbox:checked").length);
                });
                $('.js-hs-action').each(function () {
                    var unfold = new HSUnfold($(this)).init();
                });
                $(".row-checkbox").change(function(){
                    if ($(".row-checkbox:checked").length > 0) {
                        $("#datatableCounterInfo").show();
                    }else{
                        $("#datatableCounterInfo").hide();
                    }
                    $("#datatableCounter").html($(".row-checkbox:checked").length);
                });
                hideLoader();
            } else {
                errorMessage('Error while pin the folder');
            }
        },
        error: function() {
            internalError();
        }
    });
}

</script>
@endsection