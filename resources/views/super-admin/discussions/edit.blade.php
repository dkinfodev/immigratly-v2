@extends('layouts.master-old')

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
<!-- Content -->
<div class="discussions">
  <!-- Page Header -->
  <div class="page-header">
    <div class="row align-items-end">
      <div class="col-sm mb-2 mb-sm-0">
        <nav aria-label="breadcrumb">
          <ol class="breadcrumb breadcrumb-no-gutter">
            <li class="breadcrumb-item"><a class="breadcrumb-link" href="{{ baseUrl('/') }}">Dashboard</a></li>
            <li class="breadcrumb-item"><a class="breadcrumb-link" href="{{ baseUrl('/discussions') }}">Chat Groups</a></li>
            <li class="breadcrumb-item active" aria-current="page">{{$pageTitle}}</li>
          </ol>
        </nav>

        <h1 class="page-title">{{$pageTitle}}</h1>
      </div>

      <div class="col-sm-auto">
        <a class="btn btn-primary" href="{{ baseUrl('/discussions') }}">
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
      <form id="form" class="js-validate" action="{{ baseUrl('discussions/update/'.$record->unique_id) }}" method="post">
        @csrf
        <div class="row form-group">
          <label class="col-sm-3 col-form-label input-label">Chat Group Title</label>

          <div class="col-sm-9">
            <div class="js-form-message">
              <input type="text" class="form-control" name="group_title" id="group_title" placeholder="Enter Chat Group Title" aria-label="Case Name"  data-msg="Please enter chat group title." value="{{$record->group_title}}">
            </div>
          </div>
        </div>
        <div class="row form-group">
          <label class="col-sm-3 col-form-label input-label">Description</label>
          <div class="col-sm-9">
            <div class="js-form-message">
              <textarea name="description" data-msg="Please enter description." id="description" class="form-control editor">{{$record->description}}</textarea>
            </div>
          </div>
        </div>
        <div class="form-group">
          <button type="submit" class="btn add-btn btn-primary">Save</button>
        </div>
      </form>
    </div>
  </div>
<!-- End Content -->
@endsection

@section('javascript')
<!-- JS Implementing Plugins -->


<script>
  $(document).on('ready', function () {
    
    initEditor("description"); 

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