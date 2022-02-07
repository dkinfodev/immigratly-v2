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
    <!-- Card -->
    <div class="card p-6">

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
    @if($record->eligible_type == 'normal')
        <div class="card">
            <div class="card-header">
                <h2>Report</h2>
            </div>
            <div class="card-body">
                <table class="table table-bordered">
                    <tr>
                        <th>Question</th>
                        <th>Score</th>
                    </tr>    
                    @foreach($final_questions as $question)
                    <tr>
                        <th>{{$question['question']}}</th>
                        <td>
                            @if($question['non_eligible'] == 1)
                            <span class="text-danger">
                            {{$question['option_value']}} ({{$question['score']}})<br>
                            {{$question['non_eligible_reason']}}
                            </span>
                            @else
                            {{$question['option_value']}} ({{$question['score']}})
                            @endif
                            
                        </td>
                    </tr>
                    @endforeach
                </table>
            </div>
        </div>
    @else
        @foreach($final_questions as $groups)
        <div class="card mt-3">
            <div class="card-header p-4">
                <h4>
                    {{ $groups['group_title'] }} <small>MAX SCORE: ({{$groups['max_score']}}) MIN SCORE: ({{$groups['min_score']}})</small>
                </h4>
            </div>
            <?php 
                $components = $groups['components'];
            ?>
            <div class="card-body">
                <?php
                    $group_score = 0;
                ?>
                @foreach($components as $component)
                <?php
                    $comp_score = 0;
                ?>
                @if(isset($component['questions']) && !empty($component['questions']))
                <div class="component-block mb-3">
                    <div>
                        <span class="float-left">
                           <b> {{$component['component_title']}} </b>
                            <div><small>MAX SCORE: ({{$component['max_score']}}) MIN SCORE: ({{$component['min_score']}})</small></div>
                        </span>
                        <span class="float-right text-danger  pr-5">
                            @if(isset($final_score[$component['unique_id']])) 
                               <b>Component Wise Score: {{$final_score[$component['unique_id']]}}</b>
                            @endif
                        </span>
                        <div class="clearfix"></div>
                    </div>
                    <table class="table table-bordered">
                        <tr>
                            <th>Question</th>
                            <th>Score</th>
                        </tr>    
                        @foreach($component['questions'] as $question)
                        <tr>
                            <th>{{$question['question']}}</th>
                            <td>
                                @if($question['non_eligible'] == 1)
                                <span class="text-danger">
                                {{$question['option_value']}} ({{$question['score']}})<br>
                                {{$question['non_eligible_reason']}}
                                </span>
                                @else
                                {{$question['option_value']}} ({{$question['score']}})
                                @endif
                                
                                <?php $comp_score += $question['score']; ?>
                            </td>
                        </tr>
                        @endforeach
                    </table>
                </div>
                @endif
                @if($comp_score < $component['min_score'])
                <div class="col-md-12">
                    <div class="alert alert-danger">
                        Component score is less then minimum component score
                    </div>
                </div>
                @endif
                <?php $group_score += $comp_score ?>
                @endforeach
            </div>
            @if($group_score < $groups['min_score'])
            <div class="col-md-12">
                <div class="alert alert-danger">
                    Group score is less then minimum group score
                </div>
            </div>
            @endif
        </div>
        @endforeach
        
    @endif
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