@extends('layouts.master')

@section('breadcrumb')
<!-- Content -->
<ol class="breadcrumb breadcrumb-no-gutter">
  <li class="breadcrumb-item"><a class="breadcrumb-link" href="{{ baseUrl('/') }}">Dashboard</a></li>
   <li class="breadcrumb-item"><a class="breadcrumb-link" href="{{ baseUrl('/cases') }}">Cases</a></li>
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
</style>
<!-- Content -->
<div class="content container-fluid">
    
    <!-- Card -->
    <div class="card">

        <div class="card-body">
            <form method="post" id="form" class="js-validate"
                action="{{ baseUrl('/cases/stages/edit/'.$record->unique_id) }}">
                @csrf
                
                <!-- Form Group -->
                <div class="row form-group js-form-message">
                    <label class="col-sm-3 col-form-label input-label">Name</label>
                    <div class="col-sm-9">
                        <div class="input-group input-group-sm-down-break">
                            <input type="text" class="form-control @error('name') is-invalid @enderror"
                                name="name" id="name" placeholder="Enter stage name"
                                aria-label="Enter stage name" value="{{ $record->name }}">
                            @error('name')
                            <span class="invalid-feedback" role="alert">
                                <strong>{{ $message }}</strong>
                            </span>
                            @enderror
                        </div>
                    </div>
                </div>

                <div class="row form-group js-form-message">
                    <label class="col-sm-3 col-form-label input-label">Short Description</label>
                    <div class="col-sm-9">
                        <div class="input-group input-group-sm-down-break">
                            <textarea type="text"
                                class="form-control ckeditor @error('short_description') is-invalid @enderror"
                                name="short_description" id="short_description" placeholder="Enter short description"
                                aria-label="Enter short description"><?php echo $record->short_description ?></textarea>
                            @error('short_description')
                            <span class="invalid-feedback" role="alert">
                                <strong>{{ $message }}</strong>
                            </span>
                            @enderror
                        </div>
                    </div>
                </div>
                
                <!-- End Form Group -->
                <div class="form-group">
                    <button type="submit" class="btn add-btn btn-primary">Save</button>
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
// initEditor("description");

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