@extends('layouts.master')
@section("style")
<style>
.save-btn {
    position: fixed;
    top: 20% !important;
    right: 23px;
    z-index: 99;
}
</style>
@endsection
@section('content')
<!-- Content -->
<div class="content container-fluid">
  <!-- Page Header -->
  <div class="page-header">
    <div class="row align-items-end">
      <div class="col-sm mb-2 mb-sm-0">
        <nav aria-label="breadcrumb">
          <ol class="breadcrumb breadcrumb-no-gutter">
            <li class="breadcrumb-item"><a class="breadcrumb-link" href="{{ baseUrl('/') }}">Dashboard</a></li>
            <li class="breadcrumb-item"><a class="breadcrumb-link" href="{{ baseUrl('/staff') }}">Staffs</a></li>
            <li class="breadcrumb-item active" aria-current="page">{{$pageTitle}}</li>
          </ol>
        </nav>
        <h1 class="page-title">{{$pageTitle}}</h1>
      </div>

      <div class="col-sm-auto">

      </div>
    </div>
    <!-- End Row -->
  </div>
  <!-- End Page Header -->

  <!-- Card -->
  <form id="form" class="js-validate" action="{{ baseUrl('/staff/privileges/'.base64_encode($user_id)) }}" method="post">
    @csrf
    <!-- Input Group -->
    <div class="row justify-content-md-between">
      <div class="col-md-12">
        <div class="card mb-5">
            <div class="card-body">
                @foreach($privileges as $module_index => $privilege)
                <div id="module-{{$module_index}}" class="row mb-3">
                  <div class="col-md-12">
                    <div class="mb-0">
                      <div class="row align-items-center">
                        <div class="col-md-6">
                          <h1 class="page-header-title">{{$privilege->name}}</h1>
                        </div>
                        <div class="col-md-6 text-right">
                          <div class="custom-control custom-checkbox mt-3 mr-3">
                            <input type="checkbox" id="customCheck-{{$module_index}}-all" onclick="checkAll(this,'{{$module_index}}')" class="custom-control-input">
                            <label class="custom-control-label" for="customCheck-{{$module_index}}-all">All</label>
                          </div>
                        </div>
                      </div>
                    </div>
                  </div>
                    @foreach($privilege->Actions as $action_index => $action)
                    <div class="col-md-3 mt-3">
                      <div class="custom-control custom-checkbox">
                        <input type="checkbox" id="customCheck-{{$module_index.'-'.$action_index}}" name="privileges[{{$privilege->slug}}][]" value="{{ $action->slug }}" {{(isset($staff_privileges[$privilege->slug]) && in_array($action->slug,$staff_privileges[$privilege->slug]))?'checked':'' }} class="custom-control-input p-chk">
                        <label class="custom-control-label" for="customCheck-{{$module_index.'-'.$action_index}}">{{$action->name}} <div class="text-danger">{{$action->slug}}</div></label>
                      </div>
                    </div>
                    @endforeach
                </div>
                @endforeach
                <!-- End Card -->                    
            </div>
          </div>
      </div>
    </div>
    <div class="save-btn">
      <button type="submit" class="btn add-btn btn-success"><i class="tio-save"></i> Save</button>
    </div>
    <!-- End Input Group -->
  </form>
  @endsection

@section('javascript')
<script type="text/javascript">
    
$(document).on('ready', function () {

  $("#form").submit(function(e){
      e.preventDefault();
      var formData = $("#form").serialize();
      var url  = $("#form").attr('action');
      $.ajax({
          url:url,
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
function checkAll(e,index){
  if($(e).is(":checked")){
    $("#module-"+index).find(".p-chk").prop("checked",true);
  }else{
    $("#module-"+index).find(".p-chk").prop("checked",false);
  }
}
</script>
@endsection