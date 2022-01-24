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
               <a href="{{ baseUrl('cases/case-documents/documents/'.base64_encode($record->id)) }}" class="nav-link {{($dependent_id == '')?'active':''}}">{{$client->first_name." ".$client->last_name}}</a>
               @else
               <a href="{{ baseUrl('cases/case-documents/documents/'.base64_encode($record->id)) }}" class="nav-link {{($dependent_id == '')?'active':''}}">Client not found</a>
               @endif
            </li>
            @foreach($dependents as $dependent)
               @if(!empty($dependent->Dependent($dependent->dependent_id)))
               <li class="nav-item">
                  <?php 
                     $case_dependent = $dependent->Dependent($dependent->dependent_id);
                  ?>
                  <a href="{{ baseUrl('cases/case-documents/documents/'.base64_encode($record->id)) }}?dependent_id={{$dependent->dependent_id}}&visa_service={{$dependent->visa_service_id}}" class="nav-link {{($dependent_id == $dependent->dependent_id)?'active':''}}">{{$case_dependent->given_name}}</a>
               </li>
               @endif
            @endforeach
      </ul>
   </div>
</div>
@endif
<div class="row">
   <div class="col-lg-9 mb-5 mb-lg-0">
      <h2 class="h4 mb-3">Pinned access <i class="tio-help-outlined text-muted" data-toggle="tooltip" data-placement="right" title="Pinned access to files you've been working on."></i></h2>
      <!-- Pinned Access -->
      <div class="row row-cols-1 row-cols-sm-2 row-cols-md-3 row-cols-lg-4 mb-5">
          @foreach($pinned_folders as $key => $folders)
        
              @foreach($folders as $folder)
               @if(!empty($record->documentInfo($folder,$key)))
               <?php
                  $count_files = $record->caseDocuments($record->unique_id,$folder,$doc_user_id,"count");
               ?>
                  <div class="col mb-3 mb-lg-5">
                     <!-- Card -->
                     <a class="card card-sm card-hover-shadow h-100 text-center" href="javascript:;">
                        <!-- Checkbox -->
                        <div class="custom-control custom-checkbox-switch card-pinned">
                              <input type="checkbox" onchange="unpinnedFolder('{{ $case_id }}','{{ $folder }}','{{$key}}')" id="starredCheckbox-{{$key}}"
                                 class="custom-control-input custom-checkbox-switch-input" checked>
                              <label class="custom-checkbox-switch-label btn-icon btn-xs rounded-circle"
                                 for="starredCheckbox-{{$key}}">
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
                              @if($count_files > 0)
                                 <img class="avatar avatar-4by3" src="assets/svg/folder-files.svg" alt="Image Description">
                              @else
                                 <img class="avatar avatar-4by3" src="assets/svg/folder.svg" alt="Image Description">
                              @endif
                        </div>


                        <div class="card-footer border-top-0">
                           <span class="d-block font-size-sm text-muted mb-1">{{$count_files}} files</span>
                           <h5>{{$record->documentInfo($folder,$key)->name}}</h5>
                        </div>
                     </a>
                     <!-- End Card -->
                  </div>
               @endif
            @endforeach
         @endforeach
      </div>
      <!-- End Pinned Access -->

      <div class="row align-items-center mb-2">
            <div class="col-sm mb-2 mb-sm-0">
               <h2 class="h4 mb-0">Files</h2>
            </div>

            <div class="col-sm-auto">
              
            </div>
      </div>

      <div class="tab-content" id="professionalTabContent">
         <div class="tab-pane fade show active professional-request-folders" id="list" role="tabpanel"
               aria-labelledby="list-tab">
               <span class="folder-label-professional">Default Folders</span>
               <ul class="list-group professional-request-folders-list droppable" id="accordionProfessionalDoc">
                  <!-- List Item -->
                  <?php
                  $default_documents = $service->DefaultDocuments($service->service_id);
                  ?>
                  @foreach($default_documents as $key => $document)
                     <li class="list-group-item">
                        <div class="row">
                           <div class="col-auto">
                              @if($record->caseDocuments($record->unique_id,$document->unique_id,$doc_user_id,'count') > 0)
                              <img class="avatar avatar-xs avatar-4by3" src="assets/svg/folder-files.svg" alt="Image Description">
                              @else
                              <img class="avatar avatar-xs avatar-4by3" src="assets/svg/folder.svg" alt="Image Description">
                              @endif
                           </div>

                           <div class="col" data-toggle="collapse" data-target="#collapseDefaultDoc-{{ $key }}"
                              aria-expanded="true" aria-controls="collapseDefaultDoc-{{ $key }}">
                              <a href="<?php echo baseUrl("cases/case-documents/default/".$record->unique_id."/".$document->unique_id) ?><?php echo $query_string ?>" onclick="fetchFiles(this)" data-subdomain="{{$subdomain}}">
                                    <h5 class="mb-0">
                                       {{$document->name}}
                                    </h5>
                                    <ul class="list-inline list-separator small">
                                       <li class="list-inline-item">{{$record->caseDocuments($record->unique_id,$document->unique_id,$doc_user_id,'count')}} Files</li>
                                       <?php
                                          $doc_chats = countUnreadDocChat($case_id,$subdomain,\Auth::user()->role,$document->unique_id);
                                          if($doc_chats > 0){
                                       ?>
                                          <li class="list-inline-item text-danger">{{$doc_chats}} chats</li>
                                       <?php } ?>
                                    </ul>
                              </a>
                           </div>
                           <div class="col-auto">
                              @if(!isset($pinned_folders['default']) || !in_array($document->unique_id,$pinned_folders['default']))
                              <a class="dropdown-item" href="javascript:;" onclick="pinnedFolder('{{ $case_id }}','{{ $document->unique_id }}','default')">
                              <i class="tio-star-outlined dropdown-item-icon"></i>
                              Add to stared
                              </a>
                              @else
                              <a class="dropdown-item" href="javascript:;" onclick="unpinnedFolder('{{ $case_id }}','{{ $document->unique_id }}','default')">
                              <i class="tio-star text-danger dropdown-item-icon"></i>
                                 Unpinned Folder
                              </a>
                              @endif
                           </div>
                        </div>
                        <!-- End Row -->
                  </li>
                  <!-- End List Item -->
                  @endforeach
               </ul>
         </div>
      </div>
      @if(count($case_folders)>0)
      <div class="row align-items-center mb-2">
            <div class="col-sm mb-2 mb-sm-0">
               <h2 class="h4 mb-0">Files</h2>
            </div>

            <div class="col-sm-auto">
              
            </div>
      </div>
      
      <div class="tab-content" id="otherTabContent">
         <div class="tab-pane fade show active professional-request-folders" id="list" role="tabpanel"
               aria-labelledby="list-tab">
               <span class="folder-label-professional">Other Requested Folders</span>
               <ul class="list-group professional-request-folders-list droppable" id="accordionProfessionalDoc">
                  <!-- List Item -->
                  <?php
                  $default_documents = $service->DefaultDocuments($service->service_id);
                  ?>
                  @foreach($case_folders as $key => $document)
                     <li class="list-group-item">
                        <div class="row">
                           <div class="col-auto">
                              @if($record->caseDocuments($record->unique_id,$document->unique_id,$doc_user_id,'count') > 0)
                              <img class="avatar avatar-xs avatar-4by3" src="assets/svg/folder-files.svg" alt="Image Description">
                              @else
                              <img class="avatar avatar-xs avatar-4by3" src="assets/svg/folder.svg" alt="Image Description">
                              @endif
                           </div>

                           <div class="col" data-toggle="collapse" data-target="#collapseDefaultDoc-{{ $key }}"
                              aria-expanded="true" aria-controls="collapseDefaultDoc-{{ $key }}">
                              <a href="<?php echo baseUrl("cases/case-documents/extra/".$record->unique_id."/".$document->unique_id) ?><?php echo $query_string ?>" onclick="fetchFiles(this)" data-subdomain="{{$subdomain}}">
                                    <h5 class="mb-0">
                                       {{$document->name}}
                                    </h5>
                                    <ul class="list-inline list-separator small">
                                       <li class="list-inline-item">{{$record->caseDocuments($record->unique_id,$document->unique_id,$doc_user_id,'count')}} Files</li>
                                       <?php
                                          $doc_chats = countUnreadDocChat($case_id,$subdomain,\Auth::user()->role,$document->unique_id);
                                          if($doc_chats > 0){
                                       ?>
                                          <li class="list-inline-item text-danger">{{$doc_chats}} chats</li>
                                       <?php } ?>
                                    </ul>
                              </a>
                           </div>
                           <div class="col-auto">
                           @if(!isset($pinned_folders['extra']) || !in_array($document->unique_id,$pinned_folders['extra']))
                              <a class="dropdown-item" href="javascript:;" onclick="pinnedFolder('{{ $case_id }}','{{ $document->unique_id }}','extra')">
                              <i class="tio-star-outlined dropdown-item-icon"></i>
                              Add to stared
                              </a>
                              @else
                              <a class="dropdown-item" href="javascript:;" onclick="unpinnedFolder('{{ $case_id }}','{{ $document->unique_id }}','extra')">
                              <i class="tio-star text-danger dropdown-item-icon"></i>
                                 Unpinned Folder
                              </a>
                              @endif
                           </div>
                        </div>
                        <!-- End Row -->
                  </li>
                  <!-- End List Item -->
                  @endforeach
               </ul>
         </div>
      </div>
      @endif
   </div>
   <div class="col-lg-3 mb-5 mb-lg-0">
      <a class="btn btn-success w-100 mb-3" href="{{ baseUrl('cases/case-documents/documents-exchanger/'.base64_encode($record->id)) }}">
         <i class="tio-swap-horizontal mr-1"></i> Documents Exchanger
      </a>
      <a onclick="showPopup('<?php echo baseUrl('cases/case-documents/add-folder/'.$record->unique_id) ?>')" class="btn btn-primary w-100 mb-3" href="javascript:;">
         <i class="tio-folder-add mr-1"></i> Add folder
      </a>
   </div>
</div>

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