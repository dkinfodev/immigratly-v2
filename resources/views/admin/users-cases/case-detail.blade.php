@extends('layouts.master')

@section('breadcrumb')
<!-- Content -->
<ol class="breadcrumb breadcrumb-no-gutter">
    <li class="breadcrumb-item"><a class="breadcrumb-link" href="{{ baseUrl('/') }}">Dashboard</a></li>
    <li class="breadcrumb-item active" aria-current="page">{{$pageTitle}}</li>
</ol>
<!-- End Content -->
@endsection


@section('content')

<style>
.dropdown-menu {
    z-index: 999;
}
</style>
<!-- Content -->
<div class="case-list">
    <div class="card">
        <div class="card-header">
            <h5 class="card-header-title float-left">{{$record->case_title}}</h5>
            <div class="text-muted float-right">{{dateFormat($record->created_at) }}</div>
            <div class="clearfix"></div>
            <small class="text-muted">User ID: {{$record->user_id}}</small>
        </div>
        <div class="card-body">
            <p class="card-text">{!! $record->description !!}</p>
        </div>
    </div>
    <form id="form" action="{{ baseUrl('users-cases/post-comment/'.$record->unique_id) }}" method="post">
        @csrf
        @if(!empty($comment))
          <input type="hidden" name="id" value="{{ $comment->unique_id }}" />
        @endif
        <div class="card">
            <div class="card-header p-0 pl-5">
                <h5 class="card-header-title">Post your comment</h5>
            </div>
            <div class="card-body">
              <div class=" js-form-message">
                <textarea class="form-control" id="comments" name="comments">
                @if(!empty($comment))
                  {!! $comment->comments !!}
                @endif
                </textarea>
              </div>
            </div>
            <div class="card-footer text-center">
                  <button class="btn btn-primary">Save</button>
            </div>
        </div>
    </form>
</div>
<!-- End Content -->
@endsection

@section('javascript')
<script type="text/javascript">
$(document).ready(function() {
  initEditor("comments"); 

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
              location.reload();
            }else{
              validation(response.message);
              // errorMessage(response.message);
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