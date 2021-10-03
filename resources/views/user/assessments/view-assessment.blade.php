@extends('layouts.master')
@section('style')
<style type="text/css">
.payment-option li {
    width: 100%;
}
</style>
@endsection
@section('content')
<!-- Content -->
<div class="content container-fluid">
    <!-- Page Header -->
    <div class="page-header">
        <div class="row align-items-end">
            <div class="col-sm mb-2 mb-sm-0">
                <nav aria-label="breadcrumb">
                    <ol class="breadcrumb breadcrumb-no-gutter">
                        <li class="breadcrumb-item"><a class="breadcrumb-link" href="{{ baseUrl('/') }}">Dashboard</a>
                        </li>
                        <li class="breadcrumb-item"><a class="breadcrumb-link"
                                href="{{ baseUrl('/assessments') }}">Assessments</a></li>
                        <li class="breadcrumb-item active" aria-current="page">{{$pageTitle}}</li>
                    </ol>
                </nav>
                <h1 class="page-title">{{$pageTitle}}</h1>
            </div>

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
                @if(!empty($record->Forms))
                <a class="btn btn-info" href="{{baseUrl('assessments/forms/'.$record->unique_id)}}">
                    <i class="tio-files mr-1"></i> Forms
                </a>
                @endif
                @if(!empty($record->Report))
                <a class="btn btn-warning" href="{{baseUrl('assessments/report/'.$record->unique_id)}}">
                    <i class="tio-download mr-1"></i> Download Report
                </a>
                @endif
                <a class="btn btn-primary" href="{{baseUrl('assessments')}}">
                    <i class="tio mr-1"></i> Back
                </a>
            </div>
        </div>
        <!-- End Row -->
    </div>
    <!-- End Page Header -->

    <!-- Card -->
    <form id="form" action="{{ baseUrl('assessments/update/'.$record->unique_id) }}" class="js-validate" method="post">
        @csrf
        <div class="card">
            <div class="card-header">
                <h2> Assessment Details</h2>
            </div>
            <div class="card-body">
                <!-- Step Form -->
                <div class="form-group js-form-message">
                    <label class="input-label" for="assessment_title">Assessment Title</label>
                    <input type="text" class="form-control" id="assessment_title" value="{{ $record->assessment_title }}"
                        name="assessment_title" disabled placeholder="Assessment Title">
                </div>

                <div class="form-group js-form-message">
                    <label class="input-label" for="visa_service">Visa Service</label>
                    <select name="visa_service_id" disabled id="visa_service" onchange="findProfessional()"
                        data-msg="Please select visa service." class="form-control">
                        <option value="">Select Visa Service</option>
                        @foreach($visa_services as $visa_service)
                        <option {{$record->visa_service_id == $visa_service->unique_id?'selected':''}}
                            value="{{$visa_service->unique_id}}">{{$visa_service->name}}</option>
                        @endforeach
                    </select>
                </div>

                <div class="form-group js-form-message">
                    <label class="input-label">Case Type</label>
                    <select name="case_type" disabled id="validationFormCaseTypeLabel" data-msg="Please select case type."
                        class="form-control">
                        <option value="">Select Case Type</option>
                        <option {{$record->case_type == 'new'?'selected':''}} value="new">New</option>
                        <option {{$record->case_type == 'previous'?'selected':''}} value="previous">Previous</option>
                    </select>
                </div>
                <div class="form-group js-form-message">
                    <label class="input-label" for="additional_comment">Additional Comment</label>
                    <textarea id="additional_comment" disabled name="additional_comment" class="form-control"
                        placeholder="Additional Comment" rows="4">{{$record->additional_comment}}</textarea>
                </div>

            </div>
            <!-- End Card -->
        </div>

        <div class="card mt-3">
            <div class="card-header">
                <h2>Professional</h2>
            </div>
            <div class="card-body">
                <div class="form-group js-form-message">
                    <label class="input-label">Choose Professional</label>
                    <div class="js-form-message">
                        <select name="choose_professional" disabled id="choose_professional" onchange="findProfessional()"
                            id="choose_professional" class="form-control">
                            <option value="">Select Option</option>
                            <option {{$record->choose_professional == 'manual'?'selected':''}} value="manual">Manual
                            </option>
                            <option {{$record->choose_professional == 'auto_assigned'?'selected':''}}
                                value="auto_assigned">Auto Assigned</option>
                        </select>
                    </div>
                </div>
                <div id="professional-list">
                </div>
            </div>
            <!-- End Card -->
        </div>
        {{--<div class="card mt-3" id="amount_to_pay">
            <div class="card-header">
                <h2>Amount to Pay</h2>
            </div>
            <div class="card-body">
                <div class="row">
                    @if($record->Invoice->payment_status != 'paid')
                    <div class="col-3">
                        <div class="card mb-3 mb-lg-5">
                            <div class="card-body">
                                <div class="text-left">
                                    <ul class="list-checked list-checked-primary nav nav-pills payment-option mb-7 list-unstyled list-unstyled-py-4"
                                        role="tablist">
                                        <li class="nav-item">
                                            <a class="nav-link active" id="credit-debit-card-tab" data-toggle="pill"
                                                href="#credit-debit-card" role="tab" aria-controls="credit-debit-card"
                                                aria-selected="true">Credit/Debit Card</a>
                                        </li>
                                        <li class="nav-item">
                                            <a class="nav-link" id="netbanking-tab" data-toggle="pill"
                                                href="#netbanking" role="tab" aria-controls="netbanking"
                                                aria-selected="false">Netbanking</a>
                                        </li>
                                        <li class="nav-item">
                                            <a class="nav-link" id="wallet-tab" data-toggle="pill" href="#wallet"
                                                role="tab" aria-controls="wallet" aria-selected="false">Wallet</a>
                                        </li>
                                    </ul>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-9">
                        <div class="tab-content">
                            <div class="col-sm mb-2 mb-sm-0 text-right">
                                <h3><span class="font-weight-bold text-danger">Pay:
                                    </span>{{currencyFormat($pay_amount)}}</h3>
                            </div>
                            <div class="tab-pane fade show active" id="credit-debit-card" role="tabpanel"
                                aria-labelledby="credit-debit-card-tab">
                                <div class="card mb-3 mb-lg-5">
                                    <div class="card-header">
                                        <h4 class="card-header-title"> Credit or Debit Card</h4>
                                    </div>
                                    <div class="card-body">
                                        <div id="razorCardForm" name="razorCardForm">
                                            @csrf
                                            <input type="hidden" name="payment_type" value="credit_debit_card" />

                                            <div class="form-group js-form-message">
                                                <label for="cardNameLabel" class="input-label">Name on card</label>
                                                <input type="text" data-msg="Please enter card holder name"
                                                    disabled id="cardNameLabel" name="card_holder_name"
                                                    placeholder="Name on the Card" aria-label="Payoneer">
                                            </div>

                                            <div class="form-group js-form-message">
                                                <label for="email" class="input-label">Email</label>
                                                <input type="email" data-msg="Please enter email" class="form-control"
                                                    id="email" name="email" placeholder="Email" aria-label="Email"
                                                    value="{{Auth::user()->email}}">
                                            </div>

                                            <div class="form-group js-form-message">
                                                <label for="mobile_no" class="input-label">Mobile No.</label>
                                                <input type="text" data-msg="Please enter mobile number"
                                                    disabled id="mobile_no" name="mobile_no"
                                                    placeholder="Mobile No." aria-label="Mobile No."
                                                    value="{{Auth::user()->phone_no}}">
                                            </div>

                                            <div class="form-group js-form-message">
                                                <label for="cardNumberLabel" class="input-label">Card number</label>
                                                <input type="text" data-msg="Please enter card number"
                                                    class="js-masked-input form-control" name="card_number"
                                                    id="cardNumberLabel" placeholder="xxxx xxxx xxxx xxxx"
                                                    aria-label="xxxx xxxx xxxx xxxx" data-hs-mask-options='{
                                        "template": "0000 0000 0000 0000"
                                      }'>
                                            </div>

                                            <div class="row">
                                                <div class="col-sm-6">
                                                    <div class="form-group js-form-message">
                                                        <label for="expirationDateLabel" class="input-label">Expiration
                                                            date</label>
                                                        <input type="text" data-msg="Please enter expiry date"
                                                            class="js-masked-input form-control" name="expire_date"
                                                            id="expirationDateLabel" placeholder="xx/xxxx"
                                                            aria-label="xx/xxxx" data-hs-mask-options='{
                                            "template": "00/0000"
                                          }'>
                                                    </div>
                                                </div>
                                                <div class="col-sm-6">
                                                    <!-- Form Group -->
                                                    <div class="form-group js-form-message">
                                                        <label for="securityCodeLabel" class="input-label">CVV Code <i
                                                                class="far fa-question-circle text-body ml-1"
                                                                data-toggle="tooltip" data-placement="top"
                                                                title="A 3 - digit number, typically printed on the back of a card."></i></label>
                                                        <input type="text" data-msg="Please enter cvv"
                                                            class="js-masked-input form-control" name="cvv"
                                                            id="securityCodeLabel" placeholder="xxx" aria-label="xxx"
                                                            data-hs-mask-options='{
                                            "template": "000"
                                          }'>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="d-flex justify-content-end">
                                                <button type="button" id="razorCardBtn" class="btn btn-warning">Pay
                                                    Now</button>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="tab-pane fade" id="netbanking" role="tabpanel" aria-labelledby="netbanking-tab">
                                <div class="card mb-3 mb-lg-5">
                                    <div class="card-header">
                                        <h4 class="card-header-title"> Netbanking</h4>
                                    </div>
                                    <div class="card-body">
                                        <div id="razorBankForm" name="razorBankForm">
                                            @csrf
                                            <input type="hidden" name="payment_type" value="netbanking" />


                                            <div class="form-group js-form-message">
                                                <label for="email" class="input-label">Email</label>
                                                <input type="email" data-msg="Please enter email" class="form-control"
                                                    id="nb_email" name="email" placeholder="Email" aria-label="Email"
                                                    value="{{Auth::user()->email}}">
                                            </div>

                                            <div class="form-group js-form-message">
                                                <label for="mobile_no" class="input-label">Mobile No.</label>
                                                <input type="text" data-msg="Please enter mobile number"
                                                    disabled id="nb_mobile_no" name="mobile_no"
                                                    placeholder="Mobile No." aria-label="Mobile No."
                                                    value="{{Auth::user()->phone_no}}">
                                            </div>

                                            <div class="form-group js-form-message">
                                                <label for="netbanking" class="input-label">Select Bank</label>
                                                <select disabled name="netbanking" id="bankname">
                                                    <option value="">Select Bank</option>
                                                    @foreach(bankList() as $bank)
                                                    <option value="{{ $bank->code }}">{{ $bank->name }}</option>
                                                    @endforeach
                                                </select>
                                            </div>

                                            <div class="d-flex justify-content-end">
                                                <button type="button" id="razorBankBtn" class="btn btn-warning">Pay
                                                    Now</button>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <div class="tab-pane fade" id="wallet" role="tabpanel" aria-labelledby="wallet-tab">
                                <div class="card mb-3 mb-lg-5">
                                    <div class="card-header">
                                        <h4 class="card-header-title">Wallet</h4>
                                    </div>
                                    <div class="card-body">
                                        <div id="razorWalletForm" name="razorWalletForm">
                                            @csrf
                                            <input type="hidden" name="payment_type" value="wallet" />
                                            <div class="form-group js-form-message">
                                                <label for="wl_email" class="input-label">Email</label>
                                                <input type="email" data-msg="Please enter email" class="form-control"
                                                    id="wl_email" name="email" placeholder="Email" aria-label="Email"
                                                    value="{{Auth::user()->email}}">
                                            </div>

                                            <div class="form-group js-form-message">
                                                <label for="wl_mobile_no" class="input-label">Mobile No.</label>
                                                <input type="text" data-msg="Please enter mobile number"
                                                    disabled id="wl_mobile_no" name="mobile_no"
                                                    placeholder="Mobile No." aria-label="Mobile No."
                                                    value="{{Auth::user()->phone_no}}">
                                            </div>

                                            <div class="form-group js-form-message">
                                                <label for="wallet_selected" class="input-label">Select Wallet</label>
                                                <select disabled name="wallet" id="wallet_selected">
                                                    <option value="">Select Wallet</option>
                                                    @foreach(walletList() as $wallet)
                                                    <option value="{{ $wallet->code }}">{{ $wallet->name }}</option>
                                                    @endforeach
                                                </select>
                                            </div>

                                            <div class="d-flex justify-content-end">
                                                <button type="button" id="razorWalletBtn" class="btn btn-warning">Pay
                                                    Now</button>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    @else
                    <div class="col-sm mb-2 mb-sm-0 text-center">
                        <h3><span class="font-weight-bold text-danger">Paid:
                            </span>{{currencyFormat($record->Invoice->paid_amount)}}</h3>
                        <div class="text-secondary">Paid Date:{{dateFormat($record->Invoice->paid_date)}}</div>
                        <div class="text-secondary">Payment Method: {{$record->Invoice->payment_method}}</div>
                    </div>

                    @endif
                </div>
            </div>
        </div>--}}
        @if($record->Invoice->payment_status == 'paid')
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
                                    data-target="#collapse-{{$document->unique_id}}"
                                    data-folder="{{$document->unique_id}}" aria-expanded="true"
                                    aria-controls="collapse-{{$document->unique_id}}"
                                    onclick="fetchDocuments('{{$record->unique_id}}','{{$document->unique_id}}')"
                                    class="text-dark">
                                    <h5 class="card-title text-truncate mr-2">
                                        {{$document->name}}
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
        <div id="collapse-{{$document->unique_id}}" class="collapse" aria-labelledby="headingOne">
        </div>
        <!-- End Row -->
        </li>
        @endforeach
        </ul>
</div>
</div>
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
                        <input class="form-control msg_textbox" id="message_input"
                            placeholder="Type your message here..." />
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
@endif
<!-- <div class="text-center mt-3">
    <button type="submit" id="validationFormFinishBtn" class="btn add-btn btn-primary">Save</button>
</div> -->
</form>
<!-- End Content -->
<div class="modal fade" id="processingTransaction" data-backdrop="static" tabindex="-1" role="dialog"
    aria-labelledby="staticBackdropLabel" aria-hidden="true">
    <div class="modal-dialog modal-xl" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title text-center d-block" id="staticBackdropLabel">Transaction Processing</h5>
                <!-- <button type="button" class="btn btn-xs btn-icon btn-ghost-secondary" data-dismiss="modal" aria-label="Close">
            <i class="tio-clear tio-lg"></i>
          </button> -->
            </div>
            <div class="modal-body">
                <div class="text-center">
                    <div class="font-weight-bold">
                        <i class="tio-warning" style="font-size:72px"></i>
                    </div>
                    <span class="text-danger">Your transaction is under process. Please do not close your browser or
                        refresh the page while transaction is processing!</span>
                </div>
            </div>
            <div class="modal-footer">
                <!-- <button type="button" class="btn btn-white" data-dismiss="modal">Close</button>
          <button type="button" class="btn btn-primary">Understood</button> -->
            </div>
        </div>
    </div>
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
var assessment_id = "{{ $record->unique_id }}";
var user_id = "{{ $record->user_id }}";
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

var razorpay = new Razorpay({
    key: "{{ Config::get('razorpay.razor_key') }}",
    image: '',
});
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
                professional:"{{$record->professional}}"
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
            action:"add",
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

$(document).on('ready', function() {

    $("#form").submit(function(e) {
        e.preventDefault();
        var formData = $("#form").serialize();
        
        $.ajax({
            url:"{{ baseUrl('assessments/update/'.$record->unique_id) }}",
            type: "post",
            data: formData,
            beforeSend: function() {
                $("#validationFormFinishBtn").html("Processing...");
                $("#validationFormFinishBtn").attr("disabled",
                    "disabled");
            },
            success: function(response) {
                $("#validationFormFinishBtn").html("Save");
                $("#validationFormFinishBtn").removeAttr( "disabled");
                if (response.status == true) {
                    successMessage(response.message);
                    setTimeout(function() {
                        redirect(response.redirect_back);
                    }, 2000);

                } else {
                    validation(response.message);
                }
            },
            error: function() {
                $("#validationFormFinishBtn").html("Save Data");
                $("#validationFormFinishBtn").removeAttr(
                    "disabled");
                internalError();
            }
        });
    });

    $razorCardForm = $("#razorCardBtn");
    $razorCardForm.on('click', function(e) {
        $.ajax({
            url: "{{baseUrl('/validate-pay-now') }}",
            type: "post",
            data: $("#razorCardForm").find('select, textarea, input').serialize(),
            dataType: "json",
            beforeSend: function() {
                showLoader();
            },
            success: function(response) {
                hideLoader();
                if (response.status == true) {
                    var per_paisa = 100;
                    var pay_amount = "{{ $pay_amount }}";
                    var amount = pay_amount * per_paisa;
                    var email = $("#razorCardForm").find("#email").val();
                    var mobile_no = $("#razorCardForm").find("#mobile_no").val();
                    var card_number = $("#cardNumberLabel").val();

                    var expiry = $("#expirationDateLabel").val();
                    var expiry_date = expiry.split("/");
                    var expiry_month = expiry_date[0];
                    var expiry_year = expiry_date[1];
                    var cvv = $("#securityCodeLabel").val();
                    var card_name = $("#cardNameLabel").val();
                    $.ajax({
                        url: "{{baseUrl('/pay-now') }}",
                        type: "post",
                        data: {
                            _token: "{{ csrf_token() }}",
                            amount: amount,
                        },
                        beforeSend: function() {
                            $("#processingTransaction").modal("show");
                        },
                        success: function(response2) {
                            // hideLoader();
                            if (response2.status == true) {
                                var data = {
                                    currency: "INR",
                                    email: email,
                                    contact: mobile_no,
                                    order_id: response2.order_id,
                                    method: 'card',
                                    'card[number]': card_number,
                                    'card[expiry_month]': expiry_month,
                                    'card[expiry_year]': expiry_year,
                                    'card[cvv]': cvv,
                                    'card[name]': card_name,
                                    amount: amount
                                };
                                razorpay.createPayment(data);

                                razorpay.on('payment.success', function(resp) {
                                    paymentSuccess(resp);
                                    $razorCardForm[0].reset();
                                });
                                razorpay.on('payment.error', function(resp) {
                                    $("#processingTransaction").modal(
                                        "hide");
                                    // errorMessage(resp.error.description);
                                    paymentError("card", resp.error
                                        .description);
                                });

                            } else {
                                hideLoader();
                                errorMessage(response.message);
                            }
                        },
                        error: function() {
                            errorMessage("Internal error try again");
                        }
                    });
                } else {
                    if (response.error_type == 'validation') {
                        validation(response.message);
                    } else {
                        errorMessage(response.message);
                    }
                }
            }
        });
        e.preventDefault();
    });

    $razorbankForm = $("#razorBankBtn");
    $razorbankForm.on('click', function(e) {
        $.ajax({
            url: "{{baseUrl('/validate-pay-now') }}",
            type: "post",
            data: $("#razorBankForm").find('select, textarea, input').serialize(),
            dataType: "json",
            beforeSend: function() {
                showLoader();
            },
            success: function(response) {
                hideLoader();
                if (response.status == true) {
                    var per_paisa = 100;
                    var pay_amount = "{{ $pay_amount }}";
                    var amount = pay_amount * per_paisa;
                    var email = $("#razorBankForm").find("#nb_email").val();
                    var mobile_no = $("#razorBankForm").find("#nb_mobile_no").val();
                    var net_banking = $("#bankname").val();
                    $.ajax({
                        url: "{{baseUrl('/pay-now') }}",
                        type: "post",
                        data: {
                            _token: "{{ csrf_token() }}",
                            amount: amount,
                        },
                        beforeSend: function() {
                            $("#processingTransaction").modal("show");
                        },
                        success: function(response) {

                            if (response.status == true) {
                                var data = {
                                    currency: "INR",
                                    email: email,
                                    contact: mobile_no,
                                    order_id: response.order_id,
                                    method: 'netbanking',
                                    bank: net_banking,
                                    amount: amount
                                };
                                razorpay.createPayment(data);

                                razorpay.on('payment.success', function(resp) {
                                    paymentSuccess(resp);
                                    $razorbankForm[0].reset();
                                    $razorbankForm.find("select")
                                        .trigger("change");
                                });
                                razorpay.on('payment.error', function(resp) {
                                    // errorMessage(resp.error.description);
                                    paymentError("netbanking", resp
                                        .error.description);
                                });

                            } else {
                                errorMessage(response.message);
                            }
                        },
                        error: function() {
                            errorMessage("Internal error try again");
                        }
                    });
                } else {
                    if (response.error_type == 'validation') {
                        validation(response.message);
                    } else {
                        errorMessage(response.message);
                    }
                }
            }
        });
        e.preventDefault();
    });

    // Netbanking Submit  

    $razorWalletForm = $("#razorWalletBtn");
    $razorWalletForm.on('click', function(e) {
        $.ajax({
            url: "{{baseUrl('/validate-pay-now') }}",
            type: "post",
            data: $("#razorWalletForm").find("input,select,textarea").serialize(),
            dataType: "json",
            beforeSend: function() {
                showLoader();
            },
            success: function(response) {
                hideLoader();
                if (response.status == true) {
                    var per_paisa = 100;
                    var pay_amount = "{{ $pay_amount }}";
                    var amount = pay_amount * per_paisa;
                    var email = $("#razorWalletForm").find("#wl_email").val();
                    var mobile_no = $("#razorWalletForm").find("#wl_mobile_no").val();
                    var wallet_selected = $("#wallet_selected").val();
                    $.ajax({
                        url: "{{baseUrl('/pay-now') }}",
                        type: "post",
                        data: {
                            _token: "{{ csrf_token() }}",
                            amount: amount,
                        },
                        beforeSend: function() {
                            $("#processingTransaction").modal("show");
                        },
                        success: function(response) {

                            if (response.status == true) {
                                var data = {
                                    currency: "INR",
                                    email: email,
                                    contact: mobile_no,
                                    order_id: response.order_id,
                                    method: 'wallet',
                                    wallet: wallet_selected,
                                    amount: amount
                                };
                                razorpay.createPayment(data);

                                razorpay.on('payment.success', function(resp) {
                                    paymentSuccess(resp);
                                    $razorWalletForm[0].reset();
                                    $razorWalletForm.find("select")
                                        .trigger("change");
                                });
                                razorpay.on('payment.error', function(resp) {
                                    // errorMessage(resp.error.description);
                                    paymentError('wallet', resp.error
                                        .description);
                                });
                            } else {
                                errorMessage(response.message);
                            }
                        },
                        error: function() {
                            errorMessage("Internal error try again");
                        }
                    });
                } else {
                    if (response.error_type == 'validation') {
                        validation(response.message);
                    } else {
                        errorMessage(response.message);
                    }
                }
            }
        });
        e.preventDefault();
    });

});

function saveData(step = '') {
    var formData = new FormData($("#form")[0]);
    if (step != '') {
        formData.append("step", step);
    }
    $.ajax({
        url: "{{ baseUrl('assessments/update/'.$record->unique_id) }}",
        type: "post",
        data: formData,
        cache: false,
        contentType: false,
        processData: false,
        beforeSend: function() {
            showLoader();
            $("#validationFormFinishBtn").html("Processing...");
            $("#validationFormFinishBtn").attr("disabled", "disabled");
        },
        success: function(response) {
            hideLoader();
            $("#validationFormFinishBtn").html("Save Changes");
            $("#validationFormFinishBtn").removeAttr("disabled");
            if (response.status == true) {
                if (step != 1) {
                    successMessage(response.message);
                }

                setTimeout(function() {
                    window.location.href = response.redirect_back;
                }, 2000);


            } else {
                validation(response.message);
            }
        },
        error: function() {
            $("#validationFormFinishBtn").html("Save Changes");
            $("#validationFormFinishBtn").removeAttr("disabled");
            internalError();
        }
    });
}

function paymentSuccess(resp) {
    $.ajax({
        url: "{{baseUrl('assessments/payment-success') }}",
        type: "post",
        data: {
            _token: "{{ csrf_token() }}",
            razorpay_payment_id: resp.razorpay_payment_id,
            razorpay_order_id: resp.razorpay_order_id,
            razorpay_signature: resp.razorpay_signature,
            amount: "{{ $pay_amount }}",
            invoice_id: "{{$invoice_id}}"
        },
        beforeSend: function() {

        },
        success: function(response) {
            $("#processingTransaction").modal("hide");
            if (response.status == true) {
                successMessage("Your payment has been paid successfully");
                redirect('{{ baseUrl("assessments/edit/".$record->unique_id."?step=3") }}')
            } else {
                errorMessage(response.message);
            }
        },
        error: function() {
            $("#processingTransaction").modal("hide");
            errorMessage("Internal error try again");
        }
    });
}

function paymentError(payment_method, description) {
    $.ajax({
        url: "{{baseUrl('assessments/payment-failed') }}",
        type: "post",
        data: {
            _token: "{{ csrf_token() }}",
            payment_method: payment_method,
            description: description,
            amount_paid: "{{ $pay_amount }}",
        },
        beforeSend: function() {

        },
        success: function(response) {
            $("#processingTransaction").modal("hide");
            errorMessage(description);
        },
        error: function() {
            $("#processingTransaction").modal("hide");
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