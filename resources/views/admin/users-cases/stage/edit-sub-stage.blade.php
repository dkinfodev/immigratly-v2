@extends('layouts.master')

@section('breadcrumb') 
<!-- Content -->
<ol class="breadcrumb breadcrumb-no-gutter">
  <li class="breadcrumb-item"><a class="breadcrumb-link" href="{{ baseUrl('/') }}">Dashboard</a></li>
  <li class="breadcrumb-item"><a class="breadcrumb-link" href="{{ baseUrl('/cases') }}">Cases</a></li>
  <li class="breadcrumb-item"><a class="breadcrumb-link" href="{{ baseUrl('/cases/stages/list/'.base64_encode($case->id)) }}">Stages</a></li>
  <li class="breadcrumb-item active" aria-current="page">{{$pageTitle}}</li>
</ol>
<!-- End Content -->
@endsection

@section('header-right')
   <a class="btn btn-primary" href="{{ baseUrl('/cases/stages/list/'.base64_encode($case->id)) }}"><i class="tio mr-1"></i> Back</a>

@endsection


@section('content')
<style>
.h-100 {
    height: auto !important;
}

.hidden{
  display: none;
}
</style>
<!-- Content -->
<div class="add-tasks">

    <!-- Card -->
    <div class="card">

        <div class="card-body">
            <form method="post" id="form" class="js-validate"
                action="{{ baseUrl('/cases/sub-stages/edit') }}">
                @csrf
               
                <!-- Form Group -->
                <div class="row form-group js-form-message">
                    <label class="col-sm-3 col-form-label input-label">Name</label>
                    <div class="col-sm-9">
                        <div class="input-group input-group-sm-down-break">
                            <input type="text" class="form-control @error('name') is-invalid @enderror"
                                name="name" id="name" placeholder="Enter stage name" value="{{$record->name}}" 
                                aria-label="Enter name">
                            @error('name')
                            <span class="invalid-feedback" role="alert">
                                <strong>{{ $message }}</strong>
                            </span>
                            @enderror
                        </div>
                    </div>
                </div>

                <div class="row form-group js-form-message">
                    <label class="col-sm-3 col-form-label input-label">Stage Type</label>
                    <div class="col-sm-9">
                        
                        <input type="hidden" class="form-control "
                                name="stage_id" id="stage_id" value="{{$stage->unique_id}}" >

                        <input type="hidden" class="form-control "
                                name="sub_stage_id" id="sub_stage_id" value="{{$record->unique_id}}" >        

                        <div class="input-group input-group-sm-down-break">
                            <select class="form-control @error('stage_type') is-invalid @enderror" name="stage_type" id="stage_type">
                              <option value="">Select</option>
                              <option <?php if($record->stage_type == "fill-form"){ echo "selected"; }  ?> data-type="fill-form" value="fill-form">Fill Form</option>
                              <option <?php if($record->stage_type == "case-task"){ echo "selected"; }  ?> data-type="case-task" value="case-task">Case Task</option>
                              <option <?php if($record->stage_type == "case-document"){ echo "selected"; }  ?> data-type="case-document" value="case-document">Case Document</option>
                            </select> 

                            @error('stage_type')
                            <span class="invalid-feedback" role="alert">
                                <strong>{{ $message }}</strong>
                            </span>
                            @enderror
                        </div>
                    </div>
                </div>

                 <div class="row form-group custom-field global-form <?php if($record->stage_type == "fill-form"){ echo "active"; } else{ echo "hidden"; } ?>  js-form-message">
                    <label class="col-sm-3 col-form-label input-label">Form</label>
                    <div class="col-sm-9">
                       
                       <select class="form-control @error('form_id') is-invalid @enderror" name="form_id" id="form_id">
                        
                        @foreach($globalForms as $key=>$form) 
                          <option value="">Select</option>
                          <option <?php if($record->type_id == $form->unique_id){ echo "selected"; } ?> value="{{$form->unique_id}}">{{$form->form_title}}</option>
                        @endforeach
                        </select> 
                       

                        <div class="input-group input-group-sm-down-break">
                          
                            @error('form_id')
                            <span class="invalid-feedback" role="alert">
                                <strong>{{ $message }}</strong>
                            </span>
                            @enderror
                        </div>
                    </div>
                </div>

                <div class="row g-case-tasks custom-field <?php if($record->stage_type == "case-task"){ echo "active"; } else{ echo "hidden"; } ?>  form-group js-form-message">
                    <label class="col-sm-3 col-form-label input-label">Task</label>
                    <div class="col-sm-9">
                       
                       <select class="form-control @error('case_task_id') is-invalid @enderror" name="case_task_id" id="case_task_id">
                        @foreach($caseTasks as $key=>$task) 
                          <option value="">Select</option>
                          <option <?php if($record->type_id == $task->unique_id){ echo "selected"; } ?> value="{{$task->unique_id}}">{{$task->task_title}}</option>
                        @endforeach
                        </select> 
                       
                        <div class="input-group input-group-sm-down-break">
                            @error('case_task_id')
                            <span class="invalid-feedback" role="alert">
                                <strong>{{ $message }}</strong>
                            </span>
                            @enderror
                        </div>
                    </div>
                </div>

                <div class="case-document custom-field <?php if($record->stage_type == "case-document"){ echo "active"; } else{ echo "hidden"; } ?>">
                  <div class="row form-group js-form-message">
                      <label class="col-sm-3 col-form-label input-label">Default Documents</label>
                      <div class="col-sm-9">
                        @php 
                          $case_documents = array();

                          if($record->case_documents != ''){
                            $case_documents = json_decode($record->case_documents,true);
                          }
                        @endphp
                        <select class="form-control @error('default_document') is-invalid @enderror" name="default_documents[]" multiple id="default_document">
                          @foreach($default_documents as $key=>$document) 
                              <option {{ (isset($case_documents['default_documents']) && in_array($document->unique_id,$case_documents['default_documents']))?'selected':'' }} value="{{$document->unique_id}}">{{$document->name}}</option>
                          @endforeach
                          </select> 
                        
                          <div class="input-group input-group-sm-down-break">
                              @error('default_document')
                              <span class="invalid-feedback" role="alert">
                                  <strong>{{ $message }}</strong>
                              </span>
                              @enderror
                          </div>
                      </div>
                  </div>
                  <div class="row form-group js-form-message">
                      <label class="col-sm-3 col-form-label input-label">Custom Documents</label>
                      <div class="col-sm-9">
                        
                        <select class="form-control @error('custom_documents') is-invalid @enderror" name="custom_documents[]" multiple id="custom_documents">
                          @foreach($case_folders as $key=>$document) 
                            <option {{ (isset($case_documents['custom_documents']) && in_array($document->unique_id,$case_documents['custom_documents']))?'selected':'' }} value="{{$document->unique_id}}">{{$document->name}}</option>
                          @endforeach
                          </select> 
                        
                          <div class="input-group input-group-sm-down-break">
                              @error('custom_documents')
                              <span class="invalid-feedback" role="alert">
                                  <strong>{{ $message }}</strong>
                              </span>
                              @enderror
                          </div>
                      </div>
                  </div>
                </div>
                <div class="form-group">
                    <button type="submit" class="btn add-btn btn-primary">Save</button>
                </div>
        </div>

        </form>
    </div>
    <!-- End Card -->
</div>
</div>
<!-- End Content -->
@endsection
@section('javascript')

<script type="text/javascript">
 //initEditor("short_description");

     $("#stage_type").change(function(){
        var tx = $(this).find(':selected').data('type');
        $(".custom-field").addClass('hidden');
        if(tx == "fill-form"){
          $(".global-form").removeClass('hidden');
        }
        else if(tx == "case-task"){
          $(".g-case-tasks").removeClass('hidden');  
        }
        else{
         $(".case-document").removeClass('hidden');
        }
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