@extends('layouts.master')
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
<!-- Page Header -->
  @include(roleFolder().'.cases.case-navbar')

  <!-- Card -->
  <div class="card mb-3 mb-lg-5">
    <!-- Header -->
    <div class="card-header">
      <h6 class="card-subtitle mb-0">{{$pageTitle}}</h6>

    </div>
    <!-- End Header -->

    <!-- Body -->
    <div class="card-body">
        <!-- Table -->
    <div class="datatable-custom">
      <table id="tableList" class="table table-lg table-borderless table-thead-bordered table-nowrap table-align-middle card-table">
        <thead class="thead-light">
          <tr>
            
            <th scope="col">Invoice ID</th>
            <th scope="col">Amount</th>
            <th scope="col">Payment Status</th>
            <th scope="col">Created Date</th>
            
            <th scope="col"></th>
          </tr>
        </thead>
        <tbody>
        </tbody>
      </table>
    </div>
    <!-- End Table -->
    </div>
    <!-- End Body -->
  </div>
  <!-- End Card -->

  <!-- End Row -->

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
<script type="text/javascript">
// initEditor("description"); 
$(document).ready(function(){

  $("#datatableSearch").keyup(function(){
    var value = $(this).val();
    if(value == ''){
      loadData();
    }
    if(value.length > 3){
      loadData();
    }
  });
  
});

loadData();
function loadData(page=1){
  var search = $("#datatableSearch").val();
    $.ajax({
        type: "POST",
        url: BASEURL + '/cases/{{$subdomain}}/invoices/case-invoices?page='+page,
        data:{
            _token:csrf_token,
            case_id:"{{$case['unique_id']}}"
        },
        dataType:'json',
        beforeSend:function(){
            var cols = $("#tableList thead tr > th").length;
            // $("#tableList tbody").html('<tr><td colspan="'+cols+'"><center><i class="fa fa-spin fa-spinner fa-3x"></i></center></td></tr>');
            // $("#paginate").html('');
            showLoader();
        },
        success: function (data) {
            hideLoader();
            $("#tableList tbody").html(data.contents);
            initPagination(data);
            
        },
        error:function(){
          internalError();
        }
    });
}

</script>

@endsection