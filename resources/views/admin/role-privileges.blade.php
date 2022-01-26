@extends('layouts.master')
@section('breadcrumb')
<!-- Content -->
<ol class="breadcrumb breadcrumb-no-gutter">
  <li class="breadcrumb-item"><a class="breadcrumb-link" href="{{ baseUrl('/') }}">Dashboard</a></li>
  <li class="breadcrumb-item active" aria-current="page">{{$pageTitle}}</li>
</ol>
<!-- End Content -->
@endsection


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
<div class="role_privileges">
  
  <!-- Card -->
  <form id="form" class="js-validate" action="{{ baseUrl('/role-privileges') }}" method="post">
    @csrf
    <!-- Input Group -->
    <div class="row justify-content-md-between">
      <div class="col-md-12">
        <div class="accordion" id="rolesCollapse">
          @foreach($roles as $role_index => $role)
          <div class="card mb-5" id="heading-{{$role_index}}">
            <div class="row">
              <div class="col-md-6">
                <a class="card-header card-btn btn-block" href="javascript:;" aria-expanded="true" aria-controls="collapse-{{$role_index}}">
                  <span class="page-header-title h4 text-danger">
                  <i class="tio-arrow-large-forward"></i>  {{$role['name']}}
                  </span>
                </a>
              </div>
              <div class="col-md-6 text-right">
                <div class="custom-control custom-checkbox mt-3 mr-3">
                  <input type="checkbox" id="customCheck-{{$role_index}}-all" onclick="checkAll(this,'{{$role_index}}')" class="custom-control-input">
                  <label class="custom-control-label" for="customCheck-{{$role_index}}-all">All</label>
                </div>
              </div>
            </div>

            <div id="collapse-{{$role_index}}" class="collapse show" aria-labelledby="heading-{{$role_index}}">
              <div class="card-body">
                  <!-- Card -->
                  @foreach($privileges as $module_index => $privilege)
                  <div class="row mb-3">
                    <div class="col-md-12">
                      <div class="mb-0">
                        <div class="row align-items-center">
                          <div class="col-sm">
                            <h1 class="page-header-title">{{$privilege['name']}}</h1>
                          </div>
                        </div>
                      </div>
                    </div>
                    @foreach($privilege['actions'] as $action_index => $action)
                      <div class="col-md-3 mt-3">

                        <div class="custom-control custom-checkbox">
                          <input type="checkbox" id="customCheck-{{$role_index.'-'.$module_index.'-'.$action_index}}" name="privileges[{{$role['slug']}}][{{$privilege['slug']}}][]" value="{{ $action['slug'] }}" {{(isset($role_privileges[$role['slug']][$privilege['slug']]) && in_array($action['slug'],$role_privileges[$role['slug']][$privilege['slug']]))?"checked":"" }} class="custom-control-input">
                          <label class="custom-control-label" for="customCheck-{{$role_index.'-'.$module_index.'-'.$action_index}}">{{$action['name']}} <div class="text-danger">{{$action['slug']}}</div></label>
                        </div>
                      </div>
                    @endforeach
                  </div>
                  @endforeach
                  <!-- End Card -->                    
              </div>
            </div>
          </div>
          @endforeach
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
              successMessage(response.message);
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
    $("#collapse-"+index).find(".custom-control-input").prop("checked",true);
  }else{
    $("#collapse-"+index).find(".custom-control-input").prop("checked",false);
  }
}
</script>
@endsection