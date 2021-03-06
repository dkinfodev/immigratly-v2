@extends('layouts.master')

@section('breadcrumb')
<!-- Content -->
<ol class="breadcrumb breadcrumb-no-gutter">
  <li class="breadcrumb-item"><a class="breadcrumb-link" href="{{ baseUrl('/') }}">Dashboard</a></li>
  <li class="breadcrumb-item"><a class="breadcrumb-link" href="{{ baseUrl('/visa-services') }}">Visa Services</a></li>
  <li class="breadcrumb-item active" aria-current="page">{{$pageTitle}}</li>
</ol>
<!-- End Content -->
@endsection


@section('header-right')
        <a class="btn btn-primary btn-sm" href="{{ baseUrl('/visa-services/eligibility-questions/'.base64_encode($visa_service_id)) }}">
          Back 
        </a>
@endsection


@section('content')
<style>
#sortable {
    list-style: none;
    margin: 0px;
    padding: 0px;
}
#sortable li {
    margin: 12px;
    padding: 10px;
    border-radius: 7px;
}
#sortable li:hover {
    cursor: all-scroll;
}
</style>
<!-- Content -->
<div class="eligibility_questions">
  <div class="row">
    <div class="col-md-8">
      <p class="text-danger">*Drag the groups to rearrage</p>
    </div>
    <div class="col-md-4">
        <div class="checkbox-sequence float-right">
          <label class="toggle-switch mx-2" for="customSwitch">
          <input {{$visa_service->question_as_sequence == 1?'checked':'' }} type="checkbox" class="js-toggle-switch toggle-switch-input" id="customSwitch" 
                data-hs-toggle-switch-options='{
                  "targetSelector": "#pricingCount1, #pricingCount2, #pricingCount3"
                }'>
          <span class="toggle-switch-label">
            <span class="toggle-switch-indicator"></span>
          </span>
          </label>
          <span>Show Sequentially</span>
      </div>
    </div>
  <!-- Card -->
  <div class="card">
    <!-- Table -->
    <div class="table-responsive datatable-custom">
      <form id="form" action="{{ baseUrl('/visa-services/eligibility-questions/'.base64_encode($visa_service->id).'/arrange-groups') }}">
        @csrf
      <ul id="sortable">
        @foreach($question_sequence as $record)
          <li class="ui-state-default">
            <span class="ui-icon ui-icon-arrowthick-2-n-s"></span>
            {{$record->Group->group_title}}
            <input type="hidden" name="group_id[]" value="{{$record->Group->unique_id}}" />
          </li>
        @endforeach
      </ul>
      </form>
    </div>
    <!-- End Table -->

  </div>
  <!-- End Card -->
</div>
<!-- End Content -->
@endsection

@section('javascript')

<link rel="stylesheet" href="{{ asset('assets/vendor/sortablejs/css/jquery-ui.css') }}">
<script src="//code.jquery.com/jquery-1.12.4.js"></script>
<script src="{{ asset('assets/vendor/sortablejs/js/jquery-ui.js') }}"></script>

<script src="assets/vendor/hs-toggle-switch/dist/hs-toggle-switch.min.js"></script>

<script>
  $(document).ready(function(){
      $('.js-toggle-switch').each(function () {
        var toggleSwitch = new HSToggleSwitch($(this)).init();
      });
      $("#customSwitch").change(function(){
        var is_seq;
        if($(this).is(":checked")){
          is_seq = 1;
        }else{
          is_seq = 0;
        }
        $.ajax({
            type: "POST",
            url: BASEURL + '/visa-services/question-as-sequence',
            data:{
                _token:csrf_token,
                show_as_sequence:is_seq,
                visa_service_id:"{{$visa_service->unique_id}}"
            },
            dataType:'json',
            beforeSend:function(){
                showLoader();
            },
            success: function (response) {
                hideLoader();
                if(response.status == true){
                  successMessage(response.message);
                }else{
                  errorMessage(response.message);
                }
                
            },
            error:function(){
              internalError();
            }
        });
      });
  })
  $( function() {
    $('#sortable').sortable({
        start: function(event, ui) {
            var start_pos = ui.item.index();
           
        },
        change: function(event, ui) {
            var start_pos = ui.item.data('start_pos');
            var index = ui.placeholder.index();
            if (start_pos < index) {
                $('#sortable li:nth-child(' + index + ')').addClass('highlights');
            } else {
                $('#sortable li:eq(' + (index + 1) + ')').addClass('highlights');
            }
        },
        update: function(event, ui) {
            $('#sortable li').removeClass('highlights');
            $.ajax({
             type: "POST",
             url: $("#form").attr("action"),
             data:$("#form").serialize(),
             dataType:'json',
             beforeSend:function(){
                 showLoader();
             },
             success: function (data) {
                 hideLoader();
                 if(data.status == true){
                    bottomMessage(data.message,'success');
                 }else{
                    errorMessage('Issue while arranging question');
                 }
             },
             error:function(){
               internalError();
             }
          });
        }
    });
  });
  </script>
@endsection