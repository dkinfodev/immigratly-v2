@extends('layouts.master')

@section('breadcrumb')
<!-- Content -->
<ol class="breadcrumb breadcrumb-no-gutter">
  <li class="breadcrumb-item"><a class="breadcrumb-link" href="{{ baseUrl('/') }}">Dashboard</a></li>
  
  <li class="breadcrumb-item active" aria-current="page">{{$pageTitle}}</li>
</ol>
<!-- End Content -->
@endsection
@section('header-right')
  <div class="float-right">
      <a href="{{ baseUrl('booked-appointments/add') }}" class="btn btn-primary"><i class="tio-calendar"></i> Add Appointment</a>
  </div>
@endsection

@section('content')
<!-- Content -->
<div class="assessments">
  <!-- Page Header -->
  

  <!-- Card -->
  <div class="card">
    <!-- Header -->
    <div class="card-header">
      
      <div class="row justify-content-between align-items-center flex-grow-1">
        <div class="col-sm-6 col-md-4 mb-3 mb-sm-0">
          <h5 class="card-header-title">Appointments with Clients</h5>
        </div>
        <div class="col-sm-6">
          <div class="d-sm-flex justify-content-sm-end align-items-sm-center">
              <a href="{{ baseUrl('/booked-appointments/calendar') }}"><i class="tio-calendar"></i> View Appointments in Calendar</a>
          </div>
        </div>
      </div>
      <!-- End Row -->
    </div>
    <!-- End Header -->

    <!-- Table -->
    <div class="col-sm-12">
      <div class="table-responsive datatable-custom">
        <table id="tableList" class="table table-borderless">
          <thead class="thead-light">
            <tr>
              <!-- <th scope="col" class="table-column-pr-0">
                <div class="custom-control custom-checkbox">
                  <input id="datatableCheckAll" type="checkbox" class="custom-control-input">
                  <label class="custom-control-label" for="datatableCheckAll"></label>
                </div>
              </th> -->
              <th scope="col" class="table-column-pl-0">Client</th>
              <th scope="col" class="table-column-pl-0">Location</th>
              <th scope="col" class="table-column-pl-0">Visa Service</th>
              <th scope="col" class="table-column-pl-0">Meeting Date/Time</th>
              <th scope="col" class="table-column-pl-0">Status</th>
              <th scope="col" class="table-column-pl-0">Payment Status</th>
              <th scope="col" class="table-column-pl-0">Price</th>
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
</div>
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
        url: BASEURL + '/booked-appointments/ajax-list?page='+page,
        data:{
            _token:csrf_token,
            search:search
        },
        dataType:'json',
        beforeSend:function(){
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


function search(keyword){
    loadData();
}

</script>
@endsection