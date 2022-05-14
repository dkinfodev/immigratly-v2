@extends('layouts.master')

@section('breadcrumb')
<!-- Content -->
<ol class="breadcrumb breadcrumb-no-gutter">
  <li class="breadcrumb-item"><a class="breadcrumb-link" href="{{ baseUrl('/') }}">Dashboard</a></li>
  <li class="breadcrumb-item"><a class="breadcrumb-link" href="{{ baseUrl('/booked-appointments') }}">Appointments</a></li>
  <li class="breadcrumb-item active" aria-current="page">{{$pageTitle}}</li>
</ol>
<!-- End Content -->
@endsection

@section('content')

  <div class="card mb-3 mb-lg-5">
    <!-- Header -->
    <div class="card-header">
      <div class="float-left">
        <h6 class="card-subtitle mb-0">
          Appointment for {{$service->visa_service->name}} dated on {{dateFormat($appointment->appointment_date)}}
            <div class="mt-2">
              <!-- <span class="text-danger"><b>Duration:</b>{{$appointment->meeting_duration}} Minutes</span>
              <span class="text-danger"> | <b>Time:</b>{{$appointment->start_time}} to {{$appointment->end_time}}</span> -->
              <div class="d-block text-danger">ID: {{$appointment->unique_id}}</div>
            </div>
        </h6>
      </div>
      <div class="float-right">
          
          <a href="{{ baseUrl('booked-appointments') }}" class="btn btn-primary btn-sm">Back</a>
      </div>
    </div>
    <div class="card-body">
        <table class="table table-bordered">
          <tr>
              <th>Professional</th>
              <td>
                {{$company_data->company_name}}
              </td>
          </tr>
          <tr>
              <th>Location</th>
              <td>
                {{$professional_location->address}}
              </td>
          </tr>
          <tr>
              <th>Appointment Date</th>
              <td>
                {{dateFormat($appointment->appointment_date)}}
              </td>
          </tr>
          <tr>
              <th>Appointment Time</th>
              <td>
                {{dateFormat($appointment->start_time,"h:i A")." to ".dateFormat($appointment->end_time,"h:i A")}}
              </td>
          </tr>
          <tr>
              <th>Duration</th>
              <td>
                {{$appointment->meeting_duration}} Minutes
              </td>
          </tr>
          <tr>
              <th>Visa Service</th>
              <td>
              {{$service->visa_service->name}}
              </td>
          </tr>
          <tr>
              <th>Status</th>
              <td>
              @if($appointment->status == 'awaiting')
                <span class="badge badge-warning">{{$appointment->status}}</span>
                @elseif($appointment->status == 'approved')
                <span class="badge badge-success">{{$appointment->status}}</span>
                @else
                <span class="badge badge-danger">{{$appointment->status}}</span>
                @endif
              </td>
          </tr>
          <tr>
              <th>Payment Status</th>
              <td>
                @if($appointment->payment_status != 'paid')
                  <span class="badge badge-danger">{{$appointment->payment_status}}</span>
                @else
                  @if($appointment->price != 0)
                    <span class="badge badge-success">{{$appointment->payment_status}}</span>
                  @else
                    <span class="badge badge-info">Free</span>
                  @endif
                @endif
              </td>
          </tr>
        </table>
    </div>
    <!-- End Body -->
  </div>
  <!-- End Card -->

  <!-- End Row -->

@endsection

@section('javascript')
<script type="text/javascript">

</script>

@endsection