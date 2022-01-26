@extends('layouts.master')

@section('breadcrumb')
<!-- Content -->
<ol class="breadcrumb breadcrumb-no-gutter">
  <li class="breadcrumb-item"><a class="breadcrumb-link" href="{{ baseUrl('/') }}">Dashboard</a></li>
  <!-- <li class="breadcrumb-item"><a class="breadcrumb-link" href="{{ baseUrl('/cases') }}">Cases</a></li> -->
  <li class="breadcrumb-item active" aria-current="page">{{$pageTitle}}</li>
</ol>
<!-- End Content -->
@endsection


@section('content')
<!-- Content -->
<div class="add-case">

    <!-- Page Header -->
    <div class="page-header">
        <div class="media mb-3">
            <!-- Avatar -->
            <div class="avatar avatar-xl avatar-4by3 mr-2">
                <img class="avatar-img" src="./assets/svg/brands/guideline.svg" alt="Image Description">
            </div>
            <!-- End Avatar -->

            <div class="media-body">
                <div class="row">
                    <div class="col-lg mb-3 mb-lg-0">
                        <h1 class="page-header-title">{{$record->case_title}}</h1>

                        <div class="row align-items-center">


                            <div class="col-auto">
                                <div class="row align-items-center">
                                    <div class="col-auto">Start date: {{$record->start_date}}</div>
                                    @if($record->due_date != '')
                                    <div class="col-auto">Due date: {{$record->due_date}}</div>
                                    @endif
                                </div>
                            </div>

                            <div class="col-auto">
                                <!-- Select -->
                                <!-- <div class="select2-custom">
                                    <select class="js-select2-custom custom-select-sm" size="1" style="opacity: 0;"
                                        id="ownerLabel" data-hs-select2-options='{
                                            "minimumResultsForSearch": "Infinity",
                                            "customClass": "custom-select custom-select-sm custom-select-borderless pl-0",
                                            "dropdownAutoWidth": true,
                                            "width": true
                                            }'>
                                        <option value="owner1" selected
                                            data-option-template='<span class="media align-items-center"><img class="avatar avatar-xss avatar-circle mr-2" src="./assets/img/160x160/img6.jpg" alt="Avatar" /><span class="media-body">Mark Williams</span></span>'>
                                            Mark Williams</option>
                                        <option value="owner2"
                                            data-option-template='<span class="media align-items-center"><img class="avatar avatar-xss avatar-circle mr-2" src="./assets/img/160x160/img10.jpg" alt="Avatar" /><span class="media-body">Amanda Harvey</span></span>'>
                                            Amanda Harvey</option>
                                        <option value="owner3"
                                            data-option-template='<span class="media align-items-center"><i class="tio-user-outlined text-body mr-2"></i><span class="media-body">Assign to owner</span></span>'>
                                            Assign to owner</option>
                                    </select>
                                </div> -->
                                <!-- End Select -->
                            </div>
                        </div>
                        <div class="row align-items-center">
                            <div class="col-12">
                                <span>Client:</span>
                                <span>
                                @if(!empty($record->Client($record->client_id)))
                                <?php
                                $client = $record->Client($record->client_id);
                                ?>
                                <span class="text-primary h4">{{$client->first_name." ".$client->last_name}}</span>
                                @else
                                <span class="text-danger h4">Client not found</span>
                                @endif
                                </span>
                            </div>
                        </div>
                    </div>

                    <div class="col-lg-auto">
                        <small class="text-cap mb-2">Team members:</small>

                        <div class="d-flex">
                          @foreach($assignedMember as $member)
                            <span class="badge badge-primary mr-2">{{$member->Staff->first_name." ".$member->Staff->last_name}}</span>
                          @endforeach
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <!-- End Media -->

        <!-- Nav -->

    </div>
    <!-- End Page Header -->
    <!-- Step Form -->
    <form id="form" action="{{ baseUrl('cases/update-group-case/'.base64_encode($record->id)) }}" method="post" class="js-validate js-step-form">
         @csrf
        <input type="hidden" name="step" value="{{$step}}" />
        <div class="row">
        <div class="col-lg-9">
          <!-- Content Step Form -->
          <div id="createProjectStepFormContent">
              @if($step == 1)
              <div id="createProjectStepDetails" class="active">
                
                <!-- Form Group -->
                <div class="form-group">
                    <label for="clientNewProjectLabel" class="input-label">Client</label>
                    <div class="row">
                      <div class="col-sm-7">
                          <div class="form-group js-form-message mb-0">
                              <!-- Select -->
                              <div class="select2-custom">
                                <select class="js-select2-custom custom-select" required name="client_id" id="client_id" onchange="fetchDependents(this.value)">
                                    <option value="">Select Client</option>
                                    @foreach($clients as $client)
                                    <option {{$client->unique_id == $record->client_id?'selected':''}} value="{{$client->unique_id}}">
                                      {{$client->first_name." ".$client->last_name}} ({{$client->email}})
                                    </option>
                                    @endforeach
                                </select>
                              </div>
                              <!-- End Select -->
                          </div>
                          <div id="show-msg" style="color:#377dff; background-color: rgba(55, 125, 255, 0.1);padding:0.875rem;margin-top:1rem;border-radius:0.3125rem;display:none">
                            This client does not have any dependents. You can add dependents from the clients' list section or
                            choose the single-user option from the create case list.
                          </div>
                        
                      </div>
                      <div class="col-1 text-center">OR</div>
                      <div class="col-sm-3">
                          <a class="btn btn-white" onclick="showPopup('<?php echo baseUrl('cases/create-client') ?>')" href="javascript:;">
                          <i class="tio-add mr-1"></i>New client
                          </a>
                      </div>
                    </div>
                </div>
                <!-- End Form Group -->
                <!-- Form Group -->
                <div class="form-group js-form-message">
                    <label class="input-label">Case Title</label>
                    <div class="input-group input-group-merge">
                      <div class="input-group-prepend">
                          <div class="input-group-text">
                            <i class="tio-briefcase-outlined"></i>
                          </div>
                      </div>
                      <input type="text" value="{{ $record->case_title }}" required data-msg="Please enter case title" class="form-control" name="case_title" id="case_title" placeholder="Enter case title here" aria-label="Enter case title here">
                    </div>
                </div>
                <!-- End Form Group -->
                <div class="row">
                    <div class="col-sm-4">
                      <!-- Form Group -->
                      <div class="form-group js-form-message">
                          <label class="input-label">Start date</label>
                          <div class="input-group input-group-merge">
                            <div class="input-group-prepend" data-toggle>
                                <div class="input-group-text">
                                  <i class="tio-date-range"></i>
                                </div>
                            </div>
                            <input value="{{ $record->start_date }}" required autocomplete="off" data-msg="Please select start date" type="text" name="start_date" class="form-control" id="start_date" placeholder="Select Start Date" data-input value="">
                          </div>
                      </div>
                      <!-- End Form Group -->
                    </div>
                    <div class="col-sm-4">
                      <!-- Form Group -->
                      <div class="form-group js-form-message">
                          <label class="input-label">End date</label>
                          <div class="input-group input-group-merge">
                            <div class="input-group-prepend" data-toggle>
                                <div class="input-group-text">
                                  <i class="tio-date-range"></i>
                                </div>
                            </div>
                            <input value="{{ $record->end_date }}" type="text" autocomplete="off" data-msg="Please select end date" name="end_date" class="form-control" id="end_date" placeholder="Select End Date" data-input value="">
                          </div>
                      </div>
                      <!-- End Form Group -->
                    </div>
                    <!-- <div class="col-sm-4">
                      <div class="js-form-message form-group">
                          <label class="input-label font-weight-bold">Visa Service</label>
                          <select name="visa_service_id" required data-msg="Please select visa service" id="visa_service_id" class="custom-select"
                            data-hs-select2-options='{
                              "placeholder": "Select Visa Service"
                            }'
                          >
                            <option value="">Select Service</option>
                            @foreach($visa_services as $service)
                              @if(!empty($service->Service($service->service_id)))
                                <option value="{{$service->unique_id}}">{{$service->Service($service->service_id)->name}} </option>
                              @endif
                            @endforeach
                          </select>
                        </div>
                    </div> -->
                </div>
                <div class="form-group js-form-message">
                    <label class="input-label">Description <span class="input-label-secondary">(Optional)</span></label>
                    <textarea class="form-control" id="description" name="description">{{ $record->description}}</textarea>
                </div>
                
                
                <!-- Footer -->
                <div class="d-flex align-items-center">
                    <div class="ml-auto">
                      <button type="submit" id="savebtn" class="btn btn-primary">
                      Next <i class="tio-chevron-right"></i>
                      </button>
                    </div>
                </div>
                <!-- End Footer -->
              </div>
              @elseif($step==2)
              <div id="createProjectStepClients" class="active">
                  <div class="group-client-header-selection mb-3">
                    <div class="row">
                      <div class="col-sm-6 col-md-4"><span>Name</span>
                      </div>
                      <div class="col-sm-6 col-md-8">
                        <div class="row">
                          <div class="col-sm-12 col-md-6">Applicant type</div>
                          <div class="col-sm-12 col-md-6">Visa Service</div>
                        </div>
                      </div>
                    </div>
                  </div>
                @if(!empty($record->Client($record->client_id)))
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
                            <select class="js-select2-custom custom-select" name="main_user[applicant_type]" size="1" style="opacity: 0;"
                              data-hs-select2-options='{
                                "minimumResultsForSearch": "Infinity",
                                "placeholder": "Select applicant type"
                              }'>
                              <option label="empty"></option>
                              <option {{ ($record->applicant_type == 1)?'selected':''  }} value="1">Primary Applicant</option>
                              <option {{ ($record->applicant_type == 2)?'selected':''  }} value="2">Accompanying Dependent</option>
                              <option {{ ($record->applicant_type == 3)?'selected':''  }} value="3">Non-Accompanying</option>
                              <!-- <option value="remove" data-option-template='<span class="text-danger">Remove</span>'>Remove</option> -->
                            </select>
                            <!-- End Select2 -->
                          </div>
                        </div>
                        <div class="col-sm-12 col-md-6">
                          <div class="form-group">
                            <!-- Select2 -->
                            <!-- Select2 -->
                            <select class="js-select2-custom custom-select" size="1" name="main_user[visa_service_id]" style="opacity: 0;"
                              data-hs-select2-options='{
                                "placeholder": "Choose service",
                                "searchInputPlaceholder": "Choose Service"
                              }'>
                              <option label="empty"></option>
                              @foreach($visa_services as $service)
                                @if(!empty($service->Service($service->service_id)))
                                <option {{ ($record->visa_service_id == $service->unique_id)?'selected':'' }} value="{{$service->unique_id}}">{{$service->Service($service->service_id)->name}} </option>
                                @endif
                              @endforeach
                            </select>
                            <!-- End Select2 -->
                            <!-- End Select2 -->
                          </div>
                        </div>
                      </div>
                    </div>
                  </div>
                  @endif

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
                            <select class="js-select2-custom custom-select" name="dependents[{{ $key }}][applicant_type]" size="1" style="opacity: 0;"
                              data-hs-select2-options='{
                                "minimumResultsForSearch": "Infinity",
                                "placeholder": "Select applicant type"
                              }'>
                              <option label="empty"></option>
                              <option {{ (isset($case_dependents[$dependent->unique_id])) && $case_dependents[$dependent->unique_id]['applicant_type'] == 1?'selected':''  }} value="1">Primary Applicant</option>
                              <option {{ (isset($case_dependents[$dependent->unique_id])) && $case_dependents[$dependent->unique_id]['applicant_type'] == 2?'selected':''  }} value="2">Accompanying Dependent</option>
                              <option {{ (isset($case_dependents[$dependent->unique_id])) && $case_dependents[$dependent->unique_id]['applicant_type'] == 3?'selected':''  }} value="3">Non-Accompanying</option>
                            </select>
                            <!-- End Select2 -->
                          </div>
                        </div>
                        <div class="col-sm-12 col-md-6">
                          <div class="form-group">
                            <!-- Select2 -->
                            <!-- Select2 -->
                            <select class="js-select2-custom custom-select" name="dependents[{{ $key }}][visa_service_id]" size="1" style="opacity: 0;"
                              data-hs-select2-options='{
                                "placeholder": "Choose service",
                                "searchInputPlaceholder": "Choose Service"
                              }'>
                              <option label="empty"></option>
                              @foreach($visa_services as $service)
                                @if(!empty($service->Service($service->service_id)))
                                <option {{ (isset($case_dependents[$dependent->unique_id])) && $case_dependents[$dependent->unique_id]['visa_service_id'] == $service->service_id?'selected':''  }} value="{{$service->service_id}}">{{$service->Service($service->service_id)->name}} </option>
                                @endif
                              @endforeach
                            </select>
                            <!-- End Select2 -->
                            <!-- End Select2 -->
                          </div>
                        </div>
                      </div>
                    </div>
                  </div>
                  @endforeach
                
                  <div class="d-flex align-items-center">
                    <a href="{{ baseUrl('cases/edit-group-case/'.base64_encode($record->id).'?step='.($step-1)) }}" class="btn btn-ghost-secondary mr-2">
                      <i class="tio-chevron-left"></i> Previous step
                    </a>
                    <div class="ml-auto">
                      <button type="submit" class="btn btn-primary">
                      Next <i class="tio-chevron-right"></i>
                      </button>
                    </div>
                </div>
                <!-- End Footer -->
              </div>
              @elseif($step == 3)
              <div id="createProjectStepAssignTeam" class="active">
                <div class="row">
                    <div class="col-lg-9"> 
                        <label class="input-label">Assign staff</label>
                    </div>
                    <div class="col-lg-9 mb-5 mb-lg-0">
                        <div class="form-group js-form-message">
                            <!-- Select2 -->
                            <select class="js-select2-custom custom-select" id="assign_teams" name="assign_teams" size="1" style="opacity: 0;"
                                data-hs-select2-options='{
                                    "placeholder": "Select Staff"
                                }'>
                                <option value="" >Select Team</option>
                                @foreach($staffs as $staff)
                                    <option data-name="{{$staff->first_name.' '.$staff->last_name}}" data-role="{{ $staff->role }}" value="{{$staff->unique_id}}">{{$staff->first_name.' '.$staff->last_name}} ({{$staff->role}})</option>
                                @endforeach
                            </select>
                            <!-- End Select2 -->

                        </div>
                    </div>
                    <div class="col-lg-3 mb-5 mb-lg-0">
                        <button type="button" onclick="assignedStaff()" class="btn btn-primary" style="width:100%"> <i
                            class="tio-add ml-1"></i>
                            Add
                        </button> 
                    </div>
                </div>
                <div class="row">
                <div class="col-lg-12 mb-5 mb-lg-0">
                  <!-- Card -->
                  <div class="card">


                    <!-- Table -->
                    <div class="table-responsive">
                      <table class="table table-lg table-borderless table-thead-bordered table-nowrap table-align-middle">
                        <thead class="thead-light">
                          <tr>
                            <th>Name</th>
                            <th>Designation</th>

                            <th>Status</th>
                            <th>Discard?</th>
                          </tr>
                        </thead>

                        <tbody>
                          @foreach($assignedMember as $member)
                          <tr>
                            <td>
                              <a class="media align-items-center" href="javascript:;">
                                <div class="avatar avatar-circle mr-3">
                                  <img class="avatar-img" src="{{ professionalProfile($member->user_id,'t') }}" alt="Image Description">
                                </div>
                                <div class="media-body">
                                  <span class="d-block h5 text-hover-primary mb-0">{{$member->Staff->first_name." ".$member->Staff->last_name}} <i class="tio-verified text-primary" data-toggle="tooltip" data-placement="top" title="" data-original-title="Top endorsed"></i></span>                                  
                                  <span class="d-block font-size-sm text-body">{{$member->Staff->email}}</span>
                                </div>
                              </a>
                            </td>
                            <td>
                              <span class="d-block h5 mb-0">{{$member->Staff->role}}</span>
                              <!-- <span class="d-block font-size-sm">Human resources</span> -->
                            </td>

                            <td>
                              @if($member->Staff->is_active == 1)
                              <span class="legend-indicator bg-success"></span>Active
                              @else
                              <span class="legend-indicator bg-danger"></span>Inactive
                              @endif
                            </td>
                            <td class="text-center">
                              <a href="javascript:;" data-href="<?php echo baseUrl('/cases/remove-assigned-user/'.base64_encode($member->id)) ?>" onclick="confirmAction(this)">
                                <i class="tio-clear-circle-outlined"></i>
                              </a>
                            </td>
                          </tr>
                          @endforeach
                         
                        </tbody>
                      </table>
                    </div>
                    <!-- End Table -->
                  </div>
                </div>
              </div>
                
                
                <!-- Footer -->
                <div class="d-flex align-items-center">
                    <a href="{{ baseUrl('cases/edit-group-case/'.base64_encode($record->id).'?step='.($step-1)) }}" class="btn btn-ghost-secondary mr-2">
                      <i class="tio-chevron-left"></i> Previous step
                    </a>
                    <div class="ml-auto">
                      <a href="{{ baseUrl('cases/edit-group-case/'.base64_encode($record->id).'?step='.($step+1)) }}" class="btn btn-primary mr-2">
                        Next <i class="tio-chevron-right"></i>
                      </a>
                    </div>
                </div>
                <!-- End Footer -->
              </div>
              @elseif($step == 4)
              <div id="createProjectStepMembers">
                
                <div class="row">
                    <div class="col-lg-12 text-center">
                      <h2>Confirm Details</h2>
                      <div class="confirm-details row">
                          <div class="col-md-6 text-left">
                            <ul class="list-unstyled list-unstyled-py-3 text-dark mb-3">
                              <li class="py-0">
                                <small class="card-subtitle">Case Details</small>
                              </li>
                              <li>
                                <i class="tio-user-outlined nav-icon"></i>
                                @if(!empty($record->Client($record->client_id)))
                                <?php
                                $client = $record->Client($record->client_id);
                                ?>
                                <span>{{$client->first_name." ".$client->last_name}}</span>
                                @else
                                <span>Client not found</span>
                                @endif
                              </li>
                              <li>
                                <i class="tio-briefcase-outlined nav-icon"></i>
                                Case Title: {{$record->case_title}}
                              </li>
                              <li>
                                <i class="tio-date-range nav-icon"></i>
                                Start Date: {{$record->start_date}}
                              </li>
                              <li>
                                <i class="tio-date-range nav-icon"></i>
                                End Date: {{$record->due_date}}
                              </li>
                            </ul>
                          </div>
                          <div class="col-md-6 text-left" id="assign_staff_list">
                            <ul class="nav card-nav card-nav-vertical nav-pills">
                                <li class="py-0 text-left">
                                  <small class="card-subtitle">Dependents Members</small>
                                </li>
                                @foreach($dependents as $key => $dependent)
                                <li class="text-left">
                                  <div class="media">
                                    <i class="tio-group-senior nav-icon text-dark"></i>
                                    <span class="media-body">
                                      <span class="d-block text-dark">{{$dependent->given_name}}</span>
                                      @if((isset($case_dependents[$dependent->unique_id])) && $case_dependents[$dependent->unique_id]['applicant_type'] == 1)
                                        <small>Primary Applicant</small>
                                      @elseif((isset($case_dependents[$dependent->unique_id])) && $case_dependents[$dependent->unique_id]['applicant_type'] == 2)
                                        <small>Accompanying Dependent</small>
                                      @elseif((isset($case_dependents[$dependent->unique_id])) && $case_dependents[$dependent->unique_id]['applicant_type'] == 3)
                                        <small>Non-Accompanying</small>
                                      @endif
                                    </span>
                                  </div>
                                </li>
                                @endforeach
                                
                            </ul>
                          </div>
                      </div>
                    </div>
                </div>
                <!-- End Toggle Switch -->
                <!-- Footer -->
                <div class="d-sm-flex align-items-center">
                  <a href="{{ baseUrl('cases/edit-group-case/'.base64_encode($record->id).'?step='.($step-1)) }}" class="btn btn-ghost-secondary mr-2">
                    <i class="tio-chevron-left"></i> Previous step
                  </a>
                  <div class="d-flex justify-content-end ml-auto">
                      <a href="{{ baseUrl('cases') }}" class="btn btn-white mr-2">Cancel</a>
                      <button id="createProjectFinishBtn" type="submit" class="btn btn-primary">Create Case</button>
                    </div>
                </div>
                <!-- End Footer -->
              </div>
              @endif
          </div>
        </div>
        <div class="col-lg-3">
          <!-- Step -->
          <ul id="createProjectStepFormProgress" class="js-step-progress step step-icon-sm mb-7">
              <li class="step-item">
                <a class="step-content-wrapper" href="javascript:;"
                    data-hs-step-form-next-options='{
                    "targetSelector": "#createProjectStepDetails"
                    }'>

                    <span class="step-icon step-icon-success"><i class="tio-done"></i></span>
                    <div class="step-content">
                      <span class="step-title">Add Case</span>
                    </div>
                </a>
              </li>
              <li class="step-item">
                <a class="step-content-wrapper" href="javascript:;"
                    data-hs-step-form-next-options='{
                    "targetSelector": "#createProjectStepClients"
                    }'>
                    @if($step > 1)
                      <span class="step-icon step-icon-success"><i class="tio-done"></i></span>
                    @else
                      <span class="step-icon step-icon-soft-dark">2</span>
                    @endif
                    <div class="step-content">
                      <span class="step-title">Select Clients</span>
                    </div>
                </a>
              </li>
              <li class="step-item">
                <a class="step-content-wrapper" href="javascript:;"
                    data-hs-step-form-next-options='{
                    "targetSelector": "#createProjectStepAssignTeam"
                    }'>
                    @if($step > 2)
                      <span class="step-icon step-icon-success"><i class="tio-done"></i></span>
                    @else
                      <span class="step-icon step-icon-soft-dark">3</span>
                    @endif
                    <div class="step-content">
                      <span class="step-title">Assign Staff</span>
                    </div>
                </a>
              </li>
              <li class="step-item">
                <a class="step-content-wrapper" href="javascript:;"
                    data-hs-step-form-next-options='{
                    "targetSelector": "#createProjectStepMembers"
                    }'>
                    @if($step > 3)
                      <span class="step-icon step-icon-success"><i class="tio-done"></i></span>
                    @else
                      <span class="step-icon step-icon-soft-dark">4</span>
                    @endif
                    <div class="step-content">
                      <span class="step-title">Confirmation
                      </span>
                    </div>
                </a>
              </li>
          </ul>
          <!-- End Step -->
        </div>
        </div>
         <!-- End Content Step Form -->
         <!-- Message Body -->
         <!-- End Message Body -->
      </form>
      <!-- End Step Form -->
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
<script type="text/javascript">
@if($step == 1)
initEditor("description");
@endif
$(document).on('ready', function() {
    $("#client_id").change(function() {
        if ($(this).val() != '') {
            var text = $("#client_id").find("option:selected").text();
            $("#client_name_text").html(text.trim());
        } else {
            $("#client_name_text").html('');
        }
    });
    $("[name=case_title]").change(function() {
        if ($(this).val() != '') {
            $("#case_title_text").html($(this).val());
        } else {
            $("#case_title_text").html('');
        }
    });
    $("[name=start_date]").change(function() {
        if ($(this).val() != '') {
            $("#start_date_text").html($(this).val());
        } else {
            $("#start_date_text").html('');
        }
    });
    $("[name=end_date]").change(function() {
        if ($(this).val() != '') {
            $("#end_date_text").html($(this).val());
        } else {
            $("#end_date_text").html('');
        }
    });
    $("#visa_service_id").change(function() {
        if ($(this).val() != '') {
            var text = $("#visa_service_id").find("option:selected").text();
            $("#visa_service_text").html(text.trim());
        } else {
            $("#visa_service_text").html('');
        }
    });
    $("#assign_teams").change(function() {
        if ($("#assign_teams").val() != '') {
            var html = '';
            $("#assign_staff_list").show();
            $(".staff").remove();
            $("#assign_teams").find("option:selected").each(function() {
                var text = $(this).attr('data-name');
                var role = $(this).attr('data-role');

                html += '<li class="text-left staff">';
                html += '<a class="nav-link media" href="javascript:;">';
                html += '<i class="tio-group-senior nav-icon text-dark"></i>';
                html += '<span class="media-body">';
                html += '<span class="d-block text-dark">' + text.trim() + '</span>';
                html += '<small class="d-block text-muted">' + role + '</small>';
                html += '</span></a></li>';
            });
            $("#assign_staff_list ul").append(html);
        } else {
            $("#assign_staff_list").hide();
            $("#assign_staff_list .staff").remove();
        }
    });
    $('#start_date').datepicker({
        format: 'dd/mm/yyyy',
        autoclose: true,
        maxDate: (new Date()).getDate(),
        todayHighlight: true,
        orientation: "bottom auto"
    })
    .on('changeDate', function(selected) {
        startDate = new Date(selected.date.valueOf());
        startDate.setDate(startDate.getDate(new Date(selected.date.valueOf())));
        $('#end_date').datepicker('setStartDate', startDate);
    });
    $('#end_date').datepicker({
        format: 'dd/mm/yyyy',
        autoclose: true,
        maxDate: (new Date()).getDate(),
        todayHighlight: true,
        orientation: "bottom auto"
    });
    $('.js-validate').each(function() {
        $.HSCore.components.HSValidation.init($(this));
    });
    // $('.js-step-form').each(function() {
    //     var stepForm = new HSStepForm($(this), {
    //         validate: function() {},
    //         finish: function() {
    //             var formData = $("#form").serialize();
    //             var url = $("#form").attr('action');
    //             $.ajax({
    //                 url: url,
    //                 type: "post",
    //                 data: formData,
    //                 dataType: "json",
    //                 beforeSend: function() {
    //                     showLoader();
    //                 },
    //                 success: function(response) {
    //                     hideLoader();
    //                     if (response.status == true) {
    //                         successMessage(response.message);
    //                         redirect(response.redirect_back);
    //                     } else {
    //                         validation(response.message);
    //                         // errorMessage(response.message);
    //                     }
    //                 },
    //                 error: function() {
    //                     internalError();
    //                 }
    //             });
    //         }
    //     }).init();
    // });
    $("#form").submit(function(e) {
        e.preventDefault();
        var formData = $("#form").serialize();
        var url = $("#form").attr('action');
        $.ajax({
            url: url,
            type: "post",
            data: formData,
            dataType: "json",
            beforeSend: function() {
                showLoader();
            },
            success: function(response) {
                hideLoader();
                if (response.status == true) {
                    successMessage(response.message);
                    redirect(response.redirect_back);
                } else {
                  if(response.error_type == 'validation'){
                    validation(response.message);
                  }else{
                    errorMessage(response.message);
                  } 
                }
            },
            error: function() {
                internalError();
            }
        });
    });
});

function fetchDependents(client_id) {
    $.ajax({
        url: "{{ baseUrl('cases/fetch-client-dependents') }}",
        type:"post",
        data: {
            _token:csrf_token,
            client_id: client_id
        },
        dataType: "json",
        beforeSend: function() {
            showLoader();
        },
        success: function(response) {
          hideLoader();
          if (response.status == true) {
              if(response.count > 0){
                $("#show-msg").hide();
              }else{
                $("#show-msg").show();
              }
          }else{
              $("#show-msg").hide();
          }
        },
        error: function() {

        }
    });
}

function assignedStaff(){
  var assign_teams = $("#assign_teams").val();
  if(assign_teams == ''){
    errorMessage("Please select the staff");
  }else{
    var formData = $("#form").serialize();
    var url = $("#form").attr('action');
    $.ajax({
        url: url,
        type: "post",
        data: formData,
        dataType: "json",
        beforeSend: function() {
            showLoader();
        },
        success: function(response) {
            hideLoader();
            if (response.status == true) {
                successMessage(response.message);
                redirect(response.redirect_back);
            } else {
              if(response.error_type == 'validation'){
                validation(response.message);
              }else{
                errorMessage(response.message);
              } 
            }
        },
        error: function() {
            internalError();
        }
    });
  }
}
</script>

@endsection