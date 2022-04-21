@extends('layouts.master')

@section('breadcrumb')
<!-- Content -->
<ol class="breadcrumb breadcrumb-no-gutter">
  <li class="breadcrumb-item"><a class="breadcrumb-link" href="{{ baseUrl('/') }}">Dashboard</a></li>
   <li class="breadcrumb-item"><a class="breadcrumb-link" href="{{ baseUrl('/cases') }}">Cases</a></li>
   <li class="breadcrumb-item"><a class="breadcrumb-link" href="{ baseUrl('/cases/stages/'.$subdomain.'/'.$case_id) }}">Stages</a></li>
    <li class="breadcrumb-item active" aria-current="page">{{$pageTitle}}</li>
</ol>
<!-- End Content -->
@endsection

@section('header-right')
<a class="btn btn-primary" href="{{ baseUrl('/cases/stages/'.$subdomain.'/'.$case_id) }}"><i class="tio mr-1"></i> Back</a>

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
            <h2>{{$record['name']}}</h2>
        </div>
        <div class="card-body p-3">
          @if($record['stage_type'] == 'fill-form')
            <div class="row">
                <div class="col-md-12">
                    <div class="float-right">
                       @if($record['form_reply'] != '')
                        <a data-toggle="tooltip" data-html="true" title="View Client Reply" onclick="showPopup('<?php echo baseUrl('cases/stage-form-reply/'.$subdomain.'/'.$record['unique_id']) ?>')" href="javascript:;" class="btn btn-info btn-sm"><i class="tio-globe"></i></a>
                        @endif
                    </div>
                </div>
                <div class="col-md-12">
                    <h3 class="page-title mt-3 mb-3">{{$record['fill_form']['form_title']}}</h3>
                    <form id="form" action="{{ baseUrl('/cases/sub-stages/save-form-reply/'.$subdomain.'/'.$record['unique_id']) }}" class="js-validate" method="post">
                    @csrf  
                      <div class="render-wrap"></div>
                      <!-- <div class="form-group text-center">
                        <button type="submit" class="btn add-btn btn-primary">Save</button>
                      </div> -->
                      <!-- End Input Group -->
                    </form>
                 </div>
            </div>
          @endif

          @if($record['stage_type'] == 'case-document')
          @php 
                $case_documents = array();
                if($record['case_documents'] != ''){
                    $case_documents = json_decode($record['case_documents'],true);
                }
              @endphp
          <div class="row">
                <div class="col-md-12">
                  <div class="tab-pane fade show active professional-request-folders" id="list" role="tabpanel"
                      aria-labelledby="list-tab">
                      <span class="folder-label-professional">Professional Request</span>
                      <ul class="list-group professional-request-folders-list droppable" id="accordionProfessionalDoc">
                          <!-- List Item -->
                          @foreach($case_folders as $key => $document)
                          @if(isset($case_documents['custom_documents']) && in_array($document['unique_id'],$case_documents['custom_documents']))
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
                                                      } ?>

                                              </ul>
                                          </a>
                                      </div>
                                     

                                      <div id="collapseProfessionalDoc-{{$key}}" class="collapse files-collapse"
                                          aria-labelledby="headingProfessional-{{$key}}" data-parent="#accordionProfessionalDoc">
                                      </div>
                                  </div>
                                  <!-- End Row -->
                              </li>
                            @endif
                          <!-- End List Item -->
                          @endforeach

                          <?php
                              $default_documents = $service['Documents'];
                          ?>
                          @foreach($default_documents as $key => $document)
                          @if(isset($case_documents['default_documents']) && in_array($document['unique_id'],$case_documents['default_documents']))
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
                                      

                                  </div>
                                  <div id="collapseDefaultDoc-{{$key}}" class="collapse files-collapse"
                                      aria-labelledby="headingDefault-{{$key}}" data-parent="#accordionProfessionalDoc">

                                  </div>
                              </div> 
                              <!-- End Row -->
                          </li>
                          @endif
                          <!-- End List Item -->
                          @endforeach
                          
                      </ul>
                  </div>
                </div>
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
  @if($record['stage_type'] == 'fill-form')
  var form_json = '<?php echo $form_json ?>';
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
            location.reload();
          }else{
            errorMessage(response.message);
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