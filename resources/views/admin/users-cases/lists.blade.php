@extends('layouts.master')

@section('breadcrumb')
<!-- Content -->
<ol class="breadcrumb breadcrumb-no-gutter">
  <li class="breadcrumb-item"><a class="breadcrumb-link" href="{{ baseUrl('/') }}">Dashboard</a></li>
  <li class="breadcrumb-item active" aria-current="page">{{$pageTitle}}</li>
</ol>
<!-- End Content -->
@endsection


@section('content')

<style>

.dropdown-menu{
  z-index: 999;
}
</style>
<!-- Content -->
<div class="case-list">


  <!-- Card -->
  <div class="card">
    <!-- Header -->
    <div class="card-header">
      <div class="row justify-content-between align-items-center flex-grow-1">
        <div class="col-sm-4 col-md-4 mb-3 mb-sm-0">
          <form>
            <!-- Search -->
            <div class="input-group input-group-merge input-group-flush">
              <div class="input-group-prepend">
                <div class="input-group-text">
                  <i class="tio-search"></i>
                </div>
              </div>
              <input id="datatableSearch" type="search" class="form-control" placeholder="Search Case title" aria-label="Search Case">
            </div>
            <!-- End Search -->
          </form>
        </div>

        <div class="col-sm-2">
          <div class="d-sm-flex justify-content-sm-end align-items-sm-center">
            <!-- Datatable Info -->
            <div id="datatableCounterInfo" class="mr-2 mb-2 mb-sm-0" style="display: none;">
              <div class="d-flex align-items-center">
                <span class="font-size-sm mr-3">
                  <span id="datatableCounter">0</span>
                  Selected
                </span>
                <a class="btn btn-sm btn-outline-danger" data-href="{{ baseUrl('cases/delete-multiple') }}" onclick="deleteMultiple(this)" href="javascript:;">
                  <i class="tio-delete-outlined"></i> Delete
                </a>
              </div>
            </div>
          </div>
        </div>

        <div class="col-sm-6">
            
            
        </div>
      </div>
      <!-- End Row -->
    </div>
    <!-- End Header -->

    <!-- Table -->
    <div class="datatable-custom">
      <div id="tableList">
      
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
<script type="text/javascript">
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
  $("#datatableSearch").on("search", function() { 
    loadData();
 });
});
loadData();
function loadData(page=1){
  var search = $("#datatableSearch").val();
  $.ajax({
      type: "POST",
      url: BASEURL + '/users-cases/ajax-list?page='+page,
      data:{
          _token:csrf_token,
          search:search,
      },
      dataType:'json',
      beforeSend:function(){
          showLoader();
      },
      success: function (data) {
          hideLoader();
          $("#tableList").html(data.contents);
          initPagination(data);
          
      },
      error:function(){
        internalError();
      }
  });
}
function caseApprovalStatus(case_id,client_id){

    if($(this).is(":checked")){
      $.ajax({
          type: "POST",
          url: BASEURL + '/cases/approve-case',
          data:{
              _token:csrf_token,
              client_id:client_id,
              case_id:case_id,
          },
          dataType:'json',
          beforeSend:function(){
            showLoader();
          },
          success: function (result) {
              if(result.status == true){
                  successMessage(result.message);
                  location.reload();
              }else{
                  errorMessage(result.message);
              }
          },
      });
    }else{
      $.ajax({
          type: "POST",
          url: BASEURL + '/cases/approve-case',
          data:{
              _token:csrf_token,
              client_id:client_id,
              case_id:case_id,
          },
          dataType:'json',
          beforeSend:function(){
            showLoader();
          },
          success: function (result) {
              if(result.status == true){
                  successMessage(result.message);
                  location.reload();
              }else{
                  errorMessage(result.message);
              }
          },
          error: function(){
            internalError();
          }
      });
    }
}
</script>
@endsection