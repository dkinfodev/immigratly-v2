@extends('layouts.master')
<style>
.all_services li {
    padding: 16px;
    border-bottom: 1px solid #ddd;
}

.sub_services li {
    border-bottom: none;
}

.document-exchange {
    cursor: move;
    padding: 10px 0px;
}

.droppable {
    min-height: 65px;
}

.document-drop {
    list-style: none;
    padding: 10px 0px;
    border: 0.0625rem solid #e7eaf3;
}

.professional-request-folders .folder-label-professional {

    z-index: 10 !important;
}
</style>

@section('breadcrumb')
<!-- Content -->
<ol class="breadcrumb breadcrumb-no-gutter">
    <li class="breadcrumb-item"><a class="breadcrumb-link" href="{{ baseUrl('/') }}">Dashboard</a></li>
    <li class="breadcrumb-item"><a class="breadcrumb-link" href="{{ baseUrl('/cases') }}">Cases</a></li>
    <li class="breadcrumb-item active" aria-current="page">{{$pageTitle}}</li>
</ol><!-- End Content -->
@endsection


@section('content')
<!-- Page Header -->
@include(roleFolder().'.cases.case-navbar')
<div class="float-right">
@if(isset($_GET['stage_id']))
      <a class="btn btn-primary btn-sm" href="{{baseUrl('cases/stages/'.$subdomain.'/'.$case_id)}}">Back to Stage</a>
   @php 
      $qs = '&stage_id='.$_GET['stage_id'];
   @endphp
   @endif
</div>
<div class="row">
    <div class="col-lg-9 mb-5 mb-lg-0">
        <h2 class="h4 mb-3">Pinned access <i class="tio-help-outlined text-muted" data-toggle="tooltip"
                data-placement="right" title="Pinned access to files you've been working on."></i></h2>
        <!-- Pinned Access -->
        <div class="row row-cols-1 row-cols-sm-2 row-cols-md-3 row-cols-lg-4 mb-5">
            @foreach($pin_folders as $folder)
            <?php
                    $file_counts = countFolderFiles($case_id,$folder->folder_id,$folder->folder_type,$subdomain);
                    if($folder->folder_type == 'mydoc'){
                        $folder_data = $folder->myDoc($folder->folder_id);
                    }
                    elseif($folder->folder_type == 'default'){
                        $folder_data = $folder->defaultDoc($folder->folder_id);
                    }
                    else{
                        $folder_data = $folder->caseDoc($folder->folder_id,$subdomain);
                    }

                    if($folder->folder_type != 'mydoc'){
                        $furl = baseUrl("cases/documents/".$folder->folder_type."/".$subdomain."/".$case_id."/".$folder->folder_id);
                    }else{
                        $furl = baseUrl("documents/files/lists/".$folder->folder_id);
                    }
                ?>
            <div class="col mb-3 mb-lg-5">
                <!-- Card -->
                <div class="card card-sm card-hover-shadow h-100 text-center" href="javascript:;">
                    <!-- Checkbox -->
                    <div class="custom-control custom-checkbox-switch card-pinned">
                        <input type="checkbox" onchange="unpinFolder(this)" data-foldertype="{{$folder->folder_type}}"
                            data-folderid="{{$folder->folder_id}}" data-pinid="{{$folder->id}}" id="starredCheckbox1"
                            class="custom-control-input custom-checkbox-switch-input" checked>
                        <label class="custom-checkbox-switch-label btn-icon btn-xs rounded-circle"
                            for="starredCheckbox1">
                            <span class="custom-checkbox-switch-default" data-toggle="tooltip" data-placement="top"
                                title="Unpin">
                                <i class="tio-star-outlined"></i>
                            </span>
                            <span class="custom-checkbox-switch-active" data-toggle="tooltip" data-placement="top"
                                title="Unpin">
                                <i class="tio-star"></i>
                            </span>
                        </label>
                        <!-- <a title="Unpin Folder" href="javascript:;" class="btn btn-sm btn-info js-nav-tooltip-link"><i class="tio-pin"></i></a> -->
                    </div>
                    <!-- End Checkbox -->
                    <div class="card-body">
                        @if($file_counts > 0)
                        <img class="avatar avatar-4by3" src="assets/svg/folder-files.svg" alt="Image Description">
                        @else
                        <img class="avatar avatar-4by3" src="assets/svg/folder.svg" alt="Image Description">
                        @endif
                    </div>


                    <div class="card-footer border-top-0">
                        <a href="{{$furl}}">
                            <span class="d-block font-size-sm text-muted mb-1">{{$file_counts}} files</span>
                            @if(!empty($folder_data))
                            <h5>{{$folder_data->name}} </h5>
                            @else
                            <h5>N/A</h5>
                            @endif
                        </a>

                    </div>
                </div>
                <!-- End Card -->
            </div>
            @endforeach
        </div>
        <!-- End Pinned Access -->

        <!-- Header -->

        <!-- End Header -->
        <!-- <div class="row align-items-center mb-2">
            <div class="col">
                <h2 class="h4 mb-0">Files</h2>
            </div>

            <div class="col-auto">

            </div>
        </div> -->
        <!-- Tab Content -->
        <div class="tab-content" id="professionalTabContent">

            <div class="tab-pane fade show active professional-request-folders" id="list" role="tabpanel"
                aria-labelledby="list-tab">
                <span class="folder-label-professional">Professional Request</span>
                <ul class="list-group professional-request-folders-list droppable" id="accordionProfessionalDoc">
                    <!-- List Item -->
                    @foreach($case_folders as $key => $document)
                   
                    @if($document['added_by'] == 'client')
                    <li class="list-group-item" data-foldername="{{$document['name']}}"
                        data-folder="{{$document['unique_id']}}">
                        @else
                    <li class="list-group-item" data-folder="{{$document['unique_id']}}">
                        @endif

                        <div class="row align-items-center">
                            <div class="col-auto">
                                @if($document['files_count'] > 0)
                                <img class="avatar avatar-xs avatar-4by3" src="assets/svg/folder-files.svg"
                                    alt="Image Description">
                                @else
                                <img class="avatar avatar-xs avatar-4by3" src="assets/svg/folder.svg"
                                    alt="Image Description">
                                @endif

                            </div>

                            <div class="col">
                                <a href="<?php echo baseUrl("cases/documents/extra/".$subdomain."/".$case_id."/".$document['unique_id']) ?>"
                                    data-subdomain="{{$subdomain}}" data-doctype="extra" data-caseid="{{$case_id}}"
                                    data-docid="{{ $document['unique_id'] }}">

                                   
                                    <h5 class="mb-0">
                                        {{$document['name']}}
                                    </h5>
                                    <ul class="list-inline list-separator small">
                                        <li class="list-inline-item">{{$document['files_count']}} Files</li>
                                        <?php
                                                
                                                $doc_chats = countUnreadDocChat($case_id,$subdomain,"client",$document['unique_id']);
                                                if($doc_chats > 0){
                                            ?>
                                        <li class="list-inline-item text-danger">{{$doc_chats}} chats</li>
                                        <?php }else{
                                                $doc_chats = countReadDocChat($case_id,$subdomain,"client",$document['unique_id']);
                                            ?>
                                        <li class="list-inline-item text-dark">{{$doc_chats}} chats</li>
                                        <?php
                                            } ?>

                                    </ul>
                                </a>
                            </div>
                            <div class="col-auto">
                               
                                @if($document['added_by'] == 'client')
                                <a href="javascript:;" onclick="confirmAction(this)"
                                    data-href="{{baseUrl('cases/documents/remove-case-folder/'.$subdomain.'/'.$document['unique_id'])}}"
                                    class="btn btn-sm btn-danger js-nav-tooltip-link" data-toggle="tooltip"
                                    data-html="true" title="Delete Folder"><i class="tio-delete"></i></a>

                                @endif
                                <?php
                                        $checkPin = pinCaseFolder($case_id,$document['unique_id'],'extra');
                                        
                                        if(!empty($checkPin)){
                                    ?>
                                <a title="Unpin Folder" href="javascript:;" onclick="unpinFolder(this)"
                                    data-foldertype="extra" data-folderid="{{$document['unique_id']}}"
                                    data-pinid="{{$checkPin->id}}" class="btn btn-sm btn-info js-nav-tooltip-link"><i
                                        class="tio-pin"></i></a>
                                <?php }else{ ?>
                                <a title="Pin Folder" href="javascript:;" onclick="pinFolder(this)"
                                    data-foldertype="extra" data-folderid="{{$document['unique_id']}}"
                                    class="btn btn-sm btn-primary js-nav-tooltip-link"><i class="tio-pin"></i></a>
                                <?php } ?>
                            </div>

                            <div id="collapseProfessionalDoc-{{$key}}" class="collapse files-collapse"
                                aria-labelledby="headingProfessional-{{$key}}" data-parent="#accordionProfessionalDoc">
                            </div>
                        </div>
                        <!-- End Row -->
                    </li>
                    <!-- End List Item -->
                    @endforeach

                    <?php
                        $default_documents = $service['Documents'];
                    ?>
                    @foreach($default_documents as $key => $document)
               
                    <li class="list-group-item" data-foldername="{{$document['name']}}"
                        data-folder="{{$document['name']}}" data-doctype="default"
                        data-docid="{{ $document['unique_id'] }}">
                      
                        <div class="row">
                            <div class="col-auto">
                                @if($document['files_count'] > 0)
                                <img class="avatar avatar-xs avatar-4by3" src="assets/svg/folder-files.svg"
                                    alt="Image Description">
                                @else
                                <img class="avatar avatar-xs avatar-4by3" src="assets/svg/folder.svg"
                                    alt="Image Description">
                                @endif
                            </div>

                            <div class="col" data-toggle="collapse" data-target="#collapseDefaultDoc-{{ $key }}"
                                aria-expanded="true" aria-controls="collapseDefaultDoc-{{ $key }}">
                                <a href="<?php echo baseUrl("cases/documents/default/".$subdomain."/".$case_id."/".$document['unique_id']) ?>"
                                    data-subdomain="{{$subdomain}}" data-doctype="default" data-caseid="{{$case_id}}"
                                    data-docid="{{ $document['unique_id'] }}">
                                    <h5 class="mb-0">
                                        {{$document['name']}}
                                    </h5>
                                    <ul class="list-inline list-separator small">
                                        <li class="list-inline-item">{{count($document['files_count'])}} Files</li>
                                        <?php
                                                $doc_chats = countUnreadDocChat($case_id,$subdomain,"client",$document['unique_id']);
                                                if($doc_chats > 0){
                                            ?>
                                        <li class="list-inline-item text-danger">{{$doc_chats}} chats</li>
                                        <?php }else{
                                                $doc_chats = countReadDocChat($case_id,$subdomain,"client",$document['unique_id']);
                                            ?>
                                        <li class="list-inline-item text-dark">{{$doc_chats}} chats</li>
                                        <?php
                                            } 
                                            ?>
                                    </ul>
                                </a>
                            </div>
                            <div class="col-auto">
                                <?php
                                    $checkPin = pinCaseFolder($case_id,$document['unique_id'],'default');
                                    
                                    if(!empty($checkPin)){
                                ?>
                                <a title="Unpin Folder" href="javascript:;" onclick="unpinFolder(this)"
                                    data-foldertype="default" data-folderid="{{$document['unique_id']}}"
                                    data-pinid="{{$checkPin->id}}" class="btn btn-sm btn-info js-nav-tooltip-link"><i
                                        class="tio-pin"></i></a>
                                <?php }else{ ?>
                                <a title="Pin Folder" href="javascript:;" onclick="pinFolder(this)"
                                    data-foldertype="default" data-folderid="{{$document['unique_id']}}"
                                    class="btn btn-sm btn-primary js-nav-tooltip-link"><i class="tio-pin"></i></a>
                                <?php } ?>
                                <!-- <a href="<?php echo baseUrl("cases/documents/default/".$subdomain."/".$case_id."/".$document['unique_id']) ?>" 
                                        class="btn btn-sm btn-warning js-nav-tooltip-link" data-toggle="tooltip"
                                        data-html="true" title="View Documents"><i class="tio-documents"></i></a> -->

                            </div>
                            <div id="collapseDefaultDoc-{{$key}}" class="collapse files-collapse"
                                aria-labelledby="headingDefault-{{$key}}" data-parent="#accordionProfessionalDoc">

                            </div>
                        </div> 
                        <!-- End Row -->
                    </li>
                    <!-- End List Item -->
                    @endforeach
                    @foreach($documents as $key => $document)
                  
                    <!-- List Item -->
                    <li class="list-group-item" data-foldername="{{$document['name']}}"
                        data-folder="{{$document['name']}}" data-doctype="other"
                        data-docid="{{ $document['unique_id'] }}">
                        <div class="row align-items-center gx-2">
                            <div class="col-auto">
                                @if($document['files_count'] > 0)
                                <img class="avatar avatar-xs avatar-4by3" src="assets/svg/folder-files.svg"
                                    alt="Image Description">
                                @else
                                <img class="avatar avatar-xs avatar-4by3" src="assets/svg/folder.svg"
                                    alt="Image Description">
                                @endif
                            </div>

                            <div class="col" data-toggle="collapse" data-target="#collapseDefaultDoc-{{ $key }}"
                                aria-expanded="true" aria-controls="collapseOtherDoc-{{ $key }}">
                                <a href="<?php echo baseUrl("cases/documents/other/".$subdomain."/".$case_id."/".$document['unique_id']) ?>"
                                    data-subdomain="{{$subdomain}}" data-doctype="other" data-caseid="{{$case_id}}"
                                    data-docid="{{ $document['unique_id'] }}">
                                    <h5 class="mb-0">
                                        {{$document['name']}}
                                    </h5>
                                    <ul class="list-inline list-separator small">
                                        <li class="list-inline-item">{{count($document['files_count'])}} Files</li>
                                    </ul>
                                </a>
                            </div>
                            <div class="col-auto">
                                <?php
                                    $checkPin = pinCaseFolder($case_id,$document['unique_id'],'other');
                                    
                                    if(!empty($checkPin)){
                                ?>
                                <a title="Unpin Folder" href="javascript:;" onclick="unpinFolder(this)"
                                    data-foldertype="other" data-folderid="{{$document['unique_id']}}"
                                    data-pinid="{{$checkPin->id}}" class="btn btn-sm btn-info js-nav-tooltip-link"><i
                                        class="tio-pin"></i></a>
                                <?php }else{ ?>
                                <a title="Pin Folder" href="javascript:;" onclick="pinFolder(this)"
                                    data-foldertype="other" data-folderid="{{$document['unique_id']}}"
                                    class="btn btn-sm btn-primary js-nav-tooltip-link"><i class="tio-pin"></i></a>
                                <?php } ?>
                                <!-- <a href="<?php echo baseUrl("cases/documents/other/".$subdomain."/".$case_id."/".$document['unique_id']) ?>" 
                                        class="btn btn-sm btn-warning js-nav-tooltip-link" data-toggle="tooltip"
                                        data-html="true" title="View Documents"><i class="tio-documents"></i></a> -->

                            </div>
                            <div id="collapseOtherDoc-{{$key}}" class="collapse files-collapse"
                                aria-labelledby="headingOther-{{$key}}" data-parent="#accordionProfessionalDoc"></div>
                        </div>
                        <!-- End Row -->
                    </li>
                    <!-- End List Item -->
                    @endforeach
                </ul>
            </div>
        </div>
        <!-- End Tab Content -->
        <!-- Header -->
        <div class="row align-items-center mb-2 mt-4">
            <div class="col">
                <h2 class="h4 mb-0">Files</h2>
            </div>

            <div class="col-auto">
                <!-- Nav -->

                <!-- End Nav -->
            </div>
        </div>
        <!-- End Header -->



    </div>

    <!-- Sticky Block End Point -->
    <div class="col-lg-3">

    </div>
</div>
<div class="row">
    <div class="col-lg-9 mb-5 mb-lg-0">
        <!-- Tab Content -->
        <div class="tab-content" id="connectionsTabContent">
            <div class="mb-2 text-right">
                <a onclick="showPopup('{{ baseUrl('documents/add-folder') }}')" class="btn btn-outline-primary"
                    href="javascript:;">
                    <i class="tio-folder-add mr-1"></i> Add folder
                </a>
            </div>
            <div class="tab-pane fade show active professional-request-folders" id="list" role="tabpanel"
                aria-labelledby="list-tab">
                <span class="folder-label-professional">My Documents</span>
                <ul class="list-group" id="accordionMyDoc">
                    <!-- List Item -->
                    @if(count($user_folders) > 0)
                    @foreach($user_folders as $key => $document)
                    <li class="list-group-item draggable document-folder" data-foldername="{{$document->name}}"
                        data-folder="{{$document->name}}" data-doctype="default"
                        data-docid="{{ $document->unique_id }}">
                        <div class="row">
                            <div class="col-auto">
                                @if(count($document->Files) > 0)
                                <img class="avatar avatar-xs avatar-4by3" src="assets/svg/folder-files2.svg"
                                    alt="Image Description">
                                @else
                                <img class="avatar avatar-xs avatar-4by3" src="assets/svg/folder-green.svg"
                                    alt="Image Description">
                                @endif

                            </div>

                            <div class="col" data-toggle="collapse" data-target="#collapseMyDoc-{{ $key }}"
                                aria-expanded="true" aria-controls="collapseMyDoc-{{ $key }}">
                                <a href="javascript:;" onclick="fetchUserFiles(this)"
                                    data-docid="{{ $document->unique_id }}">
                                    <h5 class="mb-0">
                                        {{$document->name}}
                                    </h5>
                                    <ul class="list-inline list-separator small">
                                        <li class="list-inline-item">{{count($document->Files)}} Files</li>

                                    </ul>
                                </a>
                            </div>
                            <div class="col-auto">
                                <?php
                                    $checkPin = pinCaseFolder($case_id,$document['unique_id'],'mydoc');
                                    
                                    if(!empty($checkPin)){
                                ?>
                                <a title="Unpin Folder" href="javascript:;" onclick="unpinFolder(this)"
                                    data-foldertype="mydoc" data-folderid="{{$document['unique_id']}}"
                                    data-pinid="{{$checkPin->id}}" class="btn btn-sm btn-info js-nav-tooltip-link"><i
                                        class="tio-pin"></i></a>
                                <?php }else{ ?>
                                <a title="Pin Folder" href="javascript:;" onclick="pinFolder(this)"
                                    data-foldertype="mydoc" data-folderid="{{$document['unique_id']}}"
                                    class="btn btn-sm btn-primary js-nav-tooltip-link"><i class="tio-pin"></i></a>
                                <?php } ?>
                                <!-- <a href="<?php echo baseUrl("cases/documents/other/".$subdomain."/".$case_id."/".$document['unique_id']) ?>" 
                                        class="btn btn-sm btn-warning js-nav-tooltip-link" data-toggle="tooltip"
                                        data-html="true" title="View Documents"><i class="tio-documents"></i></a> -->

                            </div>
                            <div id="collapseMyDoc-{{$key}}" class="collapse files-collapse"
                                aria-labelledby="headingDefault-{{$key}}" data-parent="#accordionMyDoc">

                            </div>
                        </div>
                        <!-- End Row -->
                    </li>
                    <!-- End List Item -->
                    @endforeach
                    @else
                    <li class="list-group-item mt-3 text-center text-danger">No Personal Folders</li>
                    @endif
                </ul>
            </div>
        </div>
        <!-- End Tab Content -->
    </div>
    <div class="col-lg-3">
        <div class="folder-btn">
            <a class="btn btn-info w-100 mb-3"
                href="{{ baseUrl('cases/import-to-my-documents/'.$subdomain.'/'.$record['unique_id']) }}">
                Import to My Documents
            </a>
            <a class="btn btn-primary w-100 mb-3"
                href="{{ baseUrl('cases/my-documents-exchanger/'.$subdomain.'/'.$record['unique_id']) }}">
                Export from My Documents
            </a>
            <a class="btn btn-success w-100 mb-3"
                href="{{ baseUrl('cases/documents-exchanger/'.$subdomain.'/'.$record['unique_id']) }}">
                Documents Exchanger
            </a>


        </div>
    </div>

</div>
@endsection

@section('javascript')
<!-- JS Front -->
<link rel="stylesheet" href="assets/vendor/jquery-ui/jquery-ui.css">
<script src="assets/vendor/jquery-ui/jquery-ui.js"></script>

<!-- <script src="assets/vendor/hs-sticky-block/dist/hs-sticky-block.min.js"></script> -->
<script type="text/javascript">
// initEditor("description"); 
$(document).on('ready', function() {
    $('[data-toggle="tooltip"]').tooltip();
    $('.js-nav-tooltip-link').tooltip({
        boundary: 'window'
    });
    // $('.js-sticky-block').each(function () {
    //     var stickyBlock = new HSStickyBlock($(this), {
    //         targetSelector: $('#header').hasClass('navbar-fixed') ? '#header' : null
    //     }).init();
    // });
    $('.draggable').draggable({
        revert: true,
        revertDuration: 0,
        stack: ".draggable",
        refreshPositions: false
        //helper: 'clone'
    });
    $('.droppable').droppable({
        accept: ".draggable",
        activeClass: "ui-state-highlight",
        drop: function(event, ui) {
            var droppable = $(this);
            var draggable = ui.draggable;
            var clone = draggable.clone();
            //   var parent = draggable.parents(".professional-request-folders-list");
            var folder = draggable.attr("data-foldername");
            //   alert(docid);
            var is_docid = false;
            $(".professional-request-folders-list li[data-foldername]").each(function() {
                var cur_folder = $(this).data("foldername");

                if (cur_folder == folder) {
                    is_docid = true;
                }
            });

            //   $("."+parent).find("li[data-id='"+id+"']").remove();
            //   var document_type = $(this).parents(".documents").data("type");
            //   var folder_id = $(this).parents(".documents").data("file");

            if (is_docid == true) {
                errorMessage("Folder already exists, you can copy files to it.");
                return false;
            }
            $(this).append(clone);
            clone.css({
                top: '5px',
                left: '5px'
            });

            var case_id = "{{$case_id}}";
            var subdomain = "{{$subdomain}}";
            var folder_ids = [];
            var doctype = [];
            $(".professional-request-folders-list .document-folder").each(function() {
                folder_ids.push({
                    "folder_id": $(this).data("docid"),
                    "doctype": $(this).data("doctype")
                });
                // doctype.push($(this).data("doctype"));
            });
            $.ajax({
                type: "POST",
                url: BASEURL + '/cases/documents/copy-folder-to-extra',
                data: {
                    _token: csrf_token,
                    folder_ids: folder_ids,
                    subdomain: "{{ $subdomain }}",
                    case_id: "{{ $case_id }}"
                },
                dataType: 'json',
                beforeSend: function() {
                    showLoader();
                },
                success: function(data) {
                    hideLoader();
                    if (data.status == true) {
                        bottomMessage(data.message, 'success');
                    } else {
                        errorMessage('Issue while file transfer');
                    }
                },
                error: function() {
                    internalError();
                }
            });
        }
    });
});

function fetchUserFiles(e) {

    var doc_id = $(e).attr("data-docid");
    $.ajax({
        url: "{{ baseUrl('cases/documents/fetch-user-documents') }}",
        type: "POST",
        data: {
            _token: csrf_token,
            case_id: "{{$case_id}}",
            subdomain: "{{$subdomain}}",
            doc_id: doc_id
        },
        dataType: "json",
        beforeSend: function() {
            showLoader();
        },
        success: function(response) {
            hideLoader();
            if (response.status == true) {
                $(e).parents("li").find(".collapse").html(response.contents);
            } else {
                errorMessage(response.message);
            }
        },
        error: function() {
            hideLoader();
        }
    });
}

function fetchFiles(e) {
    var case_id = $(e).attr("data-caseid");
    var doctype = $(e).attr("data-doctype");
    var subdomain = $(e).attr("data-subdomain");
    var doc_id = $(e).attr("data-docid");
    $.ajax({
        url: "{{ baseUrl('cases/documents/fetch-documents') }}",
        type: "POST",
        data: {
            _token: csrf_token,
            case_id: case_id,
            doctype: doctype,
            subdomain: subdomain,
            doc_id: doc_id
        },
        dataType: "json",
        beforeSend: function() {
            showLoader();
        },
        success: function(response) {
            hideLoader();
            if (response.status == true) {
                $(e).parents("li").find(".collapse").html(response.contents);
            } else {
                errorMessage(response.message);
            }
        },
        error: function() {
            hideLoader();
        }
    });
}

function pinFolder(e) {
    var folder_type = $(e).attr("data-foldertype");
    var folder_id = $(e).attr("data-folderid");
    var subdomain = "{{$subdomain}}";
    $.ajax({
        url: "{{ baseUrl('cases/documents/pin-case-folder') }}",
        type: "POST",
        data: {
            _token: csrf_token,
            case_id: "{{$case_id}}",
            folder_type: folder_type,
            subdomain: subdomain,
            pin_status: 1,
            folder_id: folder_id
        },
        dataType: "json",
        beforeSend: function() {
            showLoader();
        },
        success: function(response) {
            hideLoader();
            if (response.status == true) {
                successMessage(response.message);
                location.reload();
            } else {
                errorMessage(response.message);
            }
        },
        error: function() {
            hideLoader();
        }
    });
}

function unpinFolder(e) {
    var folder_type = $(e).attr("data-foldertype");
    var folder_id = $(e).attr("data-folderid");
    var pin_id = $(e).attr("data-pinid");
    var subdomain = "{{$subdomain}}";
    $.ajax({
        url: "{{ baseUrl('cases/documents/pin-case-folder') }}",
        type: "POST",
        data: {
            _token: csrf_token,
            case_id: "{{$case_id}}",
            folder_type: folder_type,
            subdomain: subdomain,
            pin_status: 0,
            pin_id: pin_id,
            folder_id: folder_id
        },
        dataType: "json",
        beforeSend: function() {
            showLoader();
        },
        success: function(response) {
            hideLoader();
            if (response.status == true) {
                successMessage(response.message);
                location.reload();

            } else {
                errorMessage(response.message);
            }
        },
        error: function() {
            hideLoader();
        }
    });
}
</script>

@endsection