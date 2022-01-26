
@extends('layouts.master')
@section('style')
<style>
   textarea::-webkit-scrollbar {
      display: none;
      resize: none;
   }
   textarea{
      resize: none;
   }
   .chat span.avatar {
      width: 100% !important;
      height: 75% !important;
   }
   .avatar-img {
      height: auto;
  }
</style>
@endsection

@section('breadcrumb')
<!-- Content -->
<ol class="breadcrumb breadcrumb-no-gutter">
  <li class="breadcrumb-item"><a class="breadcrumb-link" href="{{ baseUrl('/') }}">Dashboard</a></li>
  <li class="breadcrumb-item active" aria-current="page">{{$pageTitle}}</li>
</ol>
<!-- End Content -->
@endsection



@section('content')
<!-- Content -->
<div class="chats">
 
  <div class="card purple lighten-4 chat-room">
      <div class="card-body">
        <div class="row">
            <div class="col-lg-4">
              <!-- Navbar -->
              <div class="navbar-vertical navbar-expand-lg">
                <!-- Navbar Toggle -->
                <button type="button" class="navbar-toggler btn btn-block btn-white mb-3" aria-label="Toggle navigation" aria-expanded="false" aria-controls="navbarVerticalNavMenu" data-toggle="collapse" data-target="#navbarVerticalNavMenu">
                  <span class="d-flex justify-content-between align-items-center">
                    <span class="h5 mb-0">Nav menu</span>

                    <span class="navbar-toggle-default">
                      <i class="tio-menu-hamburger"></i>
                    </span>

                    <span class="navbar-toggle-toggled">
                      <i class="tio-clear"></i>
                    </span>
                  </span>
                </button>
                <!-- End Navbar Toggle -->

                <!-- Navbar Collapse -->
                <div id="navbarVerticalNavMenu" class="collapse navbar-collapse">
                  <ul id="navbarSettings" class="js-sticky-block js-scrollspy navbar-nav navbar-nav-lg nav-tabs card card-navbar-nav"
                      data-hs-sticky-block-options='{
                       "parentSelector": "#navbarVerticalNavMenu",
                       "targetSelector": "#header",
                       "breakpoint": "lg",
                       "startPoint": "#navbarVerticalNavMenu",
                       "endPoint": "#stickyBlockEndPoint",
                       "stickyOffsetTop": 20
                     }'>
                    <li class="nav-item">
                      <a class="nav-link {{ ($chat_type == 'general')?'active':'' }}" href="{{ baseUrl('cases/chats/'.$case_id) }}">
                        <i class="tio-chat-outlined nav-icon"></i>
                        General Chats
                        @if($unread_general_chat['unread_chat'] == 0)
                              <i class="tio-chat-outlined"></i> {{$unread_general_chat['unread_chat']}}
                        @else
                            <span class="text-danger"><i class="tio-chat-outlined"></i>  {{$unread_general_chat['unread_chat']}}</span>
                        @endif
                      </a>
                    </li>
                    <li class="nav-item">
                      <a class="nav-link {{ ($chat_type == 'case_chat')?'active':'' }}" href="{{ baseUrl('cases/chats/'.$case_id.'?type=case_chat') }}">
                        <i class="tio-chat-outlined nav-icon"></i>
                          Case Chats 
                          @if($unread_case_chat['unread_chat'] == 0)
                              <i class="tio-chat-outlined"></i> {{$unread_case_chat['unread_chat']}}
                          @else
                              <span class="text-danger"><i class="tio-chat-outlined"></i>  {{$unread_case_chat['unread_chat']}}</span>
                          @endif
                      </a>
                    </li>
                    
                  </ul>
                </div>
                <!-- End Navbar Collapse -->
              </div>
              <!-- End Navbar -->
            </div>
            <div class="col-lg-8">
             <div class="chat-message">
                <ul class="list-unstyled chat">
                  
                </ul>
                <div class="chat-area">
                  <form class="form">  
                      <div class="row">
                        <div class="col-7 col-md-9">
                          <div class="message_input_wrapper">
                              <input class="form-control msg_textbox" id="message_input" placeholder="Type your message here..." />
                              <input type="file" name="chat_file" id="chat-attachment" style="display:none" />
                           </div>
                        </div>

                        <div class="col-5 col-md-3">
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
                     <div style='height: 0px;width:0px; overflow:hidden;'><input id="upfile" type="file" value="upload"/></div>
                  </form>
                </div>
             </div>
              <!-- Sticky Block End Point -->
              <div id="stickyBlockEndPoint"></div>
            </div>
        </div>
      </div>
  </div>
</div>
<!-- End Content -->
@endsection

@section('javascript')
<script src="assets/vendor/hs-scrollspy/dist/hs-scrollspy.min.js"></script>
<script src="assets/vendor/hs-sticky-block/dist/hs-sticky-block.min.js"></script>
<link rel="stylesheet" href="assets/vendor/mCustomScrollbar/jquery.mCustomScrollbar.css" />
<script src="assets/vendor/mCustomScrollbar/jquery.mCustomScrollbar.min.js"></script>
<script type="text/javascript">
$(document).ready(function(){
    
    $(".send-attachment").click(function(){
       document.getElementById('chat-attachment').click();
    });
    $(".chat").mCustomScrollbar();
    $(".send-message").click(function(){
       
       var message = $("#message_input").val();
       if(message != ''){
          $.ajax({
            type: "POST",
            url: "{{ baseUrl('cases/save-chat') }}",
            data:{
                _token:csrf_token,
                case_id:"{{$case_id}}",
                chat_type:"{{ $chat_type }}",
                client_id:"{{$client_id}}",
                message:message,
                type:"text",
            },
            dataType:'json',
            beforeSend:function(){
               $("#message_input,.send-message,.send-attachment").attr('disabled','disabled');
            },
            success: function (response) {
                if(response.status == true){
                   $("#message_input,.send-message,.send-attachment").removeAttr('disabled');
                   $("#message_input").val('');
                   $(".chat").html(response.html);
                   // $(".chat").mCustomScrollbar();
                   $(".chat").animate({ scrollTop: $(".chat")[0].scrollHeight}, 1000);
                   $(".doc_chat_input").show();
                   fetchChats();
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
       var message = $("#message_input").val();
       formData.append("_token",csrf_token);
       formData.append("case_id","{{$case_id}}");
       formData.append("chat_type","{{$chat_type}}");
       formData.append("client_id","{{$client_id}}");
       formData.append("message",message);
       formData.append('attachment', $('#chat-attachment')[0].files[0]);
       var url  = "{{ baseUrl('cases/save-chat-file') }}";
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
             $("#message_input,.send-message,.send-attachment").removeAttr('disabled');
             if(response.status == true){
                $("#chat-attachment").val('');
                $(".chat").html(response.html);
                // $(".chat").mCustomScrollbar();
                $(".chat").animate({ scrollTop: $(".chat")[0].scrollHeight}, 1000);
                $(".doc_chat_input").show();
                fetchChats();
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

  $('.js-sticky-block').each(function () {
      var stickyBlock = new HSStickyBlock($(this)).init();
  });

    // initialization of scroll nav
  var scrollspy = new HSScrollspy($('body'), {
    // !SETTING "resolve" PARAMETER AND RETURNING "resolve('completed')" IS REQUIRED
    beforeScroll: function(resolve) {
      if (window.innerWidth < 992) {
        $('#navbarVerticalNavMenu').collapse('hide').on('hidden.bs.collapse', function () {
          return resolve('completed');
        });
      } else {
        return resolve('completed');
      }
    }
  }).init();
});
fetchChats();
function fetchChats(){
  $.ajax({
    type: "POST",
    url: "{{ baseUrl('cases/fetch-chats') }}",
    data:{
        _token:csrf_token,
        case_id:"{{$case_id}}",
        chat_type:"{{ $chat_type }}",
        client_id:"{{$client_id}}"
    },
    dataType:'json',
    beforeSend:function(){
       $("#message_input").val('');
       $("#message_input,.send-message,.send-attachment").attr('disabled','disabled');
    },
    success: function (response) {
        $("#message_input,.send-message,.send-attachment").removeAttr('disabled');
        if(response.status == true){
           $(".chat").html(response.html);
           setTimeout(function(){
              
              $(".chat").animate({ scrollTop: $(".chat")[0].scrollHeight}, 1000);
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