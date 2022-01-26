@extends('layouts.master')

@section('breadcrumb')
<!-- Content -->
<ol class="breadcrumb breadcrumb-no-gutter">
  <li class="breadcrumb-item"><a class="breadcrumb-link" href="{{ baseUrl('/') }}">Dashboard</a></li>
  <li class="breadcrumb-item"><a class="breadcrumb-link" href="{{ baseUrl('/assessments') }}">Assessments</a></li>
  <li class="breadcrumb-item active" aria-current="page">{{$pageTitle}}</li>
</ol>
<!-- End Content -->
@endsection

@section('header-right')
 <a class="btn btn-primary" href="{{baseUrl('assessments')}}">
    <i class="tio mr-1"></i> Back
 </a>
@endsection

@section('style')
<style type="text/css">
.payment-option li {
    width: 100%;
}
</style>
@endsection
@section('content')
<!-- Content -->
<div class="assessments">
    <!-- Page Header -->
    <div class="page-header">
        <div class="row align-items-end">
           

            <div class="col-sm-auto">
                <a onclick="fetchNotes()" class="js-hs-unfold-invoker btn btn-info" href="javascript:;"
                    data-hs-unfold-options='{
                    "target": "#activitySidebar",
                    "type": "css-animation",
                    "animationIn": "fadeInRight",
                    "animationOut": "fadeOutRight",
                    "hasOverlay": true,
                    "smartPositionOff": true
                    }'>
                    <i class="tio-chat-outlined"></i> <span id="note_count">({{$unread_notes}})</span>
                </a>
                <a class="btn btn-warning" href="{{baseUrl('assessments/report/'.$record['unique_id'])}}">
                    <i class="tio mr-1"></i> Add Report
                </a>
                <a class="btn btn-info" href="{{baseUrl('assessments/forms/'.$record['unique_id'])}}">
                    <i class="tio-files mr-1"></i> Forms
                </a>
                <a class="btn btn-primary" href="{{baseUrl('assessments')}}">
                    <i class="tio mr-1"></i> Back
                </a>
            </div>
        </div>
        <!-- End Row -->
    </div>  
    <div class="card">
        <div class="card-header">
            <h2> Assessment Details</h2>
        </div>
        <div class="card-body">
            <!-- Step Form -->
            <table class="table table-bordered no-bordered">
                <tr>
                    <th>Assessment Title</th>
                    <td>{{ $record['assessment_title'] }}</td>
                </tr>
                @if(!empty($record['visa_service']))
                <tr>
                    <th>Visa Service</th>
                    <td>{{ $record['visa_service']['name'] }}</td>
                </tr>
                @endif
                <tr>
                    <th>Case Type</th>
                    <td>{{ $record['case_type'] }}</td>
                </tr>
                <tr>
                    <th>Additional Comment</th>
                    <td>{{ $record['additional_comment'] }}</td>
                </tr>
            </table>

        </div>
        <!-- End Card -->
    </div>
    <div class="card mt-3" id="amount_to_pay">
        <div class="card-header">
            <h2>Amount Paid</h2>
        </div>
        <div class="card-body">
            <div class="row">
                <div class="col-sm mb-2 mb-sm-0 text-center">
                    <h3><span class="font-weight-bold text-danger">Paid:
                        </span>{{currencyFormat($record['invoice']['paid_amount'])}}</h3>
                    <div class="text-secondary">Paid Date:{{dateFormat($record['invoice']['paid_date'])}}</div>
                    <div class="text-secondary">Payment Method: {{$record['invoice']['payment_method']}}</div>
                </div>
            </div>
        </div>
    </div>
    <div class="card mt-3" id="documents">
        <div class="card-header">
            <h2>Documents</h2>
        </div>
        <div class="card-body">
            <ul class="list-group mb-3 mt-3">
                @foreach($document_folders as $key => $document)
                <li class="list-group-item">
                    <div class="row align-items-center gx-2">
                        <div class="col-auto">
                            <i class="tio-folder tio-xl text-body mr-2"></i>
                        </div>
                        <div class="col">
                            <a href="javascript:;" data-toggle="collapse"
                                data-target="#collapse-{{$document['unique_id']}}"
                                data-folder="{{$document['unique_id']}}" aria-expanded="true"
                                aria-controls="collapse-{{$document['unique_id']}}"
                                onclick="fetchDocuments('<?php echo $record['unique_id'] ?>','<?php echo $document['unique_id'] ?>')"
                                class="text-dark">
                                <h5 class="card-title text-truncate mr-2">
                                    {{$document['name']}}
                                </h5>
                            </a>
                        </div>
                        <span class="card-btn-toggle">
                            <span class="card-btn-toggle-default">
                                <i class="tio-add"></i>
                            </span>
                            <span class="card-btn-toggle-active">
                                <i class="tio-remove"></i>
                            </span>
                        </span>
                    </div>
                    <div id="collapse-{{$document['unique_id']}}" class="collapse" aria-labelledby="headingOne">
                    </div>
                    <!-- End Row -->
                </li>
                @endforeach
            </ul>
        </div>
    </div>
    <!-- Sidebar -->
    <div id="activitySidebar" class="hs-unfold-content sidebar sidebar-bordered sidebar-box-shadow">
         <div class="card card-lg sidebar-card sidebar-scrollbar">
            <div class="card-header">
               <h4 class="card-header-title">Notes</h4>
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
</div>

@endsection

@section('javascript')

<!-- JS Implementing Plugins -->
<link rel="stylesheet" href="assets/vendor/mCustomScrollbar/jquery.mCustomScrollbar.css" />
<script src="assets/vendor/mCustomScrollbar/jquery.mCustomScrollbar.min.js"></script>
<script src="assets/vendor/hs-navbar-vertical-aside/hs-navbar-vertical-aside.min.js"></script>
<script src="assets/vendor/hs-nav-scroller/dist/hs-nav-scroller.min.js"></script>
<script src="assets/vendor/hs-go-to/dist/hs-go-to.min.js"></script>
<script src="assets/vendor/list.js/dist/list.min.js"></script>
<script src="assets/vendor/prism/prism.js"></script>
<script src="assets/vendor/hs-step-form/dist/hs-step-form.min.js"></script>
<script src="assets/vendor/jquery-validation/dist/jquery.validate.min.js"></script>
<!-- JS Front -->

<script src="assets/vendor/quill/dist/quill.min.js"></script>
<script type="text/javascript" src="https://checkout.razorpay.com/v1/razorpay.js"></script>
<script src="assets/vendor/dropzone/dist/min/dropzone.min.js"></script>
<script type="text/javascript">
var assessment_id = "{{ $record['unique_id'] }}";
var user_id = "{{ $record['user_id'] }}";
$(document).ready(function(){
    $(".send-message").click(function(){
        var message = $("#message_input").val();
        if(message != ''){
        $.ajax({
            type: "POST",
            url: "{{ baseUrl('assessments/save-notes') }}",
            data:{
                _token:csrf_token,
                assessment_id:assessment_id,
                user_id:user_id,
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
                    fetchNotes();
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
      formData.append("assessment_id",assessment_id);
      formData.append("user_id",user_id);
      formData.append('attachment', $('#chat-attachment')[0].files[0]);
      var url  = "{{ baseUrl('assessments/save-notes-file') }}";
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
               fetchNotes();
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
})

findProfessional();
function findProfessional() {
    var value = $("#choose_professional").val();
    var visa_service = $("#visa_service").val();
    if (value == 'manual' && visa_service != '') {
        if ($("#visa_service").val() == '') {
            errorMessage("Please select visa service");
            return false;
        }
        $.ajax({
            url: "{{ baseUrl('assessments/find-professional') }}",
            type: "post",
            data: {
                _token: "{{ csrf_token() }}",
                visa_service_id: visa_service,
                professional:"{{$record['professional']}}"
            },
            beforeSend: function() {
                $("#professional-list").html("<center><i class='fa fa-spin fa-spinner'></i></center>");
            },
            success: function(response) {
                if (response.status == true) {
                    $("#professional-list").html(response.contents);
                } else {
                    validation(response.message);
                }
            },
            error: function() {
                internalError();
            }
        });
    } else {
        $("#professional-list").html('');
    }
}

function fetchDocuments(assessment_id, folder_id) {
    var url = '<?php echo baseUrl("assessments/documents") ?>/' + assessment_id + '/' + folder_id;
    //   var id = $(e).attr("data-folder");
    $.ajax({
        url: url,
        type: "post",
        data: {
            _token: "{{ csrf_token() }}",
            action:"view",
            user_id:"{{$user_id}}"
        },
        beforeSend: function() {
            $("#collapse-" + folder_id).html('');
        },
        success: function(response) {
            $("#collapse-" + folder_id).html(response.contents);
        },
        error: function() {
            errorMessage("Internal error try again");
        }
    });
}
function fetchNotes(){
    
    $.ajax({
    type: "POST",
    url: "{{ baseUrl('assessments/fetch-notes') }}",
    data:{
        _token:csrf_token,
        assessment_id:assessment_id,
        user_id:user_id,
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
            $("#note_count").html("("+response.unread_notes+")");
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