@extends('frontend.layouts.master')

@section('breadcrumb')
<!-- Content -->
<ol class="breadcrumb breadcrumb-no-gutter">
  <li class="breadcrumb-item"><a class="breadcrumb-link" href="{{ baseUrl('/') }}">Dashboard</a></li>
  <li class="breadcrumb-item"><a class="breadcrumb-link" href="{{ baseUrl('/eligibility-check') }}">Visa Groups</a></li>
  <li class="breadcrumb-item active" aria-current="page">{{$record->group_title}}</li>
</ol>
<!-- End Content -->
@endsection

@section('content')
<!-- Content -->
<!-- Sidebar Detached Content -->
<div class="sidebar-detached-content mt-3 mt-lg-0" style="background:#f8fafd">
            <!-- Page Header -->
            <div class="imm-view-program-details-container-header">
              <div class="page-header">
                <!-- Profile Cover -->
                <div class="profile-cover">
                  <div class="profile-cover-img-wrapper">
                    <img class="profile-cover-img" src="./assets/img/1920x400/img1.jpg" alt="Image Description">
                  </div>
                </div>
                <!-- End Profile Cover -->
                <div class="imm-view-details-main-title">
                  <div class="row mb-3 align-items-center">

                    <!-- End Col -->
                    <div class="col-xs-12 col-sm-3">
                      <!-- Media -->
                      <div class="d-flex">
                        <div class="imm-program-logo-container w-100">
                        @if(file_exists(public_path('uploads/visa-groups/'.$record->image)))
                              <img class="imm-program-logo" src="{{ asset('/public/uploads/visa-groups/'.$record->image) }}"  />
                        @endif
                        </div>
                      </div>
                      <!-- End Media -->
                    </div>
                    <!-- End Col -->
                    <div class="col-xs-12 col-sm-9">
                      <div class="imm-view-details-main-title-program">
                        <h3 class="card-title mb-2">
                          <a class="text-dark" href="javascript:;">{{$record->group_title}}</a>
                        </h3>
                        <div class="imm-self-assessment-container">
                          <div class="row">
                            <div class="col-5">
                              <div class="d-flex" style="text-align:right">

                                <img class="me-1" src="./assets/img/checked.svg" alt="" style="width:18px">

                                <p><b>{{$record->VisaServices->count()}}</b> Nomination pathways</p>
                              </div>


                            </div>
                          </div>
                        </div>
                      </div>
                    </div>
                  </div>
                  <!-- End Row -->



                </div>










                <!-- Nav Scroller -->

                <div class="imm-vieww-program-details-menu bg-white zi-2">

                  <!-- Nav -->
                  <ul class="nav nav-tabs page-header-tabs bg-white" id="pageHeaderTab">
                    <li class="nav-item active">
                      <a class="nav-link" href="#about-section">All programs</a>
                    </li>
                    <li class="nav-item">
                      <a class="nav-link" href="#jobs-section">My assessments<span
                          class="badge bg-info rounded-pill ms-1">+9</span></a>
                    </li>
                    <li class="nav-item">
                      <a class="nav-link" href="#reviews-section">Latest news</a>
                    </li>
                    <li class="nav-item">
                      <a class="nav-link" href="#interview-section">Recent draws</a>
                    </li>

                  </ul>
                  <!-- End Nav -->
                </div>

                <!-- End Nav Scroller -->

              </div>
            </div>
            <!-- End Page Header -->
            <!-- Card Grid -->
            <div class="imm-specific-program-container">
              <div class="row">


                <div class="col-lg-12">
                  
                  <div class="row mb-3" id="visa-services-list">
                    
                  </div>
                  <!-- End Row -->


                </div>
                <!-- End Col -->
              </div>
              <!-- End Row -->
            </div>
            <!-- End Card Grid -->
          </div>
          <!-- End Sidebar Detached Content -->
{{-- <div class="eligibility_check">
  

  <!-- Card -->
  <div class="card">
    <!-- Header -->
    <div class="card-header">
      <div class="row justify-content-between align-items-center flex-grow-1">
        <div class="col-sm-6 col-md-4 mb-3 mb-sm-0">
          <form>
            <!-- Search -->
            <div class="input-group input-group-merge input-group-flush">
              <div class="input-group-prepend">
                <div class="input-group-text">
                  <i class="tio-search"></i>
                </div>
              </div>
              <input id="datatableSearch" type="search" class="form-control" placeholder="Search visa services" aria-label="Search visa service">
            </div>
            <!-- End Search -->
          </form>
        </div>

        <div class="col-sm-12">
          <div class="d-sm-flex justify-content-sm-end align-items-sm-center">
            <!-- Datatable Info -->
            <div id="datatableCounterInfo" class="mr-2 mb-2 mb-sm-0" style="display: none;">
              <div class="d-flex align-items-center">
                <span class="font-size-sm mr-3">
                  <span id="datatableCounter">0</span>
                  Selected
                </span>
                <a class="btn btn-sm btn-outline-danger" data-href="{{ baseUrl('quick-eligibility/delete-multiple') }}" onclick="deleteMultiple(this)" href="javascript:;">
                  <i class="tio-delete-outlined"></i> Delete
                </a>
              </div>
            </div>
          </div>
        </div>
      </div>
      <!-- End Row -->
    </div>
    <!-- End Header -->

    <!-- Table -->
    <div class="col-sm-12">
      <div class="datatable-custom">
        <table id="tableList" class="table table-borderless">
          <thead class="thead-light">
            <tr>
              <!-- <th scope="col" class="table-column-pr-0">
                <div class="custom-control custom-checkbox">
                  <input id="datatableCheckAll" type="checkbox" class="custom-control-input">
                  <label class="custom-control-label" for="datatableCheckAll"></label>
                </div>
              </th> -->
              <th scope="col" class="table-column-pl-0">Name</th>
              <th scope="col">Action</th>
            </tr>
          </thead>
          <tbody>
          </tbody>
        </table>
      </div>
    </div>
    <!-- End Table -->

    <!-- Footer -->
    <div class="card-footer">
      <!-- Pagination -->
      <div class="row justify-content-center justify-content-sm-between align-items-sm-center">
        <div class="col-md-3 mb-2 mb-sm-0">
          <div class="d-flex justify-content-center justify-content-sm-start align-items-center">
            <span class="mr-2">Page:</span>
            <span id="pageinfo"></span>
          </div>
        </div>

        <div class="col-md-3 pull-right">
          <div class="justify-content-center justify-content-sm-end">
            <nav id="datatablePagination" aria-label="Activity pagination">
               <div class="dataTables_paginate paging_simple_numbers" id="datatable_paginate">
                  <ul id="datatable_pagination" class="pagination datatable-custom-pagination">
                     <li class="paginate_item page-item previous disabled">
                        <a class="paginate_button page-link btn btn-primary" aria-controls="datatable" data-dt-idx="0" tabindex="0" id="datatable_previous"><span aria-hidden="true">Prev</span></a>
                     </li>
                     <li class="paginate_item page-item">
                        <input onblur="changePage('goto')" min="1" type="number" id="pageno" class="form-control text-center" />
                     </li>
                     <li class="paginate_item page-item next disabled">
                        <a class="paginate_button page-link btn btn-primary" aria-controls="datatable" data-dt-idx="3" tabindex="0"><span aria-hidden="true">Next</span></a>
                     </li>
                  </ul>
               </div>
            </nav>
          </div>
        </div>
      </div>
      <!-- End Pagination -->
    </div>
    <!-- End Footer -->
  </div>
  <!-- End Card -->
</div> --}}
<!-- End Content -->
@endsection

@section('javascript')
<script src="assets/vendor/hs-toggle-switch/dist/hs-toggle-switch.min.js"></script>
<script type="text/javascript">
$(document).ready(function(){
  $('.js-toggle-switch').each(function () {
    var toggleSwitch = new HSToggleSwitch($(this)).init();
  });

  $("#datatableSearch").keyup(function(){
    var value = $(this).val();
    if(value == ''){
      loadData();
    }
    if(value.length > 3){
      loadData();
    }
  });
})
loadData();
function loadData(page=1){
    var search = $("#datatableSearch").val();
    $.ajax({
        type: "POST",
        url: BASEURL + '/quick-eligibility/ajax-list?page='+page,
        data:{
            _token:csrf_token,
            search:search,
            visa_group_id:"{{$visa_group_id}}"
        },
        dataType:'json',
        beforeSend:function(){
            showLoader();
        },
        success: function (data ) {
            hideLoader();
            $("#visa-services-list").html(data.contents);
            initPagination(data);
        },
        error:function(){
            internalError();
        }
    });
}


function search(keyword){
    loadData();
}

</script>
@endsection