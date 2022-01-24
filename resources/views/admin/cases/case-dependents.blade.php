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
      <h6 class="card-subtitle mb-0">Case Clients</h6>

    </div>
    <!-- End Header -->

    <!-- Body -->
    <div class="card-body">
    <?php
        $client = $record->Client($record->client_id);
    ?>
        <div class="row">
            <div class="col-sm-6 col-md-4">
                <a class="media align-items-center" href="javascript:;">
                <div class="avatar avatar-circle mr-3">
                    <img class="avatar-img" src="{{ userProfile($record->client_id) }}" alt="Image Description">
                </div>
                <div class="media-body">
                    @if($record->applicant_type == 1)
                    <span class="d-block h5 text-primary mb-0">
                    @else
                    <span class="d-block h5 text-hover-primary mb-0">
                    @endif
                    {{$client->first_name." ".$client->last_name}} 
                    @if($record->applicant_type == 1)
                    <i class="tio-verified text-primary" data-toggle="tooltip" data-placement="top" title="Top endorsed"></i>
                    @endif
                    </span>
                    <span class="d-block font-size-sm text-body">{{$client->email}}</span>
                </div>
                </a>
            </div>
            <div class="col-sm-6 col-md-8">
                <div class="row">
                <div class="col-sm-12 col-md-6">
                    <div class="form-group">
                    <!-- Select2 -->
                        @if(($record->applicant_type == 1))
                        <div>Primary Applicant</div>
                        @elseif(($record->applicant_type == 2))
                        <div>Accompanying Dependent</div>
                        @elseif(($record->applicant_type == 3))
                        <div>Non-Accompanying</div>
                        @endif
                        
                    
                    <!-- End Select2 -->
                    </div>
                </div>
                <div class="col-sm-12 col-md-6">
                    <div class="form-group">
                        @foreach($visa_services as $service)
                        @if(!empty($service->Service($service->service_id)))
                            @if($record->visa_service_id == $service->unique_id)
                                <div>{{$service->Service($service->service_id)->name}} </div>
                            @endif        
                        @endif
                        @endforeach
                    </div>
                </div>
                </div>
            </div>
        </div>

        @foreach($dependents as $key => $dependent)
        <div class="row">
            <div class="col-sm-6 col-md-4"><a class="media align-items-center" href="javascript:;">
                <div class="avatar avatar-soft-primary avatar-circle mr-3">
                    <span class="avatar-initials">{{findInitial($dependent->given_name)}}</span>
                </div>
                <div class="media-body">
                    <span class="d-block h5 text-hover-primary mb-0">{{$dependent->given_name}}</span>
                    <!-- <span class="d-block font-size-sm text-body">anne@example.com</span> -->
                    <input type="hidden" name="dependents[{{$key}}][dependent_id]" value="{{$dependent->unique_id}}" />
                </div>
                </a>
            </div>
            <div class="col-sm-6 col-md-8">
                <div class="row">
                <div class="col-sm-12 col-md-6">
                    <div class="form-group">
                    <!-- Select2 -->
                    @if((isset($case_dependents[$dependent->unique_id])) && $case_dependents[$dependent->unique_id]['applicant_type'] == 1)
                    <div>Primary Applicant</div>
                    @elseif((isset($case_dependents[$dependent->unique_id])) && $case_dependents[$dependent->unique_id]['applicant_type'] == 2)
                    <div>Accompanying Dependent</div>
                    @elseif((isset($case_dependents[$dependent->unique_id])) && $case_dependents[$dependent->unique_id]['applicant_type'] == 3)
                    <div>Non-Accompanying</div>
                    @endif
                    </div>
                </div>
                <div class="col-sm-12 col-md-6">
                    <div class="form-group">
                    <!-- Select2 -->
                    @foreach($visa_services as $service)
                    @if(!empty($service->Service($service->service_id)))
                        @if(isset($case_dependents[$dependent->unique_id]) && $case_dependents[$dependent->unique_id]['visa_service_id'] == $service->unique_id)
                            <div>{{$service->Service($service->service_id)->name}} </div>
                        @endif
                    @endif
                    @endforeach
                    <!-- End Select2 -->
                    </div>
                </div>
                </div>
            </div>
        </div>
        @endforeach
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

</script>

@endsection