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
@section('style')
<link rel="stylesheet" href="assets/vendor/quill/dist/quill.snow.css">
<style type="text/css">
.page-header-tabs {
    margin-bottom: 0px !important;
}
</style>
@endsection

@section('content')
<!-- Content -->
<div class="">
    <!-- Page Header -->
    <div class="page-header">
        <div class="row align-items-end">
            <div class="col-sm mb-2 mb-sm-0">
                <nav aria-label="breadcrumb">
                    <ol class="breadcrumb breadcrumb-no-gutter">
                        <li class="breadcrumb-item"><a class="breadcrumb-link" href="{{ baseUrl('/') }}">Dashboard</a>
                        </li>
                        <li class="breadcrumb-item active" aria-current="page">{{$pageTitle}}</li>
                    </ol>
                </nav>

                <h1 class="page-title">{{$pageTitle}}</h1>
            </div>
        </div>
        <!-- End Row -->
    </div>
    <!-- End Page Header -->

    <!-- Card -->
    <div class="card">

        <!-- Table -->
        <div class="col-sm-12">
            <div class="text-center">
                <img class="img-fluid mb-3" src="assets/svg/illustrations/create.svg" alt="Image Description"
                    style="max-width: 15rem;">

                <div class="mb-4">
                    <h2>Score</h2>
                    <p>Your eligibility score is <h3 class="text-danger">{{$record->score}}</h3></p>
                    @if(!empty($score_range))
                        @if($record->score >= $score_range->good_score)
                            <h3 class="badge badge-success f-20">Good Range Score</h3>
                        @elseif($record->score >= $score_range->may_be_score)
                            <h3 class="badge badge-warning f-20">May Be Range Score</h3>
                        @elseif($record->score >= $score_range->difficult_score)
                            <h3 class="badge badge-orange f-20">Difficult Range Score</h3>
                        @else
                            <h3 class="badge badge-danger f-20">Not Eligible for Visa</h3>
                        @endif    
                    @endif
                    <div class="mt-3">
                        <a href="{{ baseUrl('eligibility-check/download-report/'.base64_encode($record->id)) }}" class="btn btn-primary"><i class="tio-download"></i> Download Report</a>
                    </div>
                </div>
            </div>
            <?php
                if($record->match_pattern != ''){
                    $match_pattern = json_decode($record->match_pattern,true);
            ?>
                    <div class="mt-2">
                        <h3>Your are Eligible for below Services</h3>
                        <ul class="elg-list">
                            @for($i=0;$i < count($match_pattern);$i++)
                                <?php
                                    $visa_service = visaService($match_pattern[$i]);
                                    if(!empty($visa_service)){
                                ?>
                                <li><i class="tio-chevron-right"></i> {{$visa_service->name}} </li>
                                <?php } ?>
                            @endfor
                        </ul>
                    </div>
            <?php } ?>

            <?php if(count($cutoff_points) > 0){ ?>
                <div class="mt-2">
                    <h3>Cutoff Points are as below</h3>
                    @foreach($cutoff_points as $point)
                    <div class="card mb-3">
                        <div class="card-header">
                            {{$point->name}}
                        </div>
                        <div class="card-body">
                            <div class="table-responsive">
                                <table class="table table-bordered">
                                    <thead>
                                        <tr>
                                            <th>Cutoff Date</th>
                                            <th>Points</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach($point->CutoffPoints as $cutoff)
                                            <tr>
                                                <td>{{$cutoff->cutoff_date}}</td>
                                                <td>{{$cutoff->cutoff_point}}</td>
                                            </tr>
                                        @endforeach
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                    @endforeach
                </div>
            <?php } ?>

        </div>
        <!-- End Table -->

    </div>
    <!-- End Card -->
</div>
<!-- End Content -->


@endsection


@section('javascript')
<!-- JS Implementing Plugins -->

<!-- JS Implementing Plugins -->
<script src="assets/vendor/hs-navbar-vertical-aside/hs-navbar-vertical-aside.min.js"></script>
<script src="assets/vendor/hs-nav-scroller/dist/hs-nav-scroller.min.js"></script>
<script src="assets/vendor/hs-go-to/dist/hs-go-to.min.js"></script>
<script src="assets/vendor/list.js/dist/list.min.js"></script>
<script src="assets/vendor/prism/prism.js"></script>
<script src="assets/vendor/hs-step-form/dist/hs-step-form.min.js"></script>
<script src="assets/vendor/jquery-validation/dist/jquery.validate.min.js"></script>
<!-- JS Front -->

<script src="assets/vendor/quill/dist/quill.min.js"></script>


@endsection