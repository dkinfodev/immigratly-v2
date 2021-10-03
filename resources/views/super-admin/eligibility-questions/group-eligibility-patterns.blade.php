@extends('layouts.master')

@section('content')
<style>
.sortable {
    list-style: none;
    margin: 0px;
    padding: 0px;
}

.sortable li {
    margin: 12px;
    border-radius: 7px;
}
</style>
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
                        <li class="breadcrumb-item"><a class="breadcrumb-link"
                                href="{{ baseUrl('/visa-services') }}">Visa Services</a></li>
                        <li class="breadcrumb-item active" aria-current="page">{{$pageTitle}}</li>
                    </ol>
                </nav>

                <h1 class="page-title">{{$pageTitle}}</h1>
            </div>

            <div class="col-sm-auto">

                <a class="btn btn-primary btn-sm"
                    href="{{ baseUrl('/visa-services/eligibility-questions/'.base64_encode($visa_service->id)) }}">
                    Back
                </a>

            </div>
        </div>
        <!-- End Row -->
    </div>
    <!-- Card -->
    <div class="card">
        @if(count($records) > 0)
        <!-- Table -->
        <div class="table-responsive datatable-custom">
            <table class="table table-bordered">
                <thead>
                    <tr>
                        <th>Visa Service</th>
                        <th>Action</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($records as $record)
                        <tr>
                            <td>{{$record->SubVisaService->name}}</td>
                            <td>
                                <a href="{{ baseUrl('visa-services/eligibility-questions/'.base64_encode($visa_service->id)) }}/eligibility-pattern/edit/{{ base64_encode($record->id) }}" class="btn btn-warning btn-sm"><i class="tio-edit"></i></a>
                                <a class="btn btn-danger btn-sm" href="javascript:;" onclick="confirmAction(this)" data-href="{{baseUrl('visa-services/eligibility-questions/'.base64_encode($visa_service->id).'/eligibility-pattern/delete/'.base64_encode($record->id))}}"><i class="tio-delete"></i></a> 
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
        <!-- End Table -->
        <div class="pagination">
            {{$records->links()}}
        </div>
        @else
        <div class="text-center text-danger p-3">
            No records available
        </div>
        @endif
    </div>
    <!-- End Card -->
</div>
<!-- End Content -->
@endsection

@section('javascript')
<script>

</script>
@endsection