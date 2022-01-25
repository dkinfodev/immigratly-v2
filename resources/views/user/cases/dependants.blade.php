@extends('layouts.master')

@section('breadcrumb')
<!-- Content -->
<ol class="breadcrumb breadcrumb-no-gutter">
  <li class="breadcrumb-item"><a class="breadcrumb-link" href="{{ baseUrl('/') }}">Dashboard</a></li>
  <li class="breadcrumb-item active" aria-current="page">{{$pageTitle}}</li>
</ol><!-- End Content -->
@endsection


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
<div class="row mb-3">
    <div class="col-md-6">
        <h6 class="card-subtitle mb-0">{{$pageTitle}}</h6>
    </div>
    <div class="col-md-6">
        <div class="text-right">
            <a href="javascript:;" class="btn btn-sm btn-primary">Add Dependants</a>
        </div>
    </div>
</div>
<div class="card mb-3 mb-lg-5">
    
    <!-- Body -->
    <div class="card-body">
        <!-- Table -->
        <div class="datatable-custom">
            <table class="table table-borderless table-theard-bordered table-nowrap table-align-middle">
                <thead class="thead-light">
                    <tr>
                        <th class="table-column-pr-0">
                         <div class="custom-control custom-checkbox">
                           <input id="datatableCheckAll" type="checkbox" class="custom-control-input">
                           <label class="custom-control-label" for="datatableCheckAll"></label>
                         </div>
                        </th>
                        <th>Dependants</th>
                        <th></th>
                    </tr>
                </thead>

                <tbody>
                    @foreach($dependants as $dependant)
                        <tr>
                             <td>
                                <div class="custom-control custom-checkbox">
                                <input type="checkbox" class="custom-control-input row-checkbox" value="{{ base64_encode($record['id']) }}" id="row-{{$key}}">
                                <label class="custom-control-label" for="row-{{$key}}"></label>
                                </div>
                            </td>
                            <td>
                                {{$dependant->UserDependant($dependant->dependant_id)->given_name}}
                            </td>
                            <td>
                                <a href="javascript:;" class="btn btn-danger btn-sm"><i class="tio-trash"></i></a>
                            </td>
                        </tr>
                    @endforeach
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
<!-- <script src="assets/vendor/datatables/media/js/jquery.dataTables.min.js"></script> -->
<!-- JS Front -->
<script type="text/javascript">
// initEditor("description"); 
$('.js-nav-tooltip-link').tooltip({
    boundary: 'window'
});
$(document).on('ready', function() {

    $('.js-hs-action').each(function() {
        var unfold = new HSUnfold($(this)).init();
    });
    // initialization of datatables
    // var datatable = $.HSCore.components.HSDatatables.init($('#datatable'));
});
</script>

@endsection