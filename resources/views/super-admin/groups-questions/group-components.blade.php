@extends('layouts.master')

@section('breadcrumb')
<!-- Content -->
<ol class="breadcrumb breadcrumb-no-gutter">
  <li class="breadcrumb-item"><a class="breadcrumb-link" href="{{ baseUrl('/') }}">Dashboard</a></li>
   <li class="breadcrumb-item"><a class="breadcrumb-link" href="{{ baseUrl('/visa-services/eligibility-questions/'.$visa_service_id.'/groups-questions') }}">Groups Questions</a></li>
  <li class="breadcrumb-item active" aria-current="page">{{$pageTitle}} ({{$group->group_title}})</li>

</ol>
<!-- End Content -->
@endsection


@section('header-right')
        <a class="btn btn-primary" href="{{baseUrl('visa-services/eligibility-questions/'.$visa_service_id.'/groups-questions')}}">
          <i class="tio mr-1"></i> Back 
        </a>
@endsection


@section('content')
<!-- Content -->
<div class="groups_questions">
  

  <div class="accordion" id="accordionExample">
      @foreach($group->Components as $component)
        @if(!empty($component->Component))
        <div class="card" id="heading-{{$component->component_id}}">
            <a class="card-header card-btn btn-block" href="javascript:;" data-toggle="collapse" data-target="#collapse-{{$component->component_id}}" aria-expanded="true" aria-controls="collapse-{{$component->component_id}}">
            @if(!empty($component->Component))
            {{$component->Component->component_title}}
            @endif
            <span class="card-btn-toggle">
                <span class="card-btn-toggle-default">
                <i class="tio-add"></i>
                </span>
                <span class="card-btn-toggle-active">
                <i class="tio-remove"></i>
                </span>
            </span>
            </a>

            <div id="collapse-{{$component->component_id}}" class="collapse show" aria-labelledby="heading-{{$component->component_id}}" data-parent="#accordionExample">
            <div class="card-body">
              <div class="table-responsive datatable-custom">
                  <table class="table table-lg table-borderless table-thead-bordered table-align-middle card-table">
                    <thead class="thead-light">
                      <tr>
                        
                        <th scope="col">Questions</th>
                        <th scope="col">Conditional Component</th>
                        <th scope="col">Action</th>
                      </tr>
                    </thead>
                    <tbody>
                      @foreach($component->Questions as $ques)
                        <tr>
                          <td>
                          {{$ques->EligibilityQuestion->question}}
                          </td>
                          <td>
                            <?php 
                           
                                $is_condition = GroupConditional($group->unique_id,$component->Component->unique_id,$ques->EligibilityQuestion->unique_id);
                              
                            ?>
                            @if(count($is_condition) > 0)
                              <span class="badge badge-success">Yes</span>
                            @else
                              <span class="badge badge-danger">No</span>
                            @endif
                          </td>
                          <td><a href="{{ baseUrl('/visa-services/eligibility-questions/'.$visa_service_id.'/groups-questions/set-condition/'.base64_encode($group->id).'/'.$component->Component->unique_id.'/'.$ques->EligibilityQuestion->unique_id) }}" class="btn btn-primary btn-sm">Set Condition</a></td>
                        </tr>
                      @endforeach
                    </tbody>
                  </table>
                </div>
            </div>
            </div>
        </div>  
        @endif
      @endforeach
  </div>
  @endsection

@section('javascript')
<script src="assets/vendor/hs-add-field/dist/hs-add-field.min.js"></script>
<script src="assets/vendor/jquery-validation/dist/jquery.validate.min.js"></script> 

<link rel="stylesheet" href="{{ asset('assets/vendor/sortablejs/css/jquery-ui.css') }}">
<script src="{{ asset('assets/vendor/sortablejs/js/jquery-ui.js') }}"></script>

<script type="text/javascript">
$(document).ready(function(){
  $( function() {
    $('#sortable').sortable();
  });
  $("#selected_component").change(function(){
      var ques_id = $(this).val();
      var ques_len = ques_id.length;
      
      // alert(ques_len);
      
      for(var i=0;i < ques_len;i++){
            var exists = 0;
            $(".question-sort li").each(function(){
              if($(this).data("ques-id") == ques_id[i]){
                exists = 1;
              }
            });
            if(exists == 0){
                var text = $("option[value="+ques_id[i]+"]").text();
                var html ='<li data-ques-id="'+ques_id[i]+'" class="ui-state-default">';
                html +='<span class="ui-icon ui-icon-arrowthick-2-n-s"></span>';
                html +='<input type="hidden" name="components[]" value="'+ques_id[i]+'" />';
                html += text;
                html +='</li>';
                $("#sortable").append(html);
            }
        }

        $(".question-sort li").each(function(){
          var exists = 0;
          for(var i=0;i < ques_len;i++){
            if($(this).data("ques-id") == ques_id[i]){
              exists = 1;
            }
          }
          if(exists == 0){
            $(this).remove();
          }
        });
  });
  $("#form").submit(function(e){
        e.preventDefault(); 
        
        var formData = new FormData($(this)[0]);
        $.ajax({
          url:$("#form").attr('action'),
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
              window.location.href = response.redirect_back;
            }else{
              if(response.error_type == 'validation'){
                validation(response.message);
              }

              if(response.error_type == 'no_component_question'){
                errorMessage(response.message);
              }
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