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


@section('content')
<!-- Page Header -->
@include(roleFolder().'.cases.case-navbar')

<!-- Card -->
<div class="card mb-3 mb-lg-5">
    <!-- Header -->
    <div class="card-header">
        <div class="row">
            <div class="col-md-9">
                <h6 class="card-subtitle pt-3 mb-0">Case stages</h6>
            </div>
        </div>
    </div>

    <div class="card-body pt-0">
      <div id="tableList" class="t">

      </div>
    </div>

</div>
<!-- End Header -->

<!-- Body -->




<!-- End Body -->

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
$(document).ready(function() {
    $("#datatableSearch").keyup(function() {
        var value = $(this).val();
        if (value == '') {
            loadData();
        }
        if (value.length > 3) {
            loadData();
        }
    });

});
loadData();

function loadData(page = 1) {

    var search = $("#datatableSearch").val();
    $.ajax({
        type: "POST",
        url: BASEURL + '/cases/stages/ajax-list?page=' + page,
        data: {
            _token: csrf_token,
            subdomain:"{{$subdomain}}",
            case_id: "{{$record['unique_id']}}"
        },
        dataType: 'json',
        beforeSend: function() {
            var cols = $("#tableList").length;
            // $("#tableList tbody").html('<tr><td colspan="'+cols+'"><center><i class="fa fa-spin fa-spinner fa-3x"></i></center></td></tr>');
            // $("#paginate").html('');
            showLoader();
        },
        success: function(data) {
            hideLoader();
            if(data.status == true){
              $("#tableList").html(data.contents);
              initPagination(data);
            }else{
              errorMessage(data.message);
            }

        },
        error: function() {
            internalError();
        }
    });
}
</script>

@endsection