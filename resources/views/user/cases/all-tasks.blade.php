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
                        <li class="breadcrumb-item"><a class="breadcrumb-link" href="{{ baseUrl('/') }}">Dashboard</a>
                        </li>
                        <li class="breadcrumb-item active" aria-current="page">{{$pageTitle}}</li>
                    </ol>
                </nav>

                <h1 class="page-title">{{$pageTitle}}</h1>
            </div>

            <!-- <div class="col-sm-auto">
        <a class="btn btn-primary" href="<?php echo baseUrl('cases/add') ?>">
          <i class="tio-user-add mr-1"></i> Create Case
        </a>
      </div> -->
        </div>
        <!-- End Row -->
    </div>
    <!-- End Page Header -->

    <!-- Card -->
    <div class="card">
        <div class="card-header">
            <h4 class="card-header-title">List of Task</h4>
        </div>

        <!-- Table -->
        <div class="table-responsive datatable-custom">
            <table id="datatable"
                class="table table-borderless table-thead-bordered table-nowrap table-align-middle card-table"
                data-hs-datatables-options='{
             "order": [],
             "isResponsive": false,
             "isShowPaging": false,
             "ordering:"false,
             "pagination": "datatablePagination",
             }'>
                <thead class="thead-light">
                    <tr>
                        <th scope="col">Professional</th>
                        <th scope="col">Case</th>
                        <th scope="col">Task Title</th>
                        <th scope="col">Task Status</th>
                        <th scope="col">Created Date</th>
                        <th scope="col"></th>
                    </tr>
                </thead>

                <tbody>
                    @if(count($records) > 0)
                    @foreach($records as $key => $record)
                    <tr>
                        <td>
                            <?php
                    $company_details = professionalDetail($record['professional']);
                    $subdomain = $record['professional'];
                    echo $company_details->company_name;
                ?>
                        </td>
                        <td>{{$record['case']['case_title'] }}</td>
                        <td>
                            {{$record['task_title']}}
                        </td>
                        <td>
                            @if($record['status'] == 'pending')
                            <span class="badge badge-soft-warning p-2">Pending</span>
                            @else
                            <span class="badge badge-soft-success p-2">Completed</span>
                            @endif
                        </td>

                        <td>
                            <a class="text-secondary"
                                href="{{baseUrl('cases/'.$subdomain.'/tasks/view/'.$record['unique_id'])}}">
                                <i class="fa fa-eye"></i>
                                View Task
                            </a>
                        </td>
                    </tr>
                    @endforeach
                    @else
                    <tr>
                        <td colspan="5" class="text-center text-danger">No pending tasks</td>
                    </tr>
                    @endif
                </tbody>
            </table>
        </div>
        <!-- End Table -->

        <!-- Footer -->
        <div class="card-footer">
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
$('.js-nav-tooltip-link').tooltip({
    boundary: 'window'
});
$(document).on('ready', function() {

    $('.js-hs-action').each(function() {
        var unfold = new HSUnfold($(this)).init();
    });
    // initialization of datatables
    var datatable = $.HSCore.components.HSDatatables.init($('#datatable'));
});
</script>
@endsection