@extends('layouts.master')
@section("style")
<style>
.all_services li {
    padding: 16px;
    border-bottom: 1px solid #ddd;
}
.sub_services li {
    border-bottom: none;
}
</style>
@endsection
@section('content')
<!-- Content -->
<div class="content container-fluid">
  <div class="page-header">
    <div class="row align-items-end">
      <div class="col-sm mb-2 mb-sm-0">
        <nav aria-label="breadcrumb">
          <ol class="breadcrumb breadcrumb-no-gutter">
            <li class="breadcrumb-item"><a class="breadcrumb-link" href="{{ baseUrl('/') }}">Dashboard</a></li>
            <li class="breadcrumb-item"><a class="breadcrumb-link" href="{{ baseUrl('/services') }}">Services</a></li>
            <li class="breadcrumb-item active" aria-current="page">{{$pageTitle}}</li>
          </ol>
        </nav>
        <h1 class="page-title">{{$pageTitle}}</h1>
      </div>
    </div>
  </div>
  <div class="accordion" id="accordionExample">
    <div class="card" id="headingOne">
      <a class="card-header card-btn btn-block" href="javascript:;" data-toggle="collapse" data-target="#collapseOne" aria-expanded="true" aria-controls="collapseOne">
        Choose your services
        <span class="card-btn-toggle">
          <span class="card-btn-toggle-default">
            <i class="tio-add"></i>
          </span>
          <span class="card-btn-toggle-active">
            <i class="tio-remove"></i>
          </span>
        </span>
      </a>

      <div id="collapseOne" class="collapse show" aria-labelledby="headingOne" data-parent="#accordionExample">
        <div class="card-body">
          <form id="services_form" action="{{ baseUrl('services/select-services') }}" method="post">
              @csrf
              <div class="row">
                  @if (count($errors) > 0)
                    <div class="col-md-12">
                       <div class="text-danger">
                          <ul>
                             @foreach ($errors->all() as $error)
                                <li>{{ $error }}</li>
                             @endforeach
                          </ul>
                       </div>
                    </div>
                  @endif
                  <div class="col-md-5 col-sm-5 col-lg-5">
                      <!-- List -->
                      <div class="panel-header">
                        <h4>All Services</h4>
                      </div>
                      @if(count($all_services) > 0)
                      <ul class="list-unstyled all_services">
                        <li>
                          <div class="custom-control custom-checkbox">
                            <input type="checkbox" class="custom-control-input" id="chooseall">
                            <label class="custom-control-label" for="chooseall">Choose All</label>
                          </div>
                        </li>
                        @foreach($all_services as $key => $service)
                        <li>
                          <div class="custom-control custom-checkbox">
                            <input type="checkbox" class="custom-control-input parent_services" value="{{ $service->unique_id }}" name="services[]" id="row-{{$service->unique_id}}">
                            <label class="custom-control-label" for="row-{{$service->unique_id}}">{{$service->name}}</label>
                          </div>
                          
                          @if(count($service->sub_services) > 0)
                            <ul class="sub_services">
                            @foreach($service->sub_services as $key2 => $service2)
                              <li>
                                  <div class="custom-control custom-checkbox">
                                    <input type="checkbox" class="custom-control-input child_services" value="{{ $service2->unique_id }}" name="services[]" id="sub-{{$service2->unique_id}}">
                                    <label class="custom-control-label" for="sub-{{$service2->unique_id}}">{{$service2->name}}</label>
                                  </div>
                              </li>
                            @endforeach
                            </ul>
                          @endif
                        </li>
                        @endforeach
                      </ul>
                      @else
                        <div class="text-danger">
                            No services to choose
                        </div>
                      @endif
                  </div>
                  <div class="col-md-2 col-sm-2 col-lg-2">
                      <div class="select-buttons text-center">
                          <button type="button" class="btn btn-sm btn-primary" onclick="chooseSelected()">
                              Choose Selected
                          </button>
                      </div>
                  </div>
                  <div class="col-md-5 col-sm-5 col-lg-5">
                    <div class="panel-header">
                      <h4>My Services</h4>
                    </div>
                    <ul class="list-inline list-separator selected_services">
                      @if(!empty($my_services))
                        @foreach($my_services as $service)
                          @if(!empty($service->Service($service->service_id)))
                            <li class="list-inline-item">{{$service->Service($service->service_id)->name}}</li>
                          @endif
                        @endforeach
                      @else
                        <div class="text-danger">
                            No services selected
                        </div>
                      @endif
                    </ul>
                  </div>
              </div>
          </form>
        </div>
      </div>
    </div>
  </div>
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
              <input id="datatableSearch" type="search" class="form-control" placeholder="Search services" aria-label="Search services">
            </div>
            <!-- End Search -->
          </form>
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
                <a class="btn btn-sm btn-outline-danger" data-href="{{ baseUrl('services/delete-multiple') }}" onclick="deleteMultiple(this)" href="javascript:;">
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
      <table id="tableList" class="table table-lg table-borderless table-thead-bordered table-nowrap table-align-middle card-table">
        <thead class="thead-light">
          <tr>
            <th scope="col" class="table-column-pr-0">
              <div class="custom-control custom-checkbox">
                <input id="datatableCheckAll" type="checkbox" class="custom-control-input">
                <label class="custom-control-label" for="datatableCheckAll"></label>
              </div>
            </th>
            <th scope="col" >Service</th>
            <th scope="col">Price</th>
            <th scope="col"></th>
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
<link rel="stylesheet" href="assets/vendor/jquery-ui/jquery-ui.css">
<script src="assets/vendor/jquery-ui/jquery-ui.js"></script>
<script type="text/javascript">
$(document).ready(function(){
  $('.js-toggle-switch').each(function () {
    var toggleSwitch = new HSToggleSwitch($(this)).init();
  });
  
  $(".parent_services").change(function(){
    if($(this).is(":checked")){
      $(this).parents("li").find(".child_services").prop("checked",true);
    }else{
      $(this).parents("li").find(".child_services").prop("checked",false);
    }
  });
  $("#chooseall").change(function(){
    if($(this).is(":checked")){
       $(".all_services input[type=checkbox]").prop("checked",true);
    }else{
       $(".all_services input[type=checkbox]").prop("checked",false);
    }
  });

})
loadData();
function loadData(page=1){
    $.ajax({
        type: "POST",
        url: BASEURL + '/services/ajax-list?page='+page,
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
    });
}

function chooseSelected(){
  if($(".all_services input[type=checkbox]:checked").length > 0){
    $("#services_form").submit();
  }else{
    errorMessage("Please select services!");
  }
}

</script>
@endsection