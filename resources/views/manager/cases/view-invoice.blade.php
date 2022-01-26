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
<div class="invoice">
  <!-- Page Header -->
  <div class="page-header">
    <div class="row align-items-end">
      <div class="col-sm mb-2 mb-sm-0">
        
        
      </div>

      <div class="col-sm-auto">
        
      </div>
    </div>
    <!-- End Row -->
  </div>
  <!-- End Page Header -->
  <div class="row">
    <div class="col-lg-12 mb-5 mb-lg-0">
      <!-- Card -->
      <div class="card card-lg">
        <!-- Body -->
        <div class="card-body">

          <div class="row justify-content-md-between">
            <div class="col-md-12 text-md-right mb-3">
              <h2>Invoice #</h2>
              <span class="d-block">{{$record->Invoice->unique_id}}</span>
            </div>
            <div class="col-md-6">
              <!-- Form Group -->
              <div class="form-group js-form-message">
                <label class="input-label">Bill to:</label>
                <div class="text-left"><?php echo nl2br($record->Invoice->bill_to) ?></div>
              </div>
              <!-- End Form Group -->
              <div class="form-group mb-0 js-form-message">
                <dl class="row align-items-sm-center mb-3">
                  <dt class="col-md-3 col-md text-sm-left mb-2 mb-sm-0">Invoice date:</dt>
                  <dd class="col-md-9 col-md-auto mb-0">
                    <!-- Flatpickr -->
                    <div class="js-flatpickr flatpickr-custom input-group input-group-merge js-form-message">
                       <div class="input-group-prepend" data-toggle>
                          <div class="input-group-text">
                             <i class="tio-date-range"></i>
                          </div>
                       </div>
                       <div required type="text" name="invoice_date" class="flatpickr-custom-form-control form-control" id="invoice_date">{{$record->Invoice->invoice_date}}</div>
                    </div>
                    <!-- End Flatpickr -->
                  </dd>
                </dl>
              </div>
            </div>
            <div class="col-md-6 text-md-right">
              <!-- Form Group -->
              <div class="form-group text-left js-form-message">
                <label class="input-label text-right">Bill From:</label>
                <div class="text-right"><?php echo nl2br($record->Invoice->bill_from) ?></div>
              </div>
              <!-- End Form Group -->
              <div class="form-group mb-0 js-form-message">
                <dl class="row align-items-sm-center">
                  <dt class="col-md-3 col-md text-sm-left mb-2 mb-sm-0">Due date:</dt>
                  <dd class="col-md-9 col-md-auto mb-0">
                    <!-- Flatpickr -->
                    <div class="js-flatpickr flatpickr-custom input-group input-group-merge js-form-message text-left">
                       <div class="input-group-prepend" data-toggle>
                          <div class="input-group-text">
                             <i class="tio-date-range"></i>
                          </div>
                       </div>
                       <div class="flatpickr-custom-form-control form-control">{{$record->Invoice->due_date}}</div>
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
            <div id="addInvoiceItemContainer">
              @foreach($record->InvoiceItems as $item)
              <?php
              $index = randomNumber(4);
              ?>
              <div class="item-row">
                <div class="input-group-add-field">
                  <div class="row">
                    <div class="col-md-6 js-form-message">
                      <div class="form-control mb-3">{{$item->particular}}</div>
                    </div>
                    <div class="col-md-6 js-form-message">
                      <div class="form-control-plaintext mb-3 amount">{{currencyFormat($item->amount)}}</div>
                    </div>
                  </div>
                </div>
              </div>
              @endforeach
            </div>

          </div>

          <hr class="my-5">

          <div class="row justify-content-md-end mb-3">
            <div class="col-md-8 col-lg-7">
              <dl class="row text-sm-right">
                <dt class="col-sm-6">Subtotal:</dt>
                <dd class="col-sm-6" id="subtotal">{{currencyFormat($record->Invoice->amount)}}</dd>
                <dt class="col-sm-6">Total Amount:</dt>
                <dd class="col-sm-6" id="total">{{currencyFormat($record->Invoice->amount)}}</dd>
              </dl>
              <!-- End Row -->
            </div>
          </div>
          <!-- End Row -->

          <!-- Form Group -->
          <div class="form-group">
            <label for="invoiceNotesLabel" class="input-label">Notes &amp; terms</label>
            <div class="text-left">{{$record->notes}}</div>
          </div>
        </div>
        <!-- End Body -->
      </div>
      <!-- End Card -->

      <!-- Sticky Block End Point -->
      <div id="stickyBlockEndPoint"></div>
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

</script>
@endsection