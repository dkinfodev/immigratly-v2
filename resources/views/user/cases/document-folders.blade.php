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
        <div class="text-dark">{{$record['case_title']}}</div>
      </div>
      <div class="col-sm-auto">
        <a class="btn btn-info" href="{{ baseUrl('cases/import-to-my-documents/'.$subdomain.'/'.$record['unique_id']) }}">
         <i class="tio-swap-horizontal mr-1"></i> Import to My Documents 
        </a>
        <a class="btn btn-primary" href="{{ baseUrl('cases/my-documents-exchanger/'.$subdomain.'/'.$record['unique_id']) }}">
         <i class="tio-swap-horizontal mr-1"></i> Export from My Documents 
        </a>
        <a class="btn btn-success" href="{{ baseUrl('cases/documents-exchanger/'.$subdomain.'/'.$record['unique_id']) }}">
         <i class="tio-swap-horizontal mr-1"></i> Documents Exchanger
        </a>
        
      </div>
    </div>
  </div>
  <!-- Card -->

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
                $default_documents = $service['Documents'];
               ?>
               @foreach($default_documents as $key => $document)
               <li class="list-group-item">
                  <div class="row align-items-center gx-2">
                     <div class="col-auto">
                        <i class="tio-folder tio-xl text-body mr-2"></i>
                     </div>
                     <div class="col">
                      <a href="<?php echo baseUrl("cases/documents/default/".$subdomain."/".$case_id."/".$document['unique_id']) ?>" class="text-dark">
                        <h5 class="card-title text-truncate mr-2">
                           {{$document['name']}}
                        </h5>
                        <ul class="list-inline list-separator small">
                           <li class="list-inline-item">{{$document['files_count']}} Files</li>
                        </ul>
                      </a>
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
                          
                           <a class="dropdown-item" href="<?php echo baseUrl("cases/documents/default/".$subdomain."/".$case_id."/".$document['unique_id']) ?>">
                           <i class="tio-folder-add dropdown-item-icon"></i>
                           View Documents
                           </a>
                           
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
                        <a href="<?php echo baseUrl("cases/documents/other/".$subdomain."/".$case_id."/".$document['unique_id']) ?>">
                          <h5 class="card-title text-truncate mr-2">
                             {{$document['name']}}
                          </h5>
                          <ul class="list-inline list-separator small">
                             <li class="list-inline-item">{{$document['files_count']}} Files</li>
                          </ul>
                        </a>
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
                           
                           <a class="dropdown-item" href="<?php echo baseUrl("cases/documents/other/".$subdomain."/".$case_id."/".$document['unique_id']) ?>">
                           <i class="tio-folder-add dropdown-item-icon"></i>
                           View Documents
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
                        <a href="<?php echo baseUrl("cases/documents/extra/".$subdomain."/".$case_id."/".$document['unique_id']) ?>" class="text-dark">
                        <h5 class="card-title text-truncate mr-2">
                           {{$document['name']}}
                        </h5>
                        <ul class="list-inline list-separator small">
                           <li class="list-inline-item">{{$document['files_count']}} Files</li>
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
                           <a class="dropdown-item" href="<?php echo baseUrl("cases/documents/extra/".$subdomain."/".$case_id."/".$document['unique_id']) ?>">
                           <i class="tio-folder-add dropdown-item-icon"></i>
                           View Documents
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