@extends('layouts.master')

@section('content')
<div class="content container-fluid">
        <!-- Page Header -->
        <div class="page-header">
          <div class="row align-items-center">
            <div class="col-sm mb-2 mb-sm-0">
              <h1 class="page-header-title">Dashboard</h1>
            </div>

            <div class="col-sm-auto">
                <a onclick="fetchChats()" class="btn btn-primary js-hs-unfold-invoker" href="javascript:;"
                            data-hs-unfold-options='{
                            "target": "#activitySidebar",
                            "type": "css-animation",
                            "animationIn": "fadeInRight",
                            "animationOut": "fadeOutRight",
                            "hasOverlay": true,
                            "smartPositionOff": true
                            }'>
                  <i class="tio-chat mr-1"></i> Chat with Support
                  @if($unread_chats > 0)
                        <span class="badge badge-danger">{{$unread_chats}}</span>
                  @endif
                </a>
            </div>
          </div>
        </div>
        <!-- End Page Header -->

        <!-- Stats -->
        <div class="row gx-2 gx-lg-3">
          <div class="col-sm-6 col-lg-3 mb-3 mb-lg-5">
            <!-- Card -->
            <a class="card card-hover-shadow h-100" href="#">
              <div class="card-body">
                <h6 class="card-subtitle">Total Users</h6>

                <div class="row align-items-center gx-2 mb-1">
                  <div class="col-6">
                    <span class="card-title h2">72,540</span>
                  </div>

                  <div class="col-6">
                    <!-- Chart -->
                    <div class="chartjs-custom" style="height: 3rem;">
                      <canvas class="js-chart"
                              data-hs-chartjs-options='{
                                "type": "line",
                                "data": {
                                   "labels": ["1 May","2 May","3 May","4 May","5 May","6 May","7 May","8 May","9 May","10 May","11 May","12 May","13 May","14 May","15 May","16 May","17 May","18 May","19 May","20 May","21 May","22 May","23 May","24 May","25 May","26 May","27 May","28 May","29 May","30 May","31 May"],
                                   "datasets": [{
                                    "data": [21,20,24,20,18,17,15,17,18,30,31,30,30,35,25,35,35,40,60,90,90,90,85,70,75,70,30,30,30,50,72],
                                    "backgroundColor": ["rgba(55, 125, 255, 0)", "rgba(255, 255, 255, 0)"],
                                    "borderColor": "#377dff",
                                    "borderWidth": 2,
                                    "pointRadius": 0,
                                    "pointHoverRadius": 0
                                  }]
                                },
                                "options": {
                                   "scales": {
                                     "yAxes": [{
                                       "display": false
                                     }],
                                     "xAxes": [{
                                       "display": false
                                     }]
                                   },
                                  "hover": {
                                    "mode": "nearest",
                                    "intersect": false
                                  },
                                  "tooltips": {
                                    "postfix": "k",
                                    "hasIndicator": true,
                                    "intersect": false
                                  }
                                }
                              }'>
                      </canvas>
                    </div>
                    <!-- End Chart -->
                  </div>
                </div>
                <!-- End Row -->

                <span class="badge badge-soft-success">
                  <i class="tio-trending-up"></i> 12.5%
                </span>
                <span class="text-body font-size-sm ml-1">from 70,104</span>
              </div>
            </a>
            <!-- End Card -->
          </div>

          <div class="col-sm-6 col-lg-3 mb-3 mb-lg-5">
            <!-- Card -->
            <a class="card card-hover-shadow h-100" href="#">
              <div class="card-body">
                <h6 class="card-subtitle">Sessions</h6>

                <div class="row align-items-center gx-2 mb-1">
                  <div class="col-6">
                    <span class="card-title h2">29.4%</span>
                  </div>

                  <div class="col-6">
                    <!-- Chart -->
                    <div class="chartjs-custom" style="height: 3rem;">
                      <canvas class="js-chart"
                              data-hs-chartjs-options='{
                                "type": "line",
                                "data": {
                                   "labels": ["1 May","2 May","3 May","4 May","5 May","6 May","7 May","8 May","9 May","10 May","11 May","12 May","13 May","14 May","15 May","16 May","17 May","18 May","19 May","20 May","21 May","22 May","23 May","24 May","25 May","26 May","27 May","28 May","29 May","30 May","31 May"],
                                   "datasets": [{
                                    "data": [21,20,24,20,18,17,15,17,30,30,35,25,18,30,31,35,35,90,90,90,85,100,120,120,120,100,90,75,75,75,90],
                                    "backgroundColor": ["rgba(55, 125, 255, 0)", "rgba(255, 255, 255, 0)"],
                                    "borderColor": "#377dff",
                                    "borderWidth": 2,
                                    "pointRadius": 0,
                                    "pointHoverRadius": 0
                                  }]
                                },
                                "options": {
                                   "scales": {
                                     "yAxes": [{
                                       "display": false
                                     }],
                                     "xAxes": [{
                                       "display": false
                                     }]
                                   },
                                  "hover": {
                                    "mode": "nearest",
                                    "intersect": false
                                  },
                                  "tooltips": {
                                    "postfix": "%",
                                    "hasIndicator": true,
                                    "intersect": false
                                  }
                                }
                              }'>
                      </canvas>
                    </div>
                    <!-- End Chart -->
                  </div>
                </div>
                <!-- End Row -->

                <span class="badge badge-soft-success">
                  <i class="tio-trending-up"></i> 1.7%
                </span>
                <span class="text-body font-size-sm ml-1">from 29.1%</span>
              </div>
            </a>
            <!-- End Card -->
          </div>

          <div class="col-sm-6 col-lg-3 mb-3 mb-lg-5">
            <!-- Card -->
            <a class="card card-hover-shadow h-100" href="#">
              <div class="card-body">
                <h6 class="card-subtitle">Avg. Click Rate</h6>

                <div class="row align-items-center gx-2 mb-1">
                  <div class="col-6">
                    <span class="card-title h2">56.8%</span>
                  </div>

                  <div class="col-6">
                    <!-- Chart -->
                    <div class="chartjs-custom" style="height: 3rem;">
                      <canvas class="js-chart"
                              data-hs-chartjs-options='{
                                "type": "line",
                                "data": {
                                   "labels": ["1 May","2 May","3 May","4 May","5 May","6 May","7 May","8 May","9 May","10 May","11 May","12 May","13 May","14 May","15 May","16 May","17 May","18 May","19 May","20 May","21 May","22 May","23 May","24 May","25 May","26 May","27 May","28 May","29 May","30 May","31 May"],
                                   "datasets": [{
                                    "data": [25,18,30,31,35,35,60,60,60,75,21,20,24,20,18,17,15,17,30,120,120,120,100,90,75,90,90,90,75,70,60],
                                    "backgroundColor": ["rgba(55, 125, 255, 0)", "rgba(255, 255, 255, 0)"],
                                    "borderColor": "#377dff",
                                    "borderWidth": 2,
                                    "pointRadius": 0,
                                    "pointHoverRadius": 0
                                  }]
                                },
                                "options": {
                                   "scales": {
                                     "yAxes": [{
                                       "display": false
                                     }],
                                     "xAxes": [{
                                       "display": false
                                     }]
                                   },
                                  "hover": {
                                    "mode": "nearest",
                                    "intersect": false
                                  },
                                  "tooltips": {
                                    "postfix": "%",
                                    "hasIndicator": true,
                                    "intersect": false
                                  }
                                }
                              }'>
                      </canvas>
                    </div>
                    <!-- End Chart -->
                  </div>
                </div>
                <!-- End Row -->

                <span class="badge badge-soft-danger">
                  <i class="tio-trending-down"></i> 4.4%
                </span>
                <span class="text-body font-size-sm ml-1">from 61.2%</span>
              </div>
            </a>
            <!-- End Card -->
          </div>

          <div class="col-sm-6 col-lg-3 mb-3 mb-lg-5">
            <!-- Card -->
            <a class="card card-hover-shadow h-100" href="#">
              <div class="card-body">
                <h6 class="card-subtitle">Pageviews</h6>

                <div class="row align-items-center gx-2 mb-1">
                  <div class="col-6">
                    <span class="card-title h2">92,913</span>
                  </div>

                  <div class="col-6">
                    <!-- Chart -->
                    <div class="chartjs-custom" style="height: 3rem;">
                      <canvas class="js-chart"
                              data-hs-chartjs-options='{
                                "type": "line",
                                "data": {
                                   "labels": ["1 May","2 May","3 May","4 May","5 May","6 May","7 May","8 May","9 May","10 May","11 May","12 May","13 May","14 May","15 May","16 May","17 May","18 May","19 May","20 May","21 May","22 May","23 May","24 May","25 May","26 May","27 May","28 May","29 May","30 May","31 May"],
                                   "datasets": [{
                                    "data": [21,20,24,15,17,30,30,35,35,35,40,60,12,90,90,85,70,75,43,75,90,22,120,120,90,85,100,92,92,92,92],
                                    "backgroundColor": ["rgba(55, 125, 255, 0)", "rgba(255, 255, 255, 0)"],
                                    "borderColor": "#377dff",
                                    "borderWidth": 2,
                                    "pointRadius": 0,
                                    "pointHoverRadius": 0
                                  }]
                                },
                                "options": {
                                   "scales": {
                                     "yAxes": [{
                                       "display": false
                                     }],
                                     "xAxes": [{
                                       "display": false
                                     }]
                                   },
                                  "hover": {
                                    "mode": "nearest",
                                    "intersect": false
                                  },
                                  "tooltips": {
                                    "postfix": "k",
                                    "hasIndicator": true,
                                    "intersect": false
                                  }
                                }
                              }'>
                      </canvas>
                    </div>
                    <!-- End Chart -->
                  </div>
                </div>
                <!-- End Row -->

                <span class="badge badge-soft-secondary">0.0%</span>
                <span class="text-body font-size-sm ml-1">from 2,913</span>
              </div>
            </a>
            <!-- End Card -->
          </div>
        </div>
        <!-- End Stats -->

      </div>
       <!-- Sidebar -->
       <div id="activitySidebar" class="hs-unfold-content sidebar sidebar-bordered sidebar-box-shadow">
         <div class="card card-lg sidebar-card sidebar-scrollbar">
            <div class="card-header">
               <h4 class="card-header-title">Support Chats</h4>
               <!-- Toggle Button -->
               <a class="js-hs-unfold-invoker btn btn-icon btn-xs btn-ghost-dark ml-2" href="javascript:;"
                  data-hs-unfold-options='{
                  "target": "#activitySidebar",
                  "type": "css-animation",
                  "animationIn": "fadeInRight",
                  "animationOut": "fadeOutRight",
                  "hasOverlay": true,
                  "smartPositionOff": true
                  }'>
               <i class="tio-clear tio-lg"></i>
               </a>
               <!-- End Toggle Button -->
            </div>
            <!-- Body -->
            <div class="card-body sidebar-body">
               <div class="chat_window">
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
            <!-- End Body -->
         </div>
      </div>
      <!-- End Sidebar -->  
@endsection

@section("javascript")
<link rel="stylesheet" href="assets/vendor/mCustomScrollbar/jquery.mCustomScrollbar.css" />
<script src="assets/vendor/mCustomScrollbar/jquery.mCustomScrollbar.min.js"></script>
<script>
$(document).ready(function(){
    $(".send-message").click(function(){
       var message = $("#message_input").val();
       if(message != ''){
       $.ajax({
           type: "POST",
           url: "{{ baseUrl('send-message-to-support') }}",
           data:{
               _token:csrf_token,
               message:message,
               type:"text",
           },
           dataType:'json',
           beforeSend:function(){
               // var html = '<div class="text-center"><div class="spinner-border" role="status"><span class="sr-only">Loading...</span></div>';
               // $("#activitySidebar .messages").html(html);
               $("#message_input,.send-message,.send-attachment").attr('disabled','disabled');
           },
           success: function (response) {
               if(response.status == true){
                   $("#message_input,.send-message,.send-attachment").removeAttr('disabled');
                   $("#message_input").val('');
                   $("#activitySidebar .messages").html(response.html);
                   $(".messages").mCustomScrollbar();
                   $(".messages").animate({ scrollTop: $(".messages")[0].scrollHeight}, 1000);
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

   $(".send-attachment").click(function(){
     document.getElementById('chat-attachment').click();
   });
   $("#chat-attachment").change(function(){
     var formData = new FormData();
     formData.append("_token",csrf_token);
     formData.append('attachment', $('#chat-attachment')[0].files[0]);
     var url  = "{{ baseUrl('send-file-to-support') }}";
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
              $("#activitySidebar .messages").html(response.html);
              $(".messages").mCustomScrollbar();
              $(".messages").animate({ scrollTop: $(".messages")[0].scrollHeight}, 1000);
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
});
function fetchChats(){

  $.ajax({
    type: "POST",
    url: "{{ baseUrl('fetch-chats') }}",
    data:{
        _token:csrf_token
    },
    dataType:'json',
    beforeSend:function(){
        $("#message_input").val('');
        $("#message_input,.send-message,.send-attachment").attr('disabled','disabled');
    },
    success: function (response) {
        if(response.status == true){
            $("#message_input,.send-message,.send-attachment").removeAttr('disabled');
            $("#activitySidebar .messages").html(response.html);
            setTimeout(function(){
                $("#activitySidebar .messages").mCustomScrollbar();
                $("#activitySidebar .messages").animate({ scrollTop: $(".messages")[0].scrollHeight}, 1000);
            },800);
            
            $(".doc_chat_input").show();
        }else{
            errorMessage(response.message);
        }
    },
    error:function(){
        $("#activitySidebar .messages").html('');
        internalError();
    }
  });
}
</script>
@endsection