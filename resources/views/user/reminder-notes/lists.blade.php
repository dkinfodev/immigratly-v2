@extends('layouts.master')

@section('content')
<!-- Content -->
<div class="content container-fluid">
  <!-- Page Header -->
  <div class="page-header">
    <div class="row align-items-end">
      <div class="col-sm mb-2 mb-sm-0">
        <nav aria-label="breadcrumb">
          <ol class="breadcrumb breadcrumb-no-gutter">
            <li class="breadcrumb-item"><a class="breadcrumb-link" href="{{ baseUrl('/') }}">Dashboard</a></li>
            <li class="breadcrumb-item active" aria-current="page">{{$pageTitle}}</li>
          </ol>
        </nav>

        <h1 class="page-title">{{$pageTitle}}</h1>
      </div>

      <div class="col-sm-auto">
        <a class="btn btn-primary" onclick="showPopup('<?php echo baseUrl('/notes/add-reminder-note') ?>')">
          Add Note
        </a>
      </div>
    </div>
    <!-- End Row -->
  </div>
  <!-- End Page Header -->

  <!-- Card -->
<div class="card">
  <div class="card-header">
    <h4 class="card-header-title">Cases with Professional</h4>
  </div>

  <!-- Table -->
  <div class="table-responsive datatable-custom">
    <table id="datatable" class="table table-borderless table-thead-bordered table-nowrap table-align-middle card-table"
           data-hs-datatables-options='{
             "order": [],
             "isResponsive": false,
             "isShowPaging": false,
             "pagination": "datatablePagination"
           }'>
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
              <a  href="javascript:;" onclick="confirmAction(this)" data-href="{{baseUrl('notes/delete/'.base64_encode($record->id))}}"class="btn btn-danger btn-sm"><i class="tio-delete"></i></a>
            </td>
          </tr>
        <?php
        }
        ?>
      </tbody>
    </table>
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