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
    
    <!-- Card -->
    <div class="card">

        <div class="card-body">
            <!-- Step Form -->
            <form id="form" class="js-step-form js-validate" data-hs-step-form-options='{
              "progressSelector": "#validationFormProgress",
              "stepsSelector": "#validationFormContent",
              "endSelector": "#validationFormFinishBtn"
            }'>
                @csrf
                <!-- Step -->
                <ul id="validationFormProgress"
                    class="js-step-progress step step-sm step-icon-sm step-inline step-item-between mb-7">
                    <li class="step-item">
                        <a class="step-content-wrapper" href="javascript:;" data-hs-step-form-next-options='{
                                  "targetSelector": "#validationFormCaseInfo"
                                }'>
                            <span class="step-icon step-icon-soft-dark">1</span>
                            <div class="step-content">
                                <span class="step-title">Case Information</span>
                            </div>
                        </a>
                    </li>
                    <li class="step-item">
                        <a class="step-content-wrapper" href="javascript:;" data-hs-step-form-next-options='{
                                "targetSelector": "#validationFormAdditional"
                              }'>
                            <span class="step-icon step-icon-soft-dark">2</span>
                            <div class="step-content">
                                <span class="step-title">Additional Comments</span>
                            </div>
                        </a>
                    </li>

                    <li class="step-item">
                        <a class="step-content-wrapper" href="javascript:;" data-hs-step-form-next-options='{
    "targetSelector": "#validationFormVisaDocument"
  }'>
                            <span class="step-icon step-icon-soft-dark">3</span>
                            <div class="step-content">
                                <span class="step-title">Visa Documents</span>
                            </div>
                        </a>
                    </li>

                    <li class="step-item">
                        <a class="step-content-wrapper" href="javascript:;" data-hs-step-form-next-options='{
    "targetSelector": "#validationFormPayment"
  }'>
                            <span class="step-icon step-icon-soft-dark">4</span>
                            <div class="step-content">
                                <span class="step-title">Payment</span>
                            </div>
                        </a>
                    </li>
                </ul>
                <!-- End Step -->

                <!-- Content Step Form -->
                <div id="validationFormContent">
                    <div id="validationFormCaseInfo" class="{{($active_step == 1?'active':'')}}"
                        style="display:{{($active_step != 1?'none':'')}};">
                        <!-- Form Group -->
                        <div class="row form-group">
                            <label for="validationFormCaseNameLabel" class="col-sm-3 col-form-label input-label">Case
                                Name</label>

                            <div class="col-sm-9">
                                <div class="js-form-message">
                                    <input type="text" class="form-control" name="case_name"
                                        id="validationFormCaseNameLabel" placeholder="Case Name" aria-label="Case Name"
                                        required data-msg="Please enter case name." disabled
                                        value="{{$record->case_name}}">
                                </div>
                            </div>
                        </div>
                        <!-- End Form Group -->

                        <!-- Form Group -->
                        <div class="row form-group">
                            <label for="validationFormVisaServiceLabel" class="col-sm-3 col-form-label input-label">Visa
                                Service</label>

                            <div class="col-sm-9">
                                <div class="js-form-message">
                                    <select name="visa_service_id" disabled id="validationFormVisaServiceLabel" required
                                        data-msg="Please select visa service." class="form-control">
                                        <option value="">Select Visa Service</option>
                                        @foreach($visa_services as $visa_service)
                                        <option {{$record->visa_service_id == $visa_service->unique_id?'selected':''}}
                                            value="{{$visa_service->unique_id}}">{{$visa_service->name}}</option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>
                        </div>
                        <!-- End Form Group -->

                        <!-- Form Group -->
                        <div class="row form-group">
                            <label for="validationFormCaseTypeLabel" class="col-sm-3 col-form-label input-label">Case
                                Type</label>

                            <div class="col-sm-9">
                                <div class="js-form-message">
                                    <select name="case_type" disabled id="validationFormCaseTypeLabel" required
                                        data-msg="Please select case type." class="form-control">
                                        <option value="">Select Case Type</option>
                                        <option {{$record->case_type == 'new'?'selected':''}} value="new">New</option>
                                        <option {{$record->case_type == 'previous'?'selected':''}} value="previous">
                                            Previous</option>
                                    </select>
                                </div>
                            </div>
                        </div>
                        <!-- End Form Group -->

                        <!-- Footer -->
                        <div class="d-flex align-items-center">
                            <div class="ml-auto">
                                <!-- <button id="validationFormFinishBtn" type="button" class="btn btn-primary">Next</button> -->
                                <div class="ml-auto">
                                    <button type="button" class="btn btn-primary" data-hs-step-form-next-options='{
                            "targetSelector": "#validationFormAdditional"
                          }'>
                                        Next <i class="tio-chevron-right"></i>
                                    </button>
                                </div>
                                <!-- <button type="button" onclick="saveData('1')" class="btn btn-primary">
                  Next <i class="tio-chevron-right"></i>
                </button> -->
                            </div>
                        </div>
                        <!-- End Footer -->
                    </div>

                    <div id="validationFormAdditional" class="{{($active_step == 2?'active':'')}}"
                        style="display:{{($active_step != 4?'none':'')}};">
                        <!-- Form Group -->
                        <div class="row form-group">
                            <label for="additional_comment" class="col-sm-3 col-form-label input-label">Additional
                                Comment</label>

                            <div class="col-sm-9">
                                <div class="js-form-message">
                                    <textarea disabled class="form-control" rowspan="5" name="additional_comment"
                                        id="additional_comment" placeholder="Additional Comment"
                                        aria-label="Additional Comment">{{$record->additional_comment}}</textarea>
                                </div>
                            </div>
                        </div>
                        <!-- End Form Group -->

                        <!-- Footer -->
                        <div class="d-flex align-items-center">
                            <button type="button" class="btn btn-ghost-secondary mr-2" data-hs-step-form-prev-options='{
                                "targetSelector": "#validationFormCaseInfo"
                              }'>
                                <i class="tio-chevron-left"></i> Previous step
                            </button>
                           
                            <div class="ml-auto">
                            <button type="button" class="btn btn-primary" data-hs-step-form-next-options='{
                            "targetSelector": "#validationFormVisaDocument"
                          }'>
                                Next <i class="tio-chevron-right"></i>
                            </button>
                                <!-- <button id="validationFormFinishBtn" type="button" class="btn btn-primary">Save Changes</button> -->
                            </div>
                        </div>
                        <!-- End Footer -->
                    </div>

                    <div id="validationFormVisaDocument" class="{{($active_step == 3?'active':'')}}"
                        style="display:{{($active_step != 3?'none':'')}};">
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
                                            <ul class="list-inline list-separator small">
                                                {{--<li class="list-inline-item">{{count($document->Files)}} Files
                            </li>--}}
                        </ul>
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

                <!-- Footer -->
                <div class="d-flex align-items-center">
                    <button type="button" class="btn btn-ghost-secondary mr-2" data-hs-step-form-prev-options='{
                     "targetSelector": "#validationFormAdditional"
                   }'>
                        <i class="tio-chevron-left"></i> Previous step
                    </button>
                    <div class="ml-auto">
                    <button type="button" class="btn btn-primary" data-hs-step-form-next-options='{
                    "targetSelector": "#validationFormPayment"
                  }'>
                        Next <i class="tio-chevron-right"></i>
                    </button>
                    </div>

                </div>
                <!-- End Footer -->
        </div>
        <div id="validationFormPayment" class="{{($active_step == 4?'active':'')}}"
            style="display:{{($active_step != 2?'none':'')}};" class="active">
            <div class="row">
                @if($record->Invoice->payment_status != 'paid')
                <div class="col-12">
                    <div class="text-danger">Payment Pending</div>
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
            <!-- Footer -->
            <div class="d-flex align-items-center">
                <button type="button" class="btn btn-ghost-secondary mr-2" data-hs-step-form-prev-options='{
                     "targetSelector": "#validationFormCaseInfo"
                   }'>
                    <i class="tio-chevron-left"></i> Previous step
                </button>
                <!-- <div class="ml-auto">
                                <button type="button" class="btn btn-primary" data-hs-step-form-next-options='{
                            "targetSelector": "#validationFormVisaDocument"
                          }'>
                                    Next <i class="tio-chevron-right"></i>
                                </button>
                            </div> -->
            </div>
            <!-- End Footer -->
        </div>

    </div>
    <!-- End Content Step Form -->

    </form>
    <!-- End Step Form -->
</div><!-- End Card body-->
</div>
<!-- End Card -->
</div>
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
<!-- End Content -->
@endsection

@section('javascript')

<!-- JS Implementing Plugins -->
<script src="assets/vendor/hs-navbar-vertical-aside/hs-navbar-vertical-aside.min.js"></script>
<script src="assets/vendor/hs-nav-scroller/dist/hs-nav-scroller.min.js"></script>
<script src="assets/vendor/hs-go-to/dist/hs-go-to.min.js"></script>
<script src="assets/vendor/list.js/dist/list.min.js"></script>
<script src="assets/vendor/prism/prism.js"></script>
<script src="assets/vendor/hs-step-form/dist/hs-step-form.min.js"></script>
<script src="assets/vendor/jquery-validation/dist/jquery.validate.min.js"></script>
<!-- JS Front -->
<script src="assets/vendor/jquery-mask-plugin/dist/jquery.mask.min.js"></script>
<script type="text/javascript" src="https://checkout.razorpay.com/v1/razorpay.js"></script>
<!-- JS Front -->
<script src="assets/vendor/quill/dist/quill.min.js"></script>
<script src="assets/vendor/dropzone/dist/min/dropzone.min.js"></script>
<script type="text/javascript">
var razorpay = new Razorpay({
    key: "{{ Config::get('razorpay.razor_key') }}",
    image: '',
});
$(document).on('ready', function() {
    // initialization of form validation
    $('.js-validate').each(function() {
        $.HSCore.components.HSValidation.init($(this));
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
    // initialization of step form
    $('.js-step-form').each(function() {
        var stepForm = new HSStepForm($(this), {
            finish: function() {
                saveData();
            }
        }).init();
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

function fetchDocuments(assessment_id, folder_id) {
    var url = '<?php echo baseUrl("assessments/documents") ?>/' + assessment_id + '/' + folder_id;
    //   var id = $(e).attr("data-folder");
    $.ajax({
        url: url,
        type: "post",
        data: {
            _token: "{{ csrf_token() }}",
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
</script>

@endsection