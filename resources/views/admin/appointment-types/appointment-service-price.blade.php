@extends('layouts.master')

@section('breadcrumb')
<!-- Content -->
<ol class="breadcrumb breadcrumb-no-gutter">
  <li class="breadcrumb-item"><a class="breadcrumb-link" href="{{ baseUrl('/') }}">Dashboard</a></li>
  <li class="breadcrumb-item"><a class="breadcrumb-link" href="{{ baseUrl('/appointment-types') }}">Appointment Types</a></li>
  <li class="breadcrumb-item active" aria-current="page">{{$pageTitle}}</li>
</ol>
<!-- End Content -->
@endsection

@section('header-right')
<a class="btn btn-primary" href="{{ baseUrl('/appointment-types') }}">
    <i class="tio mr-1"></i> Back
</a>
@endsection

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
<style>
#form .table th, #form .table td {
    vertical-align: middle;
}
</style>
<!-- Content -->
<div class="appointment-types">

    <!-- Card -->
    <div class="card">
        <div class="card-header pl-5 pt-3 p-0 pr-5">
            <h4 class="card-title m-0 float-left">Set Price for {{$appointment_type->name}} Appointment Type</h4>
            <div class="float-right">
                <div class="custom-control custom-checkbox">
                    <input id="set_all_free" type="checkbox" class="custom-control-input">
                    <label class="custom-control-label" for="set_all_free">Set all as free</label>
                    
                </div>
            </div>
        </div>
        <div class="card-body">
            <form id="form" class="js-validate" action="{{ baseUrl('appointment-types/service-price/'.$appointment_type->unique_id) }}" method="post">
                @csrf
                <table class="table table-bordered">
                    <thead class="thead-light">
                        <tr>
                            <th scope="col" class="table-column-pr-0 text-center">
                                <div class="custom-control custom-checkbox">
                                    <input id="datatableCheckAll" type="checkbox" class="custom-control-input">
                                    <label class="custom-control-label" for="datatableCheckAll"></label>
                                </div>
                            </th>
                            <th scope="col">Service Name</th>
                            <th scope="col">Price</th>
                        </tr>
                    </thead>
                    <tbody>
                    @if(!empty($services))
                        @foreach($services as $service)
                          @if(!empty($service->Service($service->service_id)))
                            <tr>
                                <th scope="col" class="table-column-pr-0 text-center">
                                    <div class="custom-control custom-checkbox">
                                        <input id="checkbox-{{$service->id}}" {{isset($service_prices[$service->unique_id])?'checked':''}} type="checkbox" class="custom-control-input service-chk">
                                        <label class="custom-control-label" for="checkbox-{{$service->id}}"></label>
                                    </div>
                                </th>
                                <td>
                                    {{$service->Service($service->service_id)->name}}
                                </td>
                                <td>
                                    <input type="number" required name="service_price[{{ $service->unique_id }}]" class="form-control service-input" value="{{isset($service_prices[$service->unique_id])?$service_prices[$service->unique_id]:''}}" placeholder="Enter Service Price"  {{!isset($service_prices[$service->unique_id])?'disabled':''}} />
                                </td>
                            </tr>
                          @endif
                          @endforeach
                        @endif
                    </tbody>
                </table>
                <div class="form-group mt-3 text-center">
                    <button type="submit" class="btn add-btn btn-primary">Save</button>
                </div>
                <!-- End Input Group -->

        </div><!-- End Card body-->
    </div>
    <!-- End Card -->
</div>
<!-- End Content -->
@endsection

@section('javascript')

<script>
$(document).ready(function(){
    $("#set_all_free").change(function(){
        if($(this).is(":checked")){
            $(".service-chk").prop("checked",true);
            $(".service-input").removeAttr("disabled");
            $(".service-input").val(0);
        }  
    })
    $("#datatableCheckAll").change(function(){
        if($(this).is(":checked")){
            $(".service-chk").prop("checked",true);
            $(".service-input").removeAttr("disabled");
        }else{
            $(".service-chk").prop("checked",false);
            $(".service-input").attr("disabled","disabled");
        }        
    });

    $(".service-chk").change(function(){
        if($(this).is(":checked")){
            $(this).parents("tr").find(".service-input").removeAttr("disabled");
        }else{
            $(this).parents("tr").find(".service-input").attr("disabled","disabled");
        }      
    });

    $("#form").submit(function(e) {
        e.preventDefault();
        var formData = new FormData($(this)[0]);
        var url = $("#form").attr('action');
        $.ajax({
            url: url,
            type: "post",
            data: formData,
            cache: false,
            contentType: false,
            processData: false,
            dataType: "json",
            beforeSend: function() {
                showLoader();
            },
            success: function(response) {
                hideLoader();
                if (response.status == true) {
                    successMessage(response.message);
                    redirect(response.redirect_back);
                } else {
                    errorMessage(response.message);
                }
            },
            error: function() {
                internalError();
            }
        });

    });

})

</script>

@endsection