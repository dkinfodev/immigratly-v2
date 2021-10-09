@extends('layouts.master')

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
<div class="view-documents">
  <!-- Page Header -->

  <!-- End Page Header -->

  <!-- Card -->
   <div class="row">
      <div class="col-md-7">
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
      <div class="col-md-5">
         <div class="card" style="margin:0 auto; width:100%; height:750px;">
         <div class="card-header">
            <h3>Document Notes</h3>
         </div>
          <div class="card-body sidebar-body">
             <div class="chat_window3">
                <ul class="messages">
                   
                </ul>
                
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
          <div class="card-footer">
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
         </div>
      </div>
   </div>
</div>
@endsection

@section("javascript")
<link rel="stylesheet" href="assets/vendor/mCustomScrollbar/jquery.mCustomScrollbar.css" />
<script src="assets/vendor/mCustomScrollbar/jquery.mCustomScrollbar.min.js"></script>
<script>
var case_id,document_id;
fetchChats("{{$case_id}}","{{$document_id}}");
$(document).ready(function(){
    var height = $(".sidebar-body").height() - 80;
    $(".messages").css("height",height+"px");
    $('.js-hs-action').each(function () {
     var unfold = new HSUnfold($(this)).init();
    });
    
    $(".send-attachment").click(function(){
       document.getElementById('chat-attachment').click();
    });
    $(".send-message").click(function(){
       
       var message = $("#message_input").val();
       if(message != ''){
          $.ajax({
            type: "POST",
            url: "{{ baseUrl('cases/documents/send-chats') }}",
            data:{
                _token:csrf_token,
                case_id:case_id,
                document_id:document_id,
                message:message,
                type:"text",
                subdomain:"{{$subdomain}}"
            },
            dataType:'json',
            beforeSend:function(){
               $("#message_input,.send-message,.send-attachment").attr('disabled','disabled');
            },
            success: function (response) {
                if(response.status == true){
                   $("#message_input,.send-message,.send-attachment").removeAttr('disabled');
                   $("#message_input").val('');
                   $(".messages").html(response.html);
                   $(".messages").mCustomScrollbar();
                   $(".messages").animate({ scrollTop: $(".messages")[0].scrollHeight}, 1000);
                   $(".doc_chat_input").show();
                   fetchChats(case_id,document_id);
                }else{
                   errorMessage(response.message);
                }
            },
            error:function(){
             $("#message_input,.send-message,.send-attachment").removeAttr('disabled');
             internalError();
            }
          });
       }
    });

    $("#chat-attachment").change(function(){
       var formData = new FormData();
       formData.append("_token",csrf_token);
       formData.append("case_id",case_id);
       formData.append("document_id",document_id);
       formData.append("subdomain","{{$subdomain}}");
       formData.append('attachment', $('#chat-attachment')[0].files[0]);
       var url  = "{{ baseUrl('cases/documents/send-chat-file') }}";
       $.ajax({
          url:url,
          type:"post",
          data:formData,
          cache: false,
          contentType: false,
          processData: false,
          dataType:"json",
          beforeSend:function(){
             $("#message_input,.send-message,.send-attachment").attr('disabled','disabled');
          },
          success: function (response) {
             if(response.status == true){
                $("#message_input,.send-message,.send-attachment").removeAttr('disabled');
                $("#chat-attachment").val('');
                $(".messages").html(response.html);
                $(".messages").mCustomScrollbar();
                $(".messages").animate({ scrollTop: $(".messages")[0].scrollHeight}, 1000);
                $(".doc_chat_input").show();
                fetchChats(case_id,document_id);
             }else{
                errorMessage(response.message);
             }
          },
          error:function(){
             $("#message_input,.send-message,.send-attachment").removeAttr('disabled');
             internalError();
          }
       });
    });
 });
function fetchChats(c_id,d_id){
    case_id = c_id;
    document_id = d_id;
    $.ajax({
      type: "POST",
      url: "{{ baseUrl('cases/documents/fetch-chats') }}",
      data:{
          _token:csrf_token,
          case_id:case_id,
          document_id:document_id,
          subdomain:"{{$subdomain}}"
      },
      dataType:'json',
      beforeSend:function(){
         $("#message_input").val('');
         $("#message_input,.send-message,.send-attachment").attr('disabled','disabled');
      },
      success: function (response) {
          if(response.status == true){
             $("#message_input,.send-message,.send-attachment").removeAttr('disabled');
             $(".messages").html(response.html);
             setTimeout(function(){
                $(".messages").mCustomScrollbar();
                $(".messages").animate({ scrollTop: $(".messages")[0].scrollHeight}, 1000);
             },800);
             
             $(".doc_chat_input").show();
          }else{
             errorMessage(response.message);
          }
      },
      error:function(){
       internalError();
      }
    });
 }
</script>
@endsection