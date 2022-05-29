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
        </div>
        <div class="card-body">
            <p class="card-text">{!! $record->description !!}</p>
        </div>
    </div>
    @if($record->assign_case == 1)
    <div class="card">
        <div class="card-header p-0 pl-5">
            <h5 class="card-header-title">Case Assigned to Professional</h5>
        </div>
        <div class="card-body">
            <span class="text-success">Case Awarded</span>
            <div class="text-danger">
                @php 
                $company_data = professionalDetail($record->assign_to);
                echo $company_data->company_name;
                @endphp
            </div>
        </div>
    </div>
    @else
        
        @if(count($comments) > 0)
            <div class="card">
                <div class="card-header p-0 pl-5">
                    <h5 class="card-header-title">Professionals Comments</h5>
                </div>
                <div class="card-body">
                    @foreach($comments as $key => $comment)
                        <div class="comment-block">
                            <div class="card-title float-left">
                                @php 
                                    $company_data = professionalDetail($comment->professional);
                                    echo $company_data->company_name;
                                @endphp
                            </div>
                            <div class="float-right mb-3">
                                <div class="text-right">
                                    <a href="{{ baseUrl('professional/'.$comment->professional) }}" class="badge badge-danger btn-sm">View Professional</a>
                                    <a href="{{ baseUrl('my-cases/start-case/'.$record->unique_id.'/'.$comment->professional) }}" class="badge badge-warning btn-sm">Start a Case</a>
                                </div>
                            </div>
                            <div class="clearfix"></div>
                            @foreach($comment->caseComments as $com)
                                <div class="comments p-3 bg-white mb-2">
                                    <div class="comment-header">
                                        <div class="float-right">
                                            <div class="text-muted">Date Posted: {{dateFormat($com->created_at) }}</div>
                                            <div class="text-muted">Posted By: 
                                                @if($com->added_by == Auth::user()->unique_id)
                                                    - You
                                                @else
                                                    - Professional
                                                @endif
                                            </div>
                                        </div>
                                        <div class="clearfix"></div>
                                    </div>
                                    <div class="comment-body p-3">
                                        {!! $com->comments !!}
                                    </div>
                                    <div class="comment-footer">
                                        <div class="text-right">
                                            @if($com->added_by == Auth::user()->unique_id)
                                            <a href="javascript:;" onclick="showPopup('<?php echo baseUrl('my-cases/edit-comment/'.$com->unique_id); ?>')" class="btn btn-primary btn-sm">Edit</a>
                                            <a  href="javascript:;" onclick="confirmAction(this)" data-href="{{baseUrl('my-cases/delete-comment/'.$com->unique_id) }}" class="btn btn-danger btn-sm">Delete</a>
                                            @endif
                                        </div>
                                    </div>
                                </div>
                            @endforeach
                            <div class="comment-footer">
                                <form id="form-{{$key}}" action="{{ baseUrl('my-cases/post-comment/'.$record->unique_id) }}" method="post">
                                    @csrf
                                    <div class="card">
                                        <input type="hidden" name="professional" value="{{$comment->professional}}" />
                                        <div class="card-body">
                                            <h5 class="card-header-title">Post your comment</h5>
                                            <div class=" js-form-message">
                                                <textarea class="form-control editor" id="comments-{{$key}}" name="comments"></textarea>
                                            </div>
                                            <button type="button" onclick="submitComment('form-{{$key}}')" class="ml-1 mt-3 btn btn-primary">Save</button>
                                        </div>
                                    </div>
                                </form>
                            </div>
                        </div>
                    @endforeach
                </div>
            </div>
        @endif

    @endif
</div>
<!-- End Content -->
@endsection

@section('javascript')
<script type="text/javascript">
$(document).ready(function() {
//  $(".editor").each(function(){
//     var id = $(this).attr("id");
//     initEditor(id); 
//  })
  

//   $("#form").submit(function(e){
//       e.preventDefault();
//       var formData = $("#form").serialize();
//       var url  = $("#form").attr('action');
//       $.ajax({
//           url:url,
//           type:"post",
//           data:formData,
//           dataType:"json",
//           beforeSend:function(){
//             showLoader();
//           },
//           success:function(response){
//             hideLoader();
//             if(response.status == true){
//               successMessage(response.message);
//               location.reload();
//             }else{
//               validation(response.message);
//               // errorMessage(response.message);
//             }
//           },
//           error:function(){
//             internalError();
//           }
//       });
//   });
});

function submitComment(form_id){
    var formData = $("#"+form_id).serialize();
      var url  = $("#"+form_id).attr('action');
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
}
</script>
@endsection