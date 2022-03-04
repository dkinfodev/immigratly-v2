@extends('layouts.front-master')
@section("breadcrumb")
<ol class="breadcrumb breadcrumb-dark mb-0">
  <li class="breadcrumb-item"><a class="breadcrumb-link" href="{{ baseUrl('/') }}">Dashboard</a></li>
  <li class="breadcrumb-item active" aria-current="page">{{$pageTitle}}</li>
</ol>
@endsection

@section('content')
<!-- Sidebar Detached Content -->
  <div class="sidebar-detached-content mt-3 mt-lg-0">
      <!-- Hero -->
      <div class="gradient-x-three-sm-primary">
          <div class="container pt-5">
              <div class="float-right mb-3">
                  <a href="{{ baseUrl('eligibility-check/view-history') }}" class="text-danger"><i class="tio-import-export"></i> View History</a>
                  <div class="clearfix"></div>
              </div>
              <div class="clearfix"></div>
              <form id="form-search">
                  {{csrf_field()}}
                  <!-- Input Card -->
                  <div class="input-card input-card-sm mb-3">
                      <div class="input-card-form">
                          <!-- <label for="jobTitleForm" class="form-label visually-hidden">Job, title, skills, or company</label> -->
                          <div class="input-group input-group-merge">
                              <span class="input-group-prepend input-group-text">
                                  <i class="bi-search"></i>
                              </span>
                              <input type="text" name="search" class="form-control" id="search"
                                  placeholder="Search by Visa Group Title"
                                  aria-label="Search by Visa Group Title">
                          </div>
                      </div>
                      <button type="button" onclick="loadData()" class="btn btn-primary">Search</button>
                  </div>
                  <!-- End Input Card -->
             

                <div class="row align-items-center">
                  <div class="col-md-auto mb-3 mb-lg-0">
                      <h6 class="mb-1">Limit search to:</h6>
                  </div>
                  <!-- End Col -->

                  <div class="col-md mb-3 mb-lg-0">
                      @foreach($program_types as $program)
                      <!-- Check -->
                      <div class="form-check form-check-inline">
                          <input class="form-check-input program_types" name="program_types[]" onchange="loadData()" type="checkbox" id="checkbox-{{$program->id}}" value="{{$program->id}}">
                          <label class="form-check-label" for="checkbox-{{$program->id}}">{{$program->name}}</label>
                      </div>
                      <!-- End Check -->
                      @endforeach
                  </div>

                  <div class="col-md-auto">
                  </div>
                  <!-- End Col -->
                </div>
                </form>
              <!-- End Row -->
          </div>
      </div>
      <!-- End Hero -->

      <!-- Card Grid -->
      <div class="imm-all-program-container">
          <div class="row">


              <div class="col-lg-12">

                  <div class="row mb-5" id="group-lists">
                     
                      
                  </div>
                  <!-- End Row -->
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
              <!-- End Col -->
          </div>
          <!-- End Row -->
      </div>
      <!-- End Card Grid -->
  </div>
  <!-- End Sidebar Detached Content -->
  @endsection
  
@section('javascript')
<script src="assets/vendor/hs-toggle-switch/dist/hs-toggle-switch.min.js"></script>
<script type="text/javascript">
$(document).ready(function(){
  $('.js-toggle-switch').each(function () {
    var toggleSwitch = new HSToggleSwitch($(this)).init();
  });

  $("#search").keyup(function(){
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
    var search = $("#search").val();
    var program_types = $(".program_types:checked").val();
    $.ajax({
        type: "POST",
        url: BASEURL + '/eligibility-check/group-ajax-list?page='+page,
        data:$("#form-search").serialize(),
        dataType:'json',
        beforeSend:function(){
            showLoader();
        },
        success: function (data ) {
            hideLoader();
            $("#group-lists").html(data.contents);
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