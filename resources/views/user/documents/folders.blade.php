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
                     <a class="btn btn-success" href="{{ baseUrl('documents/documents-exchanger') }}">
                        <i class="tio-swap-horizontal mr-1"></i> Documents Exchanger
                     </a>
                     <a onclick="showPopup('{{ baseUrl('documents/add-folder') }}')" class="btn btn-primary" href="javascript:;">
                        <i class="tio-folder-add mr-1"></i> Add folder
                     </a>
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
<div class="documents">
 
  <!-- Card -->

  <div class="card">
    <!-- Header -->
    <div class="card-body">
      
      <div class="tab-content" id="connectionsTabContent">
         <div class="tab-pane fade show active" id="list" role="tabpanel" aria-labelledby="list-tab">
            @if(count($user_folders) > 0)
            <ul class="list-group">
               @foreach($user_folders as $key => $document)
               <li class="list-group-item">
                  <div class="row align-items-center gx-2">
                     <div class="col-auto">
                        <i class="tio-folder tio-xl text-body mr-2"></i>
                     </div>
                     <div class="col">
                      <a href="<?php echo baseUrl("documents/files/lists/".$document->unique_id) ?>" class="text-dark">
                        <h5 class="card-title text-truncate mr-2">
                           {{$document->name}}
                        </h5>
                        <ul class="list-inline list-separator small">
                           <li class="list-inline-item">{{count($document->Files)}} Files</li>
                        </ul>
                      </a>
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
                           <a class="dropdown-item" href="javascript:;" onclick="showPopup('<?php echo baseUrl('documents/edit-folder/'.base64_encode($document->id)) ?>')">
                             <i class="tio-edit dropdown-item-icon"></i>
                             Edit
                           </a>
                           <!-- <a class="dropdown-item" href="#">
                           <i class="tio-share dropdown-item-icon"></i>
                           Share Folder
                           </a> -->
                           <a class="dropdown-item" href="<?php echo baseUrl("documents/files/lists/".$document->unique_id) ?>">
                           <i class="tio-folder-add dropdown-item-icon"></i>
                           View Documents
                           </a>
                           <a class="dropdown-item text-danger" href="javascript:;" onclick="confirmAction(this)" data-href="{{baseUrl('documents/delete-folder/'.base64_encode($document->id))}}">
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
            @else
            <div class="col-md-12 text-center">
              <a onclick="showPopup('{{ baseUrl('documents/add-folder') }}')" href="javascript:;">
                <div style="font-size:36px"><i class="tio-folder-add mr-1"></i></div>
                <h3>Create Your First Document Folder</h3>
              </a>
            </div>
             @endif
         </div>
      </div>
    </div>
  </div>
 
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