@extends('layouts.master-old')
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
<!-- Content -->
<div class="professionals">
  <!-- Page Header -->
  <div class="page-header">
    <div class="row align-items-end">
      <div class="col-sm-6 mb-2 mb-sm-0">
        <nav aria-label="breadcrumb">
          <ol class="breadcrumb breadcrumb-no-gutter">
            <li class="breadcrumb-item"><a class="breadcrumb-link" href="{{ baseUrl('/') }}">Dashboard</a></li>
            <li class="breadcrumb-item"><a class="breadcrumb-link" href="{{ baseUrl('/professionals') }}">Professionals</a></li>
            <li class="breadcrumb-item active" aria-current="page">Overview</li>
          </ol>
        </nav>
        <h1 class="page-title">{{$pageTitle}}</h1>
      </div>
      <div class="col-sm-6 mb-2 mb-sm-0">
        <!-- <div class="update_db_btn text-right">
          <button type="button" onclick="showPopup('<?php echo baseUrl('professionals/update-all-databases') ?>')" class="btn btn-primary"><i class="fa fa-database"></i> Update All Database</button>
        </div> -->
      </div>

      <div class="col-sm-auto">
        <!-- <a class="btn btn-primary" href="users-add-user.html">
          <i class="tio-user-add mr-1"></i> Add user
        </a> -->
      </div>
    </div>
    <!-- End Row -->
  </div>
  <!-- End Page Header -->

  <!-- Stats -->
  @include(roleFolder().".professionals.professional_count")
  <!-- End Stats -->

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
              <input id="datatableSearch" type="search" class="form-control" placeholder="Search users" aria-label="Search users">
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
                <!-- <a class="btn btn-sm btn-outline-danger" href="javascript:;">
                  <i class="tio-delete-outlined"></i> Delete
                </a> -->
                <a class="btn btn-sm btn-outline-primary ml-2" onclick="updateDatabase()" href="javascript:;">
                  <i class="tio-category-outlined"></i> Update Database
                </a>
              </div>
            </div>
            <a class="btn btn-sm btn-primary ml-2" onclick="updateMainDatabase()" href="javascript:;">
              <i class="tio-category-outlined"></i> Update Main Database
            </a>
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
            <th class="table-column-pr-0">
              <div class="custom-control custom-checkbox">
                <input id="datatableCheckAll" type="checkbox" class="custom-control-input">
                <label class="custom-control-label" for="datatableCheckAll"></label>
              </div>
            </th>
            <th class="table-column-pl-0">Name</th>
            <th>Subdomain Handler</th>
            <th>Contact Number</th>
            <th>Panel Status</th>
            <!-- <th>Profile status</th> -->
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
<div class="modal fade" id="showUpgrade" data-backdrop="static" tabindex="-1" role="dialog" aria-labelledby="staticBackdropLabel" aria-hidden="true">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="staticBackdropLabel">Database Upgrade</h5>
        <button type="button" class="btn btn-xs btn-icon btn-ghost-secondary" data-dismiss="modal" aria-label="Close">
          <i class="tio-clear tio-lg"></i>
        </button>
      </div>
      <div class="modal-body">
        <table class="table table-bordered">
          <thead>
            <tr>
              <th>Database</th>
              <th>Status</th>
            </tr>
          </thead>
          <tbody>
          </tbody>
          <tfoot></tfoot>
        </table>
      </div>
      <div class="modal-footer">
        <!-- <button type="button" class="btn btn-white" data-dismiss="modal">Close</button>
        <button type="button" class="btn btn-primary">Understood</button> -->
      </div>
    </div>
  </div>
</div>
@endsection

@section('javascript')
<script src="assets/vendor/hs-toggle-switch/dist/hs-toggle-switch.min.js"></script>
<script type="text/javascript">
$(document).ready(function(){
  $('.js-toggle-switch').each(function () {
    var toggleSwitch = new HSToggleSwitch($(this)).init();
  });
  $(".next").click(function(){
    if(!$(this).hasClass('disabled')){
      changePage('next');
    }
  });
  $(".previous").click(function(){
    if(!$(this).hasClass('disabled')){
      changePage('prev');
    }
  });
  
  $("#datatableCheckAll").change(function(){
    if($(this).is(":checked")){
      $(".row-checkbox").prop("checked",true);
    }else{
      $(".row-checkbox").prop("checked",false);
    }
    if($(".row-checkbox:checked").length > 0){
      $("#datatableCounterInfo").show();
    }else{
      $("#datatableCounterInfo").hide();
    }
    $("#datatableCounter").html($(".row-checkbox:checked").length);
  });
})
loadData();
function loadData(page=1){
    $.ajax({
        type: "POST",
        url: BASEURL + '/professionals/ajax-active?page='+page,
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
            
            if(data.total_records > 0){
              var pageinfo = data.current_page+" of "+data.last_page+" <small class='text-danger'>("+data.total_records+" records)</small>";
              $("#pageinfo").html(pageinfo);
              $("#pageno").val(data.current_page);
              if(data.current_page < data.last_page){
                $(".next").removeClass("disabled");
              }else{
                $(".next").addClass("disabled","disabled");
              }
              if(data.current_page > 1){
                $(".previous").removeClass("disabled");
              }else{
                $(".previous").addClass("disabled","disabled");
              }
              $("#pageno").attr("max",data.last_page);
              initCheckbox();
            }else{
              $(".datatable-custom").find(".norecord").remove();
              var html = '<div class="text-center text-danger norecord">No records available</div>';
              $(".datatable-custom").append(html);
            }
        },
    });
}
function initCheckbox(){
  $(".row-checkbox").change(function(){
    
    if($(".row-checkbox:checked").length > 0){
      $("#datatableCounterInfo").show();
    }else{
      $("#datatableCounterInfo").hide();
    }
    $("#datatableCounter").html($(".row-checkbox:checked").length);
  });
}
function changePage(action){
  var page = parseInt($("#pageno").val());
  if(action == 'prev'){
    page--;
  }
  if(action == 'next'){
    page++;
  }
  if(!isNaN(page)){
    loadData(page);
  }else{
    errorMessage("Invalid Page Number");
  }
  
}
function confirmDelete(id){
    Swal.fire({
      title: 'Are you sure?',
      text: "You won't be able to revert this!",
      type: 'warning',
      showCancelButton: true,
      confirmButtonColor: '#3085d6',
      cancelButtonColor: '#d33',
      confirmButtonText: 'Yes, delete it!',
      confirmButtonClass: 'btn btn-primary',
      cancelButtonClass: 'btn btn-danger ml-1',
      buttonsStyling: false,
    }).then(function(result) {
      if (result.value) {
        $.ajax({
            type: "POST",
            url: BASEURL + '/professionals/delete-user',
            data:{
                _token:csrf_token,
                user_id:id,
            },
            dataType:'json',
            success: function (result) {
                if(result.status == true){
                    Swal.fire({
                        type: "success",
                        title: 'Deleted!',
                        text: 'Your file has been deleted.',
                        confirmButtonClass: 'btn btn-success',
                    }).then(function () {

                        window.location.href= result.redirect;
                    });
                }else{
                    Swal.fire({
                        title: "Error!",
                        text: "Error while deleting",
                        type: "error",
                        confirmButtonClass: 'btn btn-primary',
                        buttonsStyling: false,
                    });
                }
            },
        });
      }
    })
}

function changeStatus(e){
  var id = $(e).attr("data-id");
  if($(e).is(":checked")){
    $.ajax({
        type: "POST",
        url: BASEURL + '/professionals/status/active',
        data:{
            _token:csrf_token,
            id:id,
        },
        dataType:'json',
        success: function (result) {
            if(result.status == true){
                successMessage(result.message);
                loadData();
            }else{
                errorMessage(result.message);
            }
        },
    });
  }else{
    $.ajax({
        type: "POST",
        url: BASEURL + '/professionals/status/inactive',
        data:{
            _token:csrf_token,
            id:id,
        },
        dataType:'json',
        success: function (result) {
            if(result.status == true){
                successMessage(result.message);
                loadData();
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

function profileStatus(e){
  var id = $(e).attr("data-id");
  if($(e).is(":checked")){
    $.ajax({
        type: "POST",
        url: BASEURL + '/professionals/profile-status/active',
        data:{
            _token:csrf_token,
            id:id,
        },
        dataType:'json',
        success: function (result) {
            if(result.status == true){
                successMessage(result.message);
            }else{
                errorMessage(result.message);
            }
        },
    });
  }else{
    $.ajax({
        type: "POST",
        url: BASEURL + '/professionals/profile-status/inactive',
        data:{
            _token:csrf_token,
            id:id,
        },
        dataType:'json',
        success: function (result) {
            if(result.status == true){
                successMessage(result.message);
                loadData();
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

function updateAllDatabase(e){
  var url = $(e).attr("data-href");
  Swal.fire({
      title: 'Are you sure to delete?',
      text: "You won't be able to revert this!",
      type: 'warning',
      showCancelButton: true,
      confirmButtonColor: '#3085d6',
      cancelButtonColor: '#d33',
      confirmButtonText: 'Yes',
      confirmButtonClass: 'btn btn-primary',
      cancelButtonClass: 'btn btn-danger ml-1',
      buttonsStyling: false,
    }).then(function(result) {
      if(result.value){
        redirect(url);
      }
    })
}
var database = [];
function updateDatabase(dbname='',index=''){
  database = [];
  if($(".row-checkbox:checked").length > 0){
    $(".row-checkbox:checked").each(function(){
      database.push($(this).attr("data-subdomain"));
    });
    $("#showUpgrade").modal("show");
    $("#showUpgrade table tbody").html('');
    $("#showUpgrade tfoot").html("<tr><td colspan='2'><div class='alert alert-warning'>Upgrade is under process please wait until it get completed....</div></td></tr>");
    upgradeDB(database[0],0);
  }else{
    errorMessage("Please select the record");
  }
}
function updateMainDatabase(){
  $("#showUpgrade").modal("show");
  $("#showUpgrade table tbody").html('');
  $("#showUpgrade tfoot").html("<tr><td colspan='2'><div class='alert alert-warning'>Upgrade is under process please wait until it get completed....</div></td></tr>");
  $.ajax({
      type: "POST",
      url: SITEURL + '/replicate-db.php',
      dataType:'json',
      beforeSend:function(){
      },
      success: function (data) {
        $("#showUpgrade table tbody").append(data.html);
        $("#showUpgrade tfoot").html("<tr><td colspan='2'><div  class='alert alert-success'>All database are upgrade</div></td></tr>");
         
      },
  });
}
function upgradeDB(dbname,index){
  $.ajax({
      type: "POST",
      url: SITEURL + '/replicate-prof-db.php',
      data:{
        db:dbname
      },
      dataType:'json',
      beforeSend:function(){
        // showLoader();
        // var html = "<tr class='sub-"+dbname+"'><td>"+dbname+"</td>";
        // html +="<td class='status'><i class='fa fa-spinner fa-spin fa-2x'></i></td></tr>";
        // $("#showUpgrade table tbody").append(html);
      },
      success: function (data) {
        //  hideLoader();
        //  $(".sub-"+dbname).find(".status").html(data.html);
         $("#showUpgrade table tbody").append(data.html);
         if(index < (database.length - 1)){
          var next_index = index + 1;
          upgradeDB(database[next_index],next_index);
         }else{
          $("#showUpgrade tfoot").html("<tr><td colspan='2'><div  class='alert alert-success'>All database are upgrade</div></td></tr>");
          // setTimeout(function(){
          //   $("#showUpgrade").modal("hide");
          //   $("#showUpgrade table tbody").html('');
          // },2000);
         }
      },
  });
}
</script>
@endsection