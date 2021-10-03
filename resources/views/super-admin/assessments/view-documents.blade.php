@extends('layouts.master')
@section("style")
<style>
   .all_services li {
   padding: 16px;
   border-bottom: 1px solid #ddd;
   }
   .sub_services li {
   border-bottom: none;
   }
   .chat_window{
    top:35%;
   }
</style>
@endsection
@section('content')
<div class="content container-fluid">
  <!-- Page Header -->
  <div class="page-header">
    <div class="row align-items-end">
      <div class="col-sm mb-2 mb-sm-0">
        <nav aria-label="breadcrumb">
          <ol class="breadcrumb breadcrumb-no-gutter">
            <li class="breadcrumb-item"><a class="breadcrumb-link" href="{{ baseUrl('/') }}">Dashboard</a></li>
            <li class="breadcrumb-item"><a class="breadcrumb-link" href="{{ baseUrl('/assessments') }}">Assessments</a></li>
            <li class="breadcrumb-item active" aria-current="page">{{$pageTitle}}</li>
          </ol>
        </nav>
        <h1 class="page-title">{{$pageTitle}}</h1>
      </div>

      <div class="col-sm-auto">
        <a class="btn btn-primary" href="{{baseUrl('/assessments/view/'.$assessment_id)}}">
          <i class="tio mr-1"></i> Back 
        </a>
      </div>
    </div>
    <!-- End Row -->
  </div>
  <!-- End Page Header -->

  <!-- Card -->
   <div class="row">
      <div class="col-md-12">
         <div class="card">
          <div class="card-header">
              <div class="text-right">
                <a href="{{$url}}" class="text-primary" download><i class="tio-download"></i> Download</a>
              </div>
          </div>
          <div class="card-body">
            @if($extension == 'image')
              <img src="{{$url}}" class="img-fluid" />
            @else
              @if(google_doc_viewer($extension))
                <iframe src="http://docs.google.com/viewer?url={{$url}}&embedded=true" style="margin:0 auto; width:100%; height:700px;" frameborder="0"></iframe>
              @else
              <iframe src="{{$url}}" style="margin:0 auto; width:100%; height:700px;" frameborder="0"></iframe>
              @endif
            @endif
          </div>
         </div>
      </div>
      <!-- <div class="col-md-5">
         <div class="card" style="margin:0 auto; width:100%; height:750px;">
          <div class="card-body sidebar-body">
             <div class="chat_window3">
                <ul class="messages">
                   
                </ul>
                <div class="doc_chat_input bottom_wrapper clearfix">
                   <div class="message_input_wrapper">
                      <input class="form-control msg_textbox" id="message_input" placeholder="Type your message here..." />
                      <input type="file" name="chat_file" id="chat-attachment" style="display:none" />
                      
                   </div>
                   <div class="btn-group send-btn">
                      <button type="button" class="btn btn-primary btn-pill send-message">
                        <i class="tio-send"></i>
                      </button>
                      <button type="button" class="btn btn-info btn-pill send-attachment">
                        <i class="tio-attachment"></i>
                      </button>
                   </div>
                </div>
             </div>
             <div class="message_template">
                <li class="message">
                   <div class="avatar"></div>
                   <div class="text_wrapper">
                      <div class="text"></div>
                   </div>
                </li>
             </div>
          </div>
         </div>
      </div> -->
   </div>
</div>
@endsection

@section("javascript")
<link rel="stylesheet" href="assets/vendor/mCustomScrollbar/jquery.mCustomScrollbar.css" />
<script src="assets/vendor/mCustomScrollbar/jquery.mCustomScrollbar.min.js"></script>
<script>
$(document).ready(function(){
  var height = $(".sidebar-body").height() - 80;
  $(".messages").css("height",height+"px");
  $('.js-hs-action').each(function () {
   var unfold = new HSUnfold($(this)).init();
  });
});

</script>
@endsection