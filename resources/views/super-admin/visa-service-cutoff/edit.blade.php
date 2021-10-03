@extends('layouts.master')

@section('content')
<!-- Content -->
<div class="content container-fluid">
  <!-- Page Header -->
  <div class="page-header">
    <div class="row align-items-end">
      <div class="col-sm mb-2 mb-sm-0">
        <nav aria-label="breadcrumb">
          <ol class="breadcrumb breadcrumb-no-gutter">
            <li class="breadcrumb-item"><a class="breadcrumb-link" href="{{ baseUrl('/languages') }}">Languages</a></li>
            <li class="breadcrumb-item active" aria-current="page">Add</li>
          </ol>
        </nav>
        <h1 class="page-title">{{$pageTitle}}</h1>
      </div>

      <div class="col-sm-auto">
        <a class="btn btn-primary" href="{{baseUrl('visa-services/cutoff/'.base64_encode($visa_service->id))}}">
          <i class="tio mr-1"></i> Back 
        </a>
      </div>
    </div>
    <!-- End Row -->
  </div>
  <!-- End Page Header -->

  <!-- Card -->
  <div class="card">

    <div class="card-body">
      <form id="form" class="js-validate" action="{{ baseUrl('/visa-services/cutoff/'.base64_encode($visa_service->id).'/edit/'.base64_encode($record->id)) }}" method="post">
        @csrf
        <!-- Input Group -->
        <div class="js-form-message form-group row">
          <label class="col-sm-2 col-form-label">Cutoff Date</label>
          <div class="col-sm-4">
           <div class="js-flatpickr flatpickr-custom input-group input-group-merge js-form-message">
             <div class="input-group-prepend" data-toggle>
                <div class="input-group-text">
                   <i class="tio-date-range"></i>
                </div>
             </div>
             <input type="text" name="cutoff_date" class="flatpickr-custom-form-control form-control" id="cutoff_date" placeholder="Select Cutoff Date" data-input value="{{$record->cutoff_date}}">
          </div>
         </div>
        </div>
        <!-- End Input Group -->
        <div class="js-form-message form-group row">
          <label class="col-sm-2 col-form-label">Cutoff Points</label>
          <div class="col-sm-4">
            <input type="number" name="cutoff_point" id="cutoff_point" placeholder="Cutoff Points" class="form-control" value="{{$record->cutoff_point}}">
          </div>
        </div>
        <div class="js-form-message form-group row">
          <label class="col-sm-2 col-form-label">Included NOC</label>
          <div class="col-sm-10">
            <?php
              $included_noc = array();
              if($record->included_noc != ''){
                $included_noc = explode(",",$record->included_noc);
              }
            ?>
            <select name="included_noc[]" multiple>
                @foreach($noc_codes as $code)
                <option {{(in_array($code->id,$included_noc))?'selected':'' }} value="{{$code->id}}">{{$code->code}} - {{$code->name}}</option>
                @endforeach
            </select>
          </div>
        </div>
        <div class="js-form-message form-group row">
          <label class="col-sm-2 col-form-label">Excluded NOC</label>
          <div class="col-sm-10">
            <?php
              $excluded_noc = array();
              if($record->excluded_noc != ''){
                $excluded_noc = explode(",",$record->excluded_noc);
              }
            ?>
            <select name="excluded_noc[]" multiple>
                @foreach($noc_codes as $code)
                <option {{(in_array($code->id,$excluded_noc))?'selected':'' }} value="{{$code->id}}">{{$code->code}} - {{$code->name}}</option>
                @endforeach
            </select>
          </div>
        </div>
        <div class="form-group">
          <button type="submit" class="btn add-btn btn-primary">Save</button>
        </div>
        <!-- End Input Group -->
      </form>
      </div><!-- End Card body-->
    </div>
    <!-- End Card -->
  </div>
  <!-- End Content -->
  @endsection

@section('javascript')
<script type="text/javascript">
$(document).ready(function(){
    $('#cutoff_date').datepicker({
        format: 'yyyy-mm-dd',
        autoclose: true,
        maxDate:(new Date()).getDate(),
        todayHighlight: true,
        orientation: "bottom auto"
    });
    $("#form").submit(function(e){
        e.preventDefault(); 
        
        var formData = $("#form").serialize();
        $.ajax({
          url:$("#form").attr('action'),
          type:"post",
          data:formData,
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