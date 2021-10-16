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
<div class="services">
  <div class="page-header">
    <div class="row align-items-end">
      <div class="col-sm mb-2 mb-sm-0">
        <nav aria-label="breadcrumb">
          <ol class="breadcrumb breadcrumb-no-gutter">
            <li class="breadcrumb-item"><a class="breadcrumb-link" href="{{ baseUrl('/') }}">Dashboard</a></li>
            <li class="breadcrumb-item"><a class="breadcrumb-link" href="{{ baseUrl('/services') }}">Services</a></li>
            <li class="breadcrumb-item active" aria-current="page">{{$pageTitle}}</li>
          </ol>
        </nav>
        <h1 class="page-title">{{$pageTitle}}</h1>
      </div>
      <div class="col-sm-auto">
         <a onclick="showPopup('{{ baseUrl('services/add-folder/'.base64_encode($service->id)) }}')" class="btn btn-primary" href="javascript:;">
         <i class="tio-folder-add mr-1"></i> Add folder
         </a>
      </div>
    </div>
  </div>
  <!-- Card -->
  <div class="card">
    <!-- Header -->
    <div class="card-body">
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
               @foreach($default_documents as $document)
               <li class="list-group-item">
                  <div class="row align-items-center gx-2">
                     <div class="col-auto">
                        <i class="tio-folder tio-xl text-body mr-2"></i>
                     </div>
                     <div class="col">
                        <h5 class="card-title text-truncate mr-2">{{$document->name}}</h5>
                     </div>
                  </div>
                  <!-- End Row -->
               </li>
               @endforeach
            </ul>
         </div>
      </div>
  </div>

  @if(count($documents) > 0)
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
              
               @foreach($documents as $key => $document)
               <li class="list-group-item">
                  <div class="row align-items-center gx-2">
                     <div class="col-auto">
                        <i class="tio-folder tio-xl text-body mr-2"></i>
                     </div>
                     <div class="col">
                        <h5 class="card-title text-truncate mr-2">{{$document->name}}</h5>
                     </div>
                     <div class="hs-unfold">
                        <a class="js-hs-action btn btn-sm btn-white" href="javascript:;"
                           data-hs-unfold-options='{
                             "target": "#action-{{$key}}",
                             "type": "css-animation"
                           }'>
                                More <i class="tio-chevron-down ml-1"></i>
                        </a>

                        <div id="action-{{$key}}" class="hs-unfold-content dropdown-unfold dropdown-menu dropdown-menu-sm dropdown-menu-right">
                          <a class="dropdown-item" href="javascript:;" onclick="showPopup('<?php echo baseUrl("services/edit-folder/".base64_encode($document->id)) ?>')">Edit</a>
                          <div class="dropdown-divider"></div>
                          <a class="dropdown-item text-danger" href="javascript:;" onclick="confirmAction(this)" data-href="{{baseUrl('services/delete-folder/'.base64_encode($document->id))}}">Delete</a>
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
})
</script>
@endsection