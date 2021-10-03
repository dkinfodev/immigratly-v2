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
</style>
@endsection
@section('content')
<!-- Content -->
<div class="content container-fluid">
  <div class="page-header">
    <div class="row align-items-end">
      <div class="col-sm mb-2 mb-sm-0">
        <nav aria-label="breadcrumb">
          <ol class="breadcrumb breadcrumb-no-gutter">
            <li class="breadcrumb-item"><a class="breadcrumb-link" href="{{ baseUrl('/') }}">Dashboard</a></li>
            <li class="breadcrumb-item"><a class="breadcrumb-link" href="{{ baseUrl('/cases') }}">Cases</a></li>
            <li class="breadcrumb-item active" aria-current="page">{{$pageTitle}}</li>
          </ol>
        </nav>
        <h1 class="page-title">{{$pageTitle}}</h1>
        <div class="text-dark">{{$record->case_title}}</div>
      </div>
      <div class="col-sm-auto">
        @if(role_permission('cases','documents-exchanger'))
        <a class="btn btn-success" href="{{ baseUrl('cases/case-documents/documents-exchanger/'.base64_encode($record->id)) }}">
         <i class="tio-swap-horizontal mr-1"></i> Documents Exchanger
        </a>
        @endif
        @if(role_permission('cases','add-folder'))
        <a onclick="showPopup('{{ baseUrl('cases/case-documents/add-folder/'.$record->unique_id) }}')" class="btn btn-primary" href="javascript:;">
         <i class="tio-folder-add mr-1"></i> Add folder
        </a>
        @endif
      </div>
    </div>
  </div>
  <!-- Card -->
  @if($is_pinned)
  <div class="card">
    <!-- Header -->
    <div class="card-body">
      
      <h2 class="h4 mb-3">Pinned access <i class="tio-help-outlined text-muted" data-toggle="tooltip" data-placement="right" title="Pinned access to files you've been working on."></i></h2>
      <!-- Pinned Access -->
      <div class="row row-cols-1 row-cols-sm-2 row-cols-md-3 row-cols-lg-4 mb-5">
        
         @foreach($pinned_folders as $key => $folders)
         @foreach($folders as $folder)
         @if(!empty($record->documentInfo($folder,$key)))
         <div class="col mb-3 mb-lg-5">
            <!-- Card -->
            <div class="card card-sm card-hover-shadow card-header-borderless h-100 text-center pinned-folders">
               <div class="card-header">
                  <?php
                     $count_files = $record->caseDocuments($record->unique_id,$folder,"count");
                  ?>
                  <small>{{$count_files}} Files</small>
                  <!-- Checkbox -->
                  <div class="custom-control custom-checkbox-switch card-pinned">
                     <input type="checkbox" id="starredCheckbox45" class="custom-control-input custom-checkbox-switch-input" checked>
                     <label class="custom-checkbox-switch-label btn-icon btn-xs rounded-circle" for="starredCheckbox45">
                     <span class="custom-checkbox-switch-default" data-toggle="tooltip" data-placement="top" title="Pin">
                     <i class="tio-star-outlined"></i>
                     </span>
                     <span class="custom-checkbox-switch-active" data-toggle="tooltip" data-placement="top" title="Pinned">
                     <i class="tio-star"></i>
                     </span>
                     </label>
                  </div>
                  <!-- End Checkbox -->
                  <!-- Unfold -->
                  <div class="hs-unfold ml-auto">
                     <a class="js-hs-unfold-invoker btn btn-icon btn-sm btn-ghost-secondary card-unfold rounded-circle" href="javascript:;"
                        data-hs-unfold-options='{
                        "target": "#action-pinned-{{$folder}}",
                        "type": "css-animation"
                        }'>
                     <i class="tio-more-vertical"></i>
                     </a>
                     <div id="action-pinned-{{$folder}}" class="hs-unfold-content dropdown-unfold dropdown-menu dropdown-menu-right" style="min-width: 13rem;">
                        <a class="dropdown-item" href="#">
                        <i class="tio-share dropdown-item-icon"></i>
                        Share file
                        </a>
                        <!-- <a class="dropdown-item" href="#">
                        <i class="tio-folder-add dropdown-item-icon"></i>
                        Move to
                        </a> -->
                        @if(role_permission('cases','view-documents'))
                        <a class="dropdown-item" href="<?php echo baseUrl("cases/case-documents/".$key."/".$record->unique_id."/".$folder) ?>">
                           <i class="tio-folder-add dropdown-item-icon"></i>
                           View Documents
                       </a>
                       @endif
                       @if(role_permission('cases','add-to-starred'))
                        <a class="dropdown-item" href="javascript:;" onclick="unpinnedFolder('{{ $record->id }}','{{$folder}}','{{ $key }}')">
                        <i class="tio-star dropdown-item-icon"></i>
                        Click to unpinned
                        </a>
                      @endif
                     </div>
                  </div>
                  <!-- End Unfold -->
               </div>
               <div class="card-body">
                  <i class="tio-folder tio-xl text-body mr-2"></i>
                  <a class="stretched-link" href="#"></a>
               </div>
               <div class="card-body">
                  <h5 class="card-title">
                     <?php 
                     echo $record->documentInfo($folder,$key)->name;
                     ?>
                  </h5>
                  <!-- <p class="small">Updated 2 months ago</p> -->
               </div>
            </div>
            <!-- End Card -->
         </div>
         @endif
         @endforeach
         @endforeach
      </div>
    
    </div>
  </div>
  @endif
  <div class="card">
    <!-- Header -->
    <div class="card-body">
      <!-- End Pinned Access -->
      <div class="row align-items-center mb-2">
         <div class="col">
            <h2 class="h4 mb-0">Default Folders</h2>
         </div>
      </div>
      <div class="tab-content" id="connectionsTabContent">
         <div class="tab-pane fade show active" id="list" role="tabpanel" aria-labelledby="list-tab">
            <ul class="list-group">
               <!-- List Item -->
               <?php
                $default_documents = $service->DefaultDocuments($service->service_id);
               ?>
               @foreach($default_documents as $key => $document)
               <li class="list-group-item">
                  <div class="row align-items-center gx-2">
                     <div class="col-auto">
                        <i class="tio-folder tio-xl text-body mr-2"></i>
                     </div>
                     <div class="col">
                        <h5 class="card-title text-truncate mr-2">
                           {{$document->name}}
                           @if(isset($pinned_folders['default']) && in_array($document->unique_id,$pinned_folders['default']))
                           <i class="tio-star text-primary" data-toggle="tooltip" data-placement="top" title="" data-original-title="Folder pinned"></i>
                           @endif
                        </h5>
                        <ul class="list-inline list-separator small">
                           <li class="list-inline-item">{{$record->caseDocuments($record->unique_id,$document->unique_id,'count')}} Files</li>
                        </ul>
                     </div>
                     <div class="hs-unfold">
                        <a class="js-hs-unfold-invoker btn btn-sm btn-white" href="javascript:;"
                           data-hs-unfold-options='{
                           "target": "#action-default-{{$key}}",
                           "type": "css-animation"
                           }'>
                        <span class="d-none d-sm-inline-block mr-1">More</span>
                        <i class="tio-chevron-down"></i>
                        </a>
                        <div id="action-default-{{$key}}" class="hs-unfold-content dropdown-unfold dropdown-menu dropdown-menu-right" style="min-width: 13rem;">
                           <a class="dropdown-item" href="#">
                           <i class="tio-share dropdown-item-icon"></i>
                           Share Folder
                           </a>
                           <a class="dropdown-item" href="<?php echo baseUrl("cases/case-documents/default/".$record->unique_id."/".$document->unique_id) ?>">
                           <i class="tio-folder-add dropdown-item-icon"></i>
                           View Documents
                           </a>
                           @if(role_permission('cases','add-to-starred'))
                               @if(!isset($pinned_folders['default']) || !in_array($document->unique_id,$pinned_folders['default']))
                               <a class="dropdown-item" href="javascript:;" onclick="pinnedFolder('{{ $case_id }}','{{ $document->unique_id }}','default')">
                               <i class="tio-star-outlined dropdown-item-icon"></i>
                               Add to stared
                               </a>
                               @endif
                           @endif
                        </div>
                     </div>
                  </div>
                  <!-- End Row -->
               </li>
               @endforeach
               @foreach($documents as $key => $document)
               <li class="list-group-item">
                  <div class="row align-items-center gx-2">
                     <div class="col-auto">
                        <i class="tio-folder tio-xl text-body mr-2"></i>
                     </div>
                     <div class="col">
                        <h5 class="card-title text-truncate mr-2">
                           {{$document->name}}
                           @if(isset($pinned_folders['other']) && in_array($document->unique_id,$pinned_folders['other']))
                           <i class="tio-star text-primary" data-toggle="tooltip" data-placement="top" title="" data-original-title="Folder pinned"></i>
                           @endif
                        </h5>
                        <ul class="list-inline list-separator small">
                           <li class="list-inline-item">{{$record->caseDocuments($record->unique_id,$document->unique_id,'count')}} Files</li>
                        </ul>
                     </div>
                     <div class="hs-unfold">
                        <a class="js-hs-unfold-invoker btn btn-sm btn-white" href="javascript:;"
                           data-hs-unfold-options='{
                           "target": "#action-other-{{$key}}",
                           "type": "css-animation"
                           }'>
                        <span class="d-none d-sm-inline-block mr-1">More</span>
                        <i class="tio-chevron-down"></i>
                        </a>
                        <div id="action-other-{{$key}}" class="hs-unfold-content dropdown-unfold dropdown-menu dropdown-menu-right" style="min-width: 13rem;">
                           <a class="dropdown-item" href="#">
                           <i class="tio-share dropdown-item-icon"></i>
                           Share Folder
                           </a>
                           <a class="dropdown-item" href="<?php echo baseUrl("cases/case-documents/other/".$record->unique_id."/".$document->unique_id) ?>">
                           <i class="tio-folder-add dropdown-item-icon"></i>
                           View Documents
                           </a>
                           @if(role_permission('cases','add-to-starred'))
                           @if(!isset($pinned_folders['other']) || !in_array($document->unique_id,$pinned_folders['other']))
                           <a class="dropdown-item" href="javascript:;" onclick="pinnedFolder('{{ $case_id }}','{{ $document->unique_id }}','other')">
                           <i class="tio-star-outlined dropdown-item-icon"></i>
                           Add to stared
                           </a>
                           @endif
                           @endif
                        </div>
                     </div>
                  </div>
                  <!-- End Row -->
               </li>
               @endforeach
            </ul>
         </div>
      </div>
  </div>

  @if(count($case_folders) > 0)
  <div class="card mt-3">
    <!-- Header -->
    <div class="card-body">
      <div class="row align-items-center mb-2">
         <div class="col">
            <h2 class="h4 mb-0">Other Folders</h2>
         </div>
      </div>
      <div class="tab-content" id="connectionsTabContent">
         <div class="tab-pane fade show active" id="list" role="tabpanel" aria-labelledby="list-tab">
            <ul class="list-group">
              
               @foreach($case_folders as $key => $document)
               <li class="list-group-item">
                  <div class="row align-items-center gx-2">
                     <div class="col-auto">
                        <i class="tio-folder tio-xl text-body mr-2"></i>
                     </div>
                     <div class="col">
                        <h5 class="card-title text-truncate mr-2">
                           {{$document->name}}
                           @if(isset($pinned_folders['extra']) && in_array($document->unique_id,$pinned_folders['extra']))
                           <i class="tio-star text-primary" data-toggle="tooltip" data-placement="top" title="" data-original-title="Folder pinned"></i>
                           @endif
                        </h5>
                        <ul class="list-inline list-separator small">
                           <li class="list-inline-item">{{$record->caseDocuments($record->unique_id,$document->unique_id,'count')}} Files</li>
                        </ul>
                     </div>
                     <div class="hs-unfold">
                        <a class="js-hs-unfold-invoker btn btn-sm btn-white" href="javascript:;"
                           data-hs-unfold-options='{
                           "target": "#action-extra-{{$key}}",
                           "type": "css-animation"
                           }'>
                        <span class="d-none d-sm-inline-block mr-1">More</span>
                        <i class="tio-chevron-down"></i>
                        </a>
                        <div id="action-extra-{{$key}}" class="hs-unfold-content dropdown-unfold dropdown-menu dropdown-menu-right" style="min-width: 13rem;">
                           <a class="dropdown-item" href="#">
                           <i class="tio-share dropdown-item-icon"></i>
                           Share Folder
                           </a>
                           <a class="dropdown-item" href="<?php echo baseUrl("cases/case-documents/extra/".$record->unique_id."/".$document->unique_id) ?>">
                           <i class="tio-folder-add dropdown-item-icon"></i>
                           View Documents
                           </a>
                           @if(role_permission('cases','add-to-starred'))
                           @if(!isset($pinned_folders['extra']) || !in_array($document->unique_id,$pinned_folders['extra']))
                           <a class="dropdown-item" href="javascript:;" onclick="pinnedFolder('{{ $case_id }}','{{ $document->unique_id }}','extra')">
                           <i class="tio-star-outlined dropdown-item-icon"></i>
                           Add to stared
                           </a>
                           @endif
                            @endif
                           
                           <a class="dropdown-item text-danger" href="javascript:;" onclick="confirmAction(this)" data-href="{{baseUrl('cases/case-documents/delete-folder/'.base64_encode($document->id))}}">
                              <i class="tio-delete-outlined dropdown-item-icon"></i>
                              Delete
                           </a> 
                        </div>
                     </div>
                  </div>
                  <!-- End Row -->
               </li>
               @endforeach
            </ul>
         </div>
      </div>
    </div>
  </div>
  @endif
  <!-- End Card -->
</div>
<!-- End Content -->
@endsection

@section('javascript')
<script type="text/javascript">
$(document).ready(function(){
   $('.js-hs-action').each(function () {
    var unfold = new HSUnfold($(this)).init();
   });
   if($(".row-checkbox:checked").length > 0){
      $("#datatableCounterInfo").show();
   }else{
      $("#datatableCounterInfo").hide();
   }
})
function pinnedFolder(case_id,folder_id,doc_type){
   $.ajax({
        type: "POST",
        url: BASEURL + '/cases/pinned-folder',
        data:{
            _token:csrf_token,
            case_id:case_id,
            folder_id:folder_id,
            doc_type:doc_type,
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
}
function unpinnedFolder(case_id,folder_id,doc_type){
   $.ajax({
        type: "POST",
        url: BASEURL + '/cases/unpinned-folder',
        data:{
            _token:csrf_token,
            case_id:case_id,
            folder_id:folder_id,
            doc_type:doc_type,
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
}
</script>
@endsection