@extends('layouts.master')
@section('breadcrumb')
<!-- Content -->
<ol class="breadcrumb breadcrumb-no-gutter">
  <li class="breadcrumb-item"><a class="breadcrumb-link" href="{{ baseUrl('/') }}">Dashboard</a></li>
  <li class="breadcrumb-item"><a class="breadcrumb-link" href="{{ baseUrl('/cases') }}">Cases</a></li>
  <li class="breadcrumb-item active" aria-current="page">{{$pageTitle}}</li>
</ol>
<!-- End Content -->
@endsection

@section('header-right')
<a class="btn btn-primary" href="{{baseUrl('/cases/invoices/list/'.base64_encode($case->id))}}">
                    <i class="tio mr-1"></i> Back 
                  </a>
@endsection

@section('content')
<!-- Content -->
<div class="add-invoice">

  <div class="row">
    <div class="col-lg-9 mb-5 mb-lg-0">
      <!-- Card -->
      <div class="card card-lg">
        <!-- Body -->
        <div class="card-body">
          <form id="form" action="{{ baseUrl('cases/invoices/add/'.base64_encode($case->id)) }}" class="js-validate">
            @csrf
          <div class="row justify-content-md-between">
            <div class="col-md-12 text-md-right">
              <h2>Invoice #</h2>
            </div>
            <div class="col-md-6">
              <!-- Form Group -->
              <div class="form-group js-form-message">
                <label class="input-label">Bill to:</label>
<textarea class="form-control" required placeholder="Who is this invoice from?" name="bill_to" aria-label="Who is this invoice from?" rows="5">{{$client->first_name." ".$client->last_name}},
{{$client->address}},
{{$client->city_name}}, {{$client->state_name}},
{{$client->country_name}}
</textarea>
              </div>
              <!-- End Form Group -->
              <div class="form-group mb-0 js-form-message">
                <dl class="row align-items-sm-center mb-3">
                  <dt class="col-md-3 col-md text-sm-left mb-2 mb-sm-0">Invoice date:</dt>
                  <dd class="col-md-9 col-md-auto mb-0">
                    <!-- Flatpickr -->
                    <div class="input-group input-group-merge js-form-message">
                       <div class="input-group-prepend" data-toggle>
                          <div class="input-group-text">
                             <i class="tio-date-range"></i>
                          </div>
                       </div>
                       <input required type="text" name="invoice_date" class="form-control" id="invoice_date" placeholder="Select Invoice Date" data-input value="">
                    </div>
                    <!-- End Flatpickr -->
                  </dd>
                </dl>
              </div>
            </div>
            <div class="col-md-6 text-md-right">
              <!-- Form Group -->
              <div class="form-group text-left js-form-message">
                <label class="input-label">Bill From:</label>
<textarea class="form-control text-right" required placeholder="Who is this invoice from?" name="bill_from" aria-label="Who is this invoice from?" rows="5">{{$professional->company_name}}
{{$professional->address}},
@if(!empty($professional->City($professional->city_id)))
{{$professional->City($professional->city_id)->name}},{{$professional->State($professional->state_id)->name}},
@endif
@if(!empty($professional->Country($professional->country_id)))
{{$professional->Country($professional->country_id)->name}}
@endif</textarea>
              </div>
              <!-- End Form Group -->
              <div class="form-group mb-0 js-form-message">
                <dl class="row align-items-sm-center">
                  <dt class="col-md-3 col-md text-sm-left mb-2 mb-sm-0">Due date:</dt>
                  <dd class="col-md-9 col-md-auto mb-0">
                    <!-- Flatpickr -->
                    <div class="input-group input-group-merge js-form-message">
                       <div class="input-group-prepend" data-toggle>
                          <div class="input-group-text">
                             <i class="tio-date-range"></i>
                          </div>
                       </div>
                       <input required type="text" name="due_date" class="form-control" id="due_date" placeholder="Select Due Date" data-input value="">
                    </div>
                    <!-- End Flatpickr -->
                  </dd>
                </dl>
              </div>
            </div>
          </div>
          <!-- End Row -->

          <hr class="my-5">

          <div class="js-add-field"
               data-hs-add-field-options='{
                  "template": "#addInvoiceItemTemplate",
                  "container": "#addInvoiceItemContainer",
                  "defaultCreated": 0
                }'>
            <!-- Title -->
            <div class="bg-light border-bottom p-2 mb-3">
              <div class="row">
                <div class="col-sm-6">
                  <h6 class="card-title text-cap">Particular</h6>
                </div>
                <div class="col-sm-6 d-none d-sm-inline-block">
                  <h6 class="card-title text-cap">Amount</h6>
                </div>
              </div>
            </div>

            <!-- Container For Input Field -->
            <div id="addInvoiceItemContainer"></div>

            <a href="javascript:;" class="js-create-field form-link btn btn-sm btn-no-focus btn-ghost-primary">
              <i class="tio-add"></i> Add item
            </a>

            <!-- Add Phone Input Field -->
            <div id="addInvoiceItemTemplate" class="item-row" style="display: none;">
              <!-- Content -->
              <div class="input-group-add-field">
                <div class="row">
                  <div class="col-md-6 js-form-message">
                    <input type="text" class="form-control mb-3 particular_name" placeholder="Item name" aria-label="Item name">
                  </div>
                  <div class="col-md-6 js-form-message">
                    <input type="number" class="form-control-plaintext mb-3 amount" placeholder="{{currencyFormat()}}0.00" aria-label="{{currencyFormat()}}0.00">
                  </div>
                </div>
                <!-- End Row -->

                <a class="js-delete-field input-group-add-field-delete" href="javascript:;" data-toggle="tooltip" data-placement="top" title="Remove item">
                  <i class="tio-clear"></i>
                </a>
              </div>
              <!-- End Content -->
            </div>
            <!-- End Add Phone Input Field -->
        </div>

          <hr class="my-5">

          <div class="row justify-content-md-end mb-3">
            <div class="col-md-8 col-lg-7">
              <dl class="row text-sm-right">
                <dt class="col-sm-6">Subtotal:</dt>
                <dd class="col-sm-6" id="subtotal">{{currencyFormat()}}0.00</dd>
                <dt class="col-sm-6">Total Amount:</dt>
                <dd class="col-sm-6" id="total">{{currencyFormat()}}0.00</dd>
              </dl>
              <!-- End Row -->
            </div>
          </div>
          <!-- End Row -->

          <!-- Form Group -->
          <div class="form-group">
            <label for="invoiceNotesLabel" class="input-label">Notes &amp; terms</label>
            <textarea name="notes" class="form-control" placeholder="Who is this invoice to?" id="invoiceNotesLabel" aria-label="Who is this invoice to?" rows="3"></textarea>
          </div>
          <!-- End Form Group -->
          <!-- <div class="text-center">
            <button type="button" class="btn btn-primary mb-3 save-invoice">
              <i class="tio-send mr-1"></i> Save Invoice
            </button>
          </div> -->
          </form>
        </div>
        <!-- End Body -->
      </div>
      <!-- End Card -->

      <!-- Sticky Block End Point -->
      <div id="stickyBlockEndPoint"></div>
    </div>

    <div id="stickyBlockStartPoint" class="col-lg-3">
            <div class="js-sticky-block"
                 data-hs-sticky-block-options='{
                   "parentSelector": "#stickyBlockStartPoint",
                   "breakpoint": "lg",
                   "startPoint": "#stickyBlockStartPoint",
                   "endPoint": "#stickyBlockEndPoint",
                   "stickyOffsetTop": 20
                 }'>
              
              <button type="button" class="btn btn-block btn-primary mb-3 save-invoice">
                <i class="tio-send mr-1"></i> Save Invoice
              </button>

              
              <a class="btn btn-block btn-white mb-3" href="javascript:;">
                <i class="tio-download-to mr-1"></i> Download
              </a>

              <!-- End Row -->

            </div>
          </div>
  </div>
</div>
  <!-- End Content -->
@endsection

@section('javascript')
<!-- JS Implementing Plugins -->
<script src="assets/vendor/hs-navbar-vertical-aside/hs-navbar-vertical-aside.min.js"></script>
<script src="assets/vendor/hs-unfold/dist/hs-unfold.min.js"></script>
<script src="assets/vendor/hs-form-search/dist/hs-form-search.min.js"></script>
<script src="assets/vendor/hs-file-attach/dist/hs-file-attach.min.js"></script>
<script src="assets/vendor/select2/dist/js/select2.full.min.js"></script>
<script src="assets/vendor/flatpickr/dist/flatpickr.min.js"></script>
<script src="assets/vendor/hs-quantity-counter/dist/hs-quantity-counter.min.js"></script>
<script src="assets/vendor/hs-add-field/dist/hs-add-field.min.js"></script>
<script src="assets/vendor/hs-sticky-block/dist/hs-sticky-block.min.js"></script>
<script src="assets/vendor/hs-step-form/dist/hs-step-form.min.js"></script>
<script src="assets/vendor/jquery-validation/dist/jquery.validate.min.js"></script> 
<!-- JS Front -->
<script type="text/javascript">
$(document).on('ready', function () {
  $('#invoice_date').datepicker({
      format: 'dd/mm/yyyy',
      autoclose: true,
      maxDate:(new Date()).getDate(),
      todayHighlight: true,
      orientation: "bottom auto"
  })
  .on('changeDate', function (selected) {
      startDate = new Date(selected.date.valueOf());
      startDate.setDate(startDate.getDate(new Date(selected.date.valueOf())));
      $('#due_date').datepicker('setStartDate', startDate);
  });
  $('#due_date').datepicker({
      format: 'dd/mm/yyyy',
      autoclose: true,
      maxDate:(new Date()).getDate(),
      todayHighlight: true,
      orientation: "bottom auto"
  });
  
  $('.js-add-field').each(function () {
    new HSAddField($(this), {
      addedField: function() {
        var index = randomNumber();
        $("#addInvoiceItemContainer > .item-row:last").find(".particular_name").attr("name","items["+index+"][particular_name]");
        $("#addInvoiceItemContainer > .item-row:last").find(".particular_name").attr("required","true");
        $("#addInvoiceItemContainer > .item-row:last").find(".amount").attr("name","items["+index+"][amount]");
        $("#addInvoiceItemContainer > .item-row:last").find(".amount").attr("required","true");

        $('[data-toggle="tooltip"]').tooltip();
        $(".amount").blur(function(){
          calculateAmount();
        });
        $(".js-delete-field").click(function(){
          calculateAmount();
        });
      },
      deletedField: function() {
        $('.tooltip').hide();
      }
    }).init();
  });
  
  $('.js-validate').each(function() {
      $.HSCore.components.HSValidation.init($(this));
  });
  
  $(".save-invoice").click(function(){
    
      
      var formData = $("#form").serialize();
      var url  = $("#form").attr('action');
      var is_valid = true;
      
      
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
              redirect(response.redirect_back);
            }else{
              if(response.message.items != undefined){
                errorMessage("Please add atleast on item");
              }
              validation(response.message);
              // errorMessage(response.message);
            }
          },
          error:function(){
            internalError();
            return false;
          }
      });
  });
});
function calculateAmount(){
  var amount = 0;
  $("#addInvoiceItemContainer > .item-row").each(function(){
    var amt = $(this).find(".amount").val();
    if(amt != ''){
      amount += parseInt(amt);
    }
  });
  $("#subtotal").html("{{ currencyFormat() }}"+amount);
  $("#total").html("{{ currencyFormat() }}"+amount);
}

</script>
@endsection