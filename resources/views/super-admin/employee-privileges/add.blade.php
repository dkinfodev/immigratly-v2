@extends('layouts.master')


@section('breadcrumb')
<!-- Content -->
<ol class="breadcrumb breadcrumb-no-gutter">
  <li class="breadcrumb-item"><a class="breadcrumb-link" href="{{ baseUrl('/') }}">Dashboard</a></li>
  <li class="breadcrumb-item"><a class="breadcrumb-link" href="{{ baseUrl('/employee-privileges') }}">Employee Privileges</a></li>
    <li class="breadcrumb-item active" aria-current="page">{{$pageTitle}}</li>

</ol>
<!-- End Content -->
@endsection


@section('header-right')
     <a class="btn btn-primary" href="{{baseUrl('employee-privileges/')}}">
          <i class="tio mr-1"></i> Back 
        </a>
@endsection


@section('content')
<!-- Content -->
<div class="employee_privileges">
  

  <!-- Card -->
  <div class="card">

    <div class="card-body">
      <form id="form" class="js-validate" action="{{ baseUrl('/employee-privileges/save') }}" method="post">

        @csrf
        <!-- Input Group -->
        <div class="js-form-message form-group row">
          <label class="col-sm-2 col-form-label">Name</label>
          <div class="col-sm-10">
           <input type="text" name="name" id="name" placeholder="Enter name" class="form-control">
         </div>
       </div>
       
       <!-- End Input Group -->


      <div class="form-group">
        <button type="submit" class="btn add-btn btn-primary">Add</button>
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
            redirect(response.redirect_back);
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