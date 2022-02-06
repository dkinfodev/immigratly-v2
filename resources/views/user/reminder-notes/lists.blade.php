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
<!-- Content -->
<div class="reminder-notes">
  

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
              <input id="datatableSearch" type="search" class="form-control" placeholder="Search Note" aria-label="Search Note">
            </div>
            <!-- End Search -->
          </form>
        </div>

        <div class="col-sm-5">
          <div class="d-sm-flex justify-content-sm-end align-items-sm-center">
            <!-- Datatable Info -->
            <div id="datatableCounterInfo" class="mr-2 mb-2 mb-sm-0" style="display: none;">
              <div class="d-flex align-items-center">
                <span class="font-size-sm mr-3">
                  <span id="datatableCounter">0</span>
                  Selected
                </span>
                <a class="btn btn-sm btn-outline-danger" data-href="{{ baseUrl('dependants/delete-multiple') }}" onclick="deleteMultiple(this)" href="javascript:;">
                  <i class="tio-delete-outlined"></i> Delete
                </a>
              </div>
            </div>
          </div>
        </div>

        <div class="col-sm-2">
          <a class="btn btn-primary" onclick="showPopup('<?php echo baseUrl('/notes/add-reminder-note') ?>')">
          Add Note
          </a>
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
            <th scope="col" class="table-column-pr-0">
              <div class="custom-control custom-checkbox">
                <input id="datatableCheckAll" type="checkbox" class="custom-control-input">
                <label class="custom-control-label" for="datatableCheckAll"></label>
              </div>
            </th>
            <th>Reminder Date</th>
            <th scope="col" class="table-column-pl-0">Message</th>
            <th></th>
          </tr>
        </thead>

        <tbody>
          <?php
          foreach($records as $key  => $record){
          ?>
            <tr>
            <td class="table-column-pr-0">
              <div class="custom-control custom-checkbox">
                <input type="checkbox" class="custom-control-input row-checkbox" value="{{ base64_encode($record->id) }}" id="row-{{$key}}">
                <label class="custom-control-label" for="row-{{$key}}"></label>
              </div>
             </td>
              <td>{{dateFormat($record->reminder_date)}}</td>
              <td>{{$record->message}}</td>
              <td>
                <a href="javascript:;" onclick="showPopup('<?php echo baseUrl('notes/edit-reminder-note/'.base64_encode($record->id)) ?>')" class="btn btn-warning btn-sm"><i class="tio-edit"></i></a>
                <a  href="javascript:;" onclick="confirmAction(this)" data-href="{{baseUrl('notes/delete/'.base64_encode($record->id))}}" class="btn btn-danger btn-sm"><i class="tio-delete"></i></a>
              </td>
            </tr>
          <?php
          }
          ?>
        </tbody>
      </table>
  
    </div>
  </div>

  <!-- End Table -->

  <!-- Footer -->
  <div class="card-footer">
    <!-- Pagination -->
    <div class="d-flex justify-content-center justify-content-sm-end">
      <nav id="datatablePagination" aria-label="Activity pagination"></nav>
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
<script src="assets/vendor/datatables/media/js/jquery.dataTables.min.js"></script>
<script>
  $('.js-nav-tooltip-link').tooltip({ boundary: 'window' });
  $(document).on('ready', function () {
    
    $('.js-hs-action').each(function () {
      var unfold = new HSUnfold($(this)).init();
    });
    // initialization of datatables
    var datatable = $.HSCore.components.HSDatatables.init($('#datatable'));
  });
</script>
@endsection