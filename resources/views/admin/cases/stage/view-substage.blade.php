@extends('layouts.master')

@section('breadcrumb')
<!-- Content -->
<ol class="breadcrumb breadcrumb-no-gutter">
  <li class="breadcrumb-item"><a class="breadcrumb-link" href="{{ baseUrl('/') }}">Dashboard</a></li>
   <li class="breadcrumb-item"><a class="breadcrumb-link" href="{{ baseUrl('/cases') }}">Cases</a></li>
   <li class="breadcrumb-item"><a class="breadcrumb-link" href="{{ baseUrl('/cases/stages/list/'.base64_encode($record->CaseStage->Case->id)) }}">Stages</a></li>
    <li class="breadcrumb-item active" aria-current="page">{{$pageTitle}}</li>
</ol>
<!-- End Content -->
@endsection

@section('header-right')
<a class="btn btn-primary" href="{{ baseUrl('/cases/stages/list/'.base64_encode($record->CaseStage->Case->id)) }}"><i class="tio mr-1"></i> Back</a>

@endsection

@section('content')
<style>
.h-100 {
    height: auto !important;
}
</style>
<!-- Content -->
<div class="content container-fluid">
    
    <!-- Card -->
    <div class="card">
        <div class="card-header p-4">
            <h2>{{$record->name}}</h2>
        </div>
        <div class="card-body p-3">
          @if($record->stage_type == 'fill-form')
            <div class="row">
                <div class="col-md-12">
                    <div class="float-right">
                        <a data-toggle="tooltip" data-html="true" title="Click to Edit Form" href="{{baseUrl('global-forms/edit/'.$record->type_id)}}" class="btn btn-warning btn-sm"><i class="tio-edit"></i></a>
                        @if($record->form_reply != '')
                        <a data-toggle="tooltip" data-html="true" title="View Client Reply" href="{{baseUrl('global-forms/edit/'.$record->type_id)}}" class="btn btn-info btn-sm"><i class="tio-globe"></i></a>
                        @endif
                    </div>
                </div>
                <div class="col-md-12">
                    <h3 class="page-title mt-3 mb-3">{{$record->FillForm->form_title}}</h3>
                    <div class="render-wrap"></div>
                 </div>
            </div>
          @endif
          @if($record->stage_type == 'case-document')
            <div class="row">
              @php 
                $case_documents = array();
                if($record->case_documents != ''){
                    $case_documents = json_decode($record->case_documents,true);
                }
              @endphp
              @if(!empty($case_documents))
                <div class="col-md-12">
                  <h3>Stages required below documents</h3>
                  <div class="tab-content" id="professionalTabContent">
                      @if(isset($case_documents['default_documents']))
                      <div class="tab-pane fade show active professional-request-folders" id="default_documents" role="tabpanel"
                            aria-labelledby="list-tab">
                            <span class="folder-label-professional">Default Folders</span>
                            <ul class="list-group professional-request-folders-list droppable" id="accordionProfessionalDoc">
                              <!-- List Item -->
                              <?php
                                  $default_documents = $service->DefaultDocuments($service->service_id);
                              ?>
                              @foreach($default_documents as $key => $document)
                                  @if(in_array($document->unique_id,$case_documents['default_documents']))
                                  <li class="list-group-item">
                                    <div class="row">
                                        <div class="col-auto">
                                          @if($case->caseDocuments($case->unique_id,$document->unique_id,$doc_user_id,'count') > 0)
                                          <img class="avatar avatar-xs avatar-4by3" src="assets/svg/folder-files.svg" alt="Image Description">
                                          @else
                                          <img class="avatar avatar-xs avatar-4by3" src="assets/svg/folder.svg" alt="Image Description">
                                          @endif
                                        </div>

                                        <div class="col" data-toggle="collapse" data-target="#collapseDefaultDoc-{{ $key }}"
                                          aria-expanded="true" aria-controls="collapseDefaultDoc-{{ $key }}">
                                          <a href="<?php echo baseUrl("cases/case-documents/default/".$case->unique_id."/".$document->unique_id) ?>" onclick="fetchFiles(this)" data-subdomain="{{$subdomain}}">
                                                <h5 class="mb-0">
                                                    {{$document->name}}
                                                </h5>
                                                <ul class="list-inline list-separator small">
                                                    <li class="list-inline-item">{{$case->caseDocuments($case->unique_id,$document->unique_id,$doc_user_id,'count')}} Files</li>
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
                                         
                                        </div>
                                    </div>
                                    <!-- End Row -->
                                  </li>
                                  @endif
                              <!-- End List Item -->
                              @endforeach
                            </ul>
                      </div>
                      @endif
                                                      
                      @if(isset($case_documents['custom_documents']))
                      <div class="tab-pane fade show active professional-request-folders" id="custom_documents" role="tabpanel"
                            aria-labelledby="list-tab">
                            <span class="folder-label-professional">Other Requested Folders</span>
                            <ul class="list-group professional-request-folders-list droppable" id="accordionProfessionalDoc">
                                <!-- List Item -->
                          
                              @foreach($case_folders as $key => $document)
                                @if(in_array($document->unique_id,$case_documents['custom_documents']))
                                  <li class="list-group-item">
                                      <div class="row">
                                        <div class="col-auto">
                                            @if($case->caseDocuments($case_folders->unique_id,$document->unique_id,$doc_user_id,'count') > 0)
                                            <img class="avatar avatar-xs avatar-4by3" src="assets/svg/folder-files.svg" alt="Image Description">
                                            @else
                                            <img class="avatar avatar-xs avatar-4by3" src="assets/svg/folder.svg" alt="Image Description">
                                            @endif
                                        </div>

                                        <div class="col" data-toggle="collapse" data-target="#collapseDefaultDoc-{{ $key }}"
                                            aria-expanded="true" aria-controls="collapseDefaultDoc-{{ $key }}">
                                            <a href="<?php echo baseUrl("cases/case-documents/extra/".$case_folders->unique_id."/".$document->unique_id) ?>" onclick="fetchFiles(this)" data-subdomain="{{$subdomain}}">
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
                                        
                                        </div>
                                      </div>
                                      <!-- End Row -->
                                    </li>
                                  @endif
                                <!-- End List Item -->
                                @endforeach
                            </ul>
                      </div>
                      @endif
                      
                  </div>
                </div>
              @endif
            </div>
          @endif
        </div>
        <!-- End Card -->
    </div>
</div>
<!-- End Content -->
@endsection
@section('javascript')
<script src="assets/vendor/formBuilder/dist/form-render.min.js"></script>
<script type="text/javascript">
jQuery(($) => {
  @if($record->stage_type == 'fill-form')
  var form_json = '<?php echo $record->FillForm->form_json ?>';
  var formData = JSON.parse(form_json);
  $('.render-wrap').formRender({
      formData:form_json,
      dataType: 'json',
      render: true
    });
  @endif
});

$(document).on('ready', function () {    
    $("#form").submit(function(e){
      e.preventDefault();
      var formData = new FormData($(this)[0]);
      var url  = $("#form").attr('action');
      $.ajax({
        url:url,
        type:"post",
        data:formData,
        cache: false,
        contentType: false,
        processData: false,
        dataType:"json",
        beforeSend:function(){
          showLoader();
        },
        success:function(response){
          hideLoader();
          if(response.status == true){
            successMessage(response.message);
            redirect(response.redirect);
          }else{
            validation(response.message);
          }
        },
        error:function(){
            internalError();
        }
      });
      
    });
});
</script>
@endsection