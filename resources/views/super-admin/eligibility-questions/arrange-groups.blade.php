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
  <!-- Page Header -->
  <div class="page-header">
    <div class="row align-items-end">
      <div class="col-sm mb-2 mb-sm-0">
        <nav aria-label="breadcrumb">
          <ol class="breadcrumb breadcrumb-no-gutter">
            <li class="breadcrumb-item"><a class="breadcrumb-link" href="{{ baseUrl('/') }}">Dashboard</a></li>
            <li class="breadcrumb-item"><a class="breadcrumb-link" href="{{ baseUrl('/visa-services') }}">Visa Services</a></li>
            <li class="breadcrumb-item active" aria-current="page">{{$pageTitle}}</li>
          </ol>
        </nav>

        <h1 class="page-title">{{$pageTitle}}</h1>
      </div>

      <div class="col-sm-auto">
        
        <a class="btn btn-primary btn-sm" href="{{ baseUrl('/visa-services/eligibility-questions/'.base64_encode($visa_service_id)) }}">
          Back 
        </a>
      </div>
    </div>
    <!-- End Row -->
  </div>
  <!-- End Page Header -->
  <p class="text-danger">*Drag the groups to rearrage</p>
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
<script src="{{ asset('assets/vendor/sortablejs/js/jquery-ui.js') }}"></script>
<script>
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