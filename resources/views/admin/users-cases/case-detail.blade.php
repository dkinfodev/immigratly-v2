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
    @if(count($comments) > 0)
            <div class="card">
                <div class="card-header p-0 pl-5">
                    <h5 class="card-header-title">Professionals Comments</h5>
                </div>
                <div class="card-body">
                    @foreach($comments as $comment)
                        <div class="comment-block">
                            <div class="comment-header">
                                <div class="card-title float-left">
                                    @php 
                                        $company_data = professionalDetail($comment->professional);
                                        echo $company_data->company_name
                                    @endphp
                                </div>
                                <div class="float-right">
                                    <div class="text-muted">Date Posted: {{dateFormat($comment->created_at) }}</div>
                                </div>
                                <div class="clearfix"></div>
                            </div>
                            <div class="comment-body">
                                {!! $comment->comments !!}
                            </div>
                            <div class="text-right">
                                @if($comment->added_by == Auth::user()->unique_id)
                                <a href="javascript:;" onclick="showPopup('<?php echo baseUrl('users-cases/edit-comment/'.$comment->unique_id); ?>')" class="btn btn-primary btn-sm">Edit</a>
                                <a  href="javascript:;" onclick="confirmAction(this)" data-href="{{baseUrl('users-cases/delete-comment/'.$comment->unique_id) }}" class="btn btn-danger btn-sm">Delete</a>
                                @endif
                            </div>
                        </div>
                    @endforeach
                </div>
            </div>
        @endif
        <form id="form" action="{{ baseUrl('users-cases/post-comment/'.$record->unique_id) }}" method="post">
            @csrf
    
            <div class="card">
                <div class="card-header p-0 pl-5">
                    <h5 class="card-header-title">Post your comment</h5>
                </div>
                <div class="card-body">
                <div class=" js-form-message">
                    <textarea class="form-control" id="comments" name="comments"></textarea>
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