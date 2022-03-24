@extends('frontend.layouts.master')
  <!-- Hero Section -->
@section('style')


@endsection


@section('breadcrumb')
<!-- Content -->
<ol class="breadcrumb breadcrumb-no-gutter">
  <li class="breadcrumb-item"><a class="breadcrumb-link" href="{{ url('/') }}">Home</a></li>
  <li class="breadcrumb-item"><a class="breadcrumb-link" href="{{ url('/professionals') }}">Professional</a></li>

  <li class="breadcrumb-item active" aria-current="page">{{$subdomain}}</li>
</ol>
<!-- End Content -->
@endsection

@section('content')
<!-- Search Section -->
<style>
  td.fc-event-container a {
    text-align: center;
    height: 85px;
    padding-top: 55px;
}
</style>

<div class="container space-bottom-2 ">
  <div class="w-lg-100 ">
      <div class="row">
  
        <div class="col-lg-12">
          <!-- Card -->
          <div class="card mb-3 mb-lg-5">
            <!-- Header -->
            <div class="card-header">
              <h5 class="card-header-title float-left">Pay Now</h5>
              <div class="float-right">
                    <h3><span class="font-weight-bold text-danger">Pay:
                        </span>{{currencyFormat($pay_amount)}}</h3>
                </div>
                <div class="clearfix"></div>
            </div>
            <!-- End Header -->

            <!-- Body -->
            <div class="card-body pt-0">
                <div class="row">
                    <div class="col-3">
                        <div class="card mb-3 mb-lg-5">
                            <div class="card-body p-0">
                                <div class="text-left">
                                    <ul class="list-checked list-checked-primary nav nav-pills payment-option mb-7 list-unstyled list-unstyled-py-4"
                                        role="tablist">
                                        <li class="nav-item w-100">
                                            <a class="nav-link active" id="credit-debit-card-tab" data-toggle="pill"
                                                href="#credit-debit-card" role="tab" aria-controls="credit-debit-card"
                                                aria-selected="true">Credit/Debit Card</a>
                                        </li>
                                        <li class="nav-item w-100">
                                            <a class="nav-link" id="netbanking-tab" data-toggle="pill"
                                                href="#netbanking" role="tab" aria-controls="netbanking"
                                                aria-selected="false">Netbanking</a>
                                        </li>
                                        <li class="nav-item w-100">
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
                            
                            <div class="tab-pane fade show active" id="credit-debit-card" role="tabpanel"
                                aria-labelledby="credit-debit-card-tab">
                                <div class="card mb-3 mb-lg-5">
                                    <div class="card-header pt-0 pb-0">
                                        <h4 class="card-header-title"> Credit or Debit Card</h4>
                                    </div>
                                    <div class="card-body">
                                        <div id="razorCardForm" name="razorCardForm">
                                            @csrf
                                            <input type="hidden" name="payment_type" value="credit_debit_card" />

                                            <div class="form-group js-form-message">
                                                <label for="cardNameLabel" class="input-label">Name on card</label>
                                                <input type="text" data-msg="Please enter card holder name"
                                                    class="form-control" id="cardNameLabel" name="card_holder_name"
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
                                                    class="form-control" id="mobile_no" name="mobile_no"
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
                                    <div class="card-header pt-0 pb-0">
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
                                                    class="form-control" id="nb_mobile_no" name="mobile_no"
                                                    placeholder="Mobile No." aria-label="Mobile No."
                                                    value="{{Auth::user()->phone_no}}">
                                            </div>

                                            <div class="form-group js-form-message">
                                                <label for="netbanking" class="input-label">Select Bank</label>
                                                <select class="form-control" name="netbanking" id="bankname">
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
                                    <div class="card-header pt-0 pb-0">
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
                                                    class="form-control" id="wl_mobile_no" name="mobile_no"
                                                    placeholder="Mobile No." aria-label="Mobile No."
                                                    value="{{Auth::user()->phone_no}}">
                                            </div>

                                            <div class="form-group js-form-message">
                                                <label for="wallet_selected" class="input-label">Select Wallet</label>
                                                <select class="form-control" name="wallet" id="wallet_selected">
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
                </div>
            </div>
            <!-- End Body -->
          </div>
          <!-- End Card -->

        </div>
      </div>
    <!-- End Content Section -->
  </div>
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
@endsection

@section("javascript")
<script src="assets/vendor/moment/moment-with-locales.min.js"></script>
<link rel="stylesheet" href="assets/vendor/fullcalendar-v3/dist/fullcalendar.min.css">
<script src="assets/vendor/fullcalendar-v3/dist/fullcalendar.min.js"></script>

<script type="text/javascript" src="https://checkout.razorpay.com/v1/razorpay.js"></script>
<script>
var razorpay = new Razorpay({
    key: "{{ Config::get('razorpay.razor_key') }}",
    image: '',
});
$(document).ready(function() {
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
                    var pay_amount = "{{$pay_amount}}";
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
                    var pay_amount = "{{$pay_amount}}";
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
                    var pay_amount = "{{$pay_amount}}";
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
function paymentSuccess(resp) {
    $.ajax({
        url: "{{baseUrl('booked-appointments/payment-success') }}",
        type: "post",
        data: {
            _token: "{{ csrf_token() }}",
            razorpay_payment_id: resp.razorpay_payment_id,
            razorpay_order_id: resp.razorpay_order_id,
            razorpay_signature: resp.razorpay_signature,
            amount: "{{ $pay_amount }}",
            invoice_id: "{{$invoice_id}}",
            appointment_id:"{{$appointment->unique_id}}",
            professional:"{{$appointment->professional}}"
            
        },
        beforeSend: function() {

        },
        success: function(response) {
            $("#processingTransaction").modal("hide");
            if (response.status == true) {
                successMessage("Your payment has been paid successfully");
                redirect(response.redirect_back);
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
        url: "{{baseUrl('booked-appointments/payment-failed') }}",
        type: "post",
        data: {
            _token: "{{ csrf_token() }}",
            payment_method: payment_method,
            description: description,
            amount_paid: "{{ $pay_amount }}",
            appointment_id:"{{$appointment->unique_id}}"
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
</script>

@endsection