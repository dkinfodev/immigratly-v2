@extends('layouts.master')


@section('breadcrumb')
<!-- Content -->
<ol class="breadcrumb breadcrumb-no-gutter">
  <li class="breadcrumb-item"><a class="breadcrumb-link" href="{{ baseUrl('/') }}">Dashboard</a></li>
  <li class="breadcrumb-item active">{{$pageTitle}} ({{$category->name}})</li>
 
</ol>
<!-- End Content -->
@endsection

@section('header-right')
 <a class="btn btn-primary" href="{{ baseUrl('/screen-capture/'.base64_encode($category->id).'/add') }}">
          <i class="tio-add mr-1"></i> Add 
        </a>
@endsection


@section('content')
<!-- Content -->
<div class="screen_capture">
 

  <!-- Card -->
  <div class="card">
    <!-- Header -->
    <div class="card-header">
      <div class="row justify-content-between align-items-center flex-grow-1">
        <div class="col-sm-6 col-md-4 mb-3 mb-sm-0">
          <!-- <form>
            <div class="input-group input-group-merge input-group-flush">
              <div class="input-group-prepend">
                <div class="input-group-text">
                  <i class="tio-search"></i>
                </div>
              </div>
              <input id="datatableSearch" onchange="search(this.value)" type="search" class="form-control" placeholder="Search " aria-label="Search">
            </div>
          </form> -->
        </div>

        <div class="col-sm-6">
          <div class="d-sm-flex justify-content-sm-end align-items-sm-center">
            <!-- Datatable Info -->
            <div id="datatableCounterInfo" class="mr-2 mb-2 mb-sm-0" style="display: none;">
              <div class="d-flex align-items-center">
                <span class="font-size-sm mr-3">
                  <span id="datatableCounter">0</span>
                  Selected
                </span>
                <a class="btn btn-sm btn-outline-danger" data-href="{{ baseUrl('screen-capture/'.base64_encode($category->id).'/delete-multiple') }}" onclick="deleteMultiple(this)" href="javascript:;">
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
    <div class="table-responsive datatable-custom">
      <table id="tableList" class="table table-lg table-borderless table-thead-bordered table-align-middle card-table">
        <thead class="thead-light">
          <tr>
            <th class="table-column-pr-0">
              <div class="custom-control custom-checkbox">
                <input id="datatableCheckAll" type="checkbox" class="custom-control-input">
                <label class="custom-control-label" for="datatableCheckAll"></label>
              </div>
            </th>
            <th class="table-column-pl-0">Page Name</th>
            <th class="table-column-pl-0">Page Url</th>
            <th class="table-column-pl-0">Capture Website</th>
            <th>Action</th>
          </tr>
        </thead>
        <tbody>
        </tbody>
      </table>
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
var category_id = "{{ base64_encode($category->id) }}";
$(document).ready(function(){
  $('.js-toggle-switch').each(function () {
    var toggleSwitch = new HSToggleSwitch($(this)).init();
  });
 
})
loadData();
function loadData(page=1){
    $.ajax({
        type: "POST",
        url: BASEURL + '/screen-capture/'+category_id+'/ajax-list?page='+page,
        data:{
            _token:csrf_token
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
    $.ajax({
        type: "POST",
        url: BASEURL + '/screen-capture/search/'+keyword,
        data:{
            _token:csrf_token
        },
        dataType:'json',
        beforeSend:function(){
            var cols = $("#tableList thead tr > th").length;
            $("#tableList tbody").html('<tr><td colspan="'+cols+'"><center><i class="fa fa-spin fa-spinner fa-3x"></i></center></td></tr>');
            // $("#paginate").html('');
        },
        success: function (data) {
            $("#tableList tbody").html(data.contents);
            
            initPagination(data);
        },
    });
}
function captureScreen(id){
    $.ajax({
        type: "GET",
        url: BASEURL + '/screen-capture/'+category_id+'/capture/'+id,
        dataType:'json',
        beforeSend:function(){
            showLoader();
        },
        success: function (response) {
            if(response.status == true){
                successMessage(response.message);
                redirect(response.redirect_url);
            }else{
                errorMessage(response.message);
            }
        },
        error:function(){
            hideLoader();
            internalError();
        }
    });
}
</script>
@endsection