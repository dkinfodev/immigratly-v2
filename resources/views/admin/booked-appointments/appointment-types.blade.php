<div class="col-md-6 mb-3">
    <h4>Select Appointment Duration</h4>
</div>
<div class="col-md-6 mb-3">
    <div class="float-right">
        <div class="custom-control custom-checkbox">
            <input type="checkbox" id="nocharge" class="custom-control-input" name="nocharge" value="0">
            <label class="custom-control-label" for="nocharge">No Charge for Appointment</label>
        </div>
    </div>
</div>
@foreach($appointment_types as $key => $type)
@if(isset($type['service_prices']) && !empty($type['service_prices']))
<div class="col-sm-4 appointment_types">
    <div class="card text-center">
        <div class="card-body p-2">
            <h3>{{$type['name']}}</h3>
        
            <h4>{{$type['time_duration']['name']}}</h4>
            <h5 class="text-danger">
            @if($type['service_prices']['price'] != 0)
                {{currencyFormat($type['service_prices']['price'])}}
            @else
                Free
                @endif
            </h5>
        </div>
        <div class="card-footer p-2">
            <div class="form-group">
            <!-- Checkbox -->
                <div class="custom-control custom-radio">
                    <input type="radio" id="customRadio-{{$key}}" class="custom-control-input" onchange="selectDuration(this)" name="appointment_type" value="{{$type['unique_id']}}">
                    <label class="custom-control-label" for="customRadio-{{$key}}">Select Type</label>
                </div>
                <input type="radio" style="display:none" name="break_time" class="break_time" value="{{$type['time_duration']['break_time'] }}" />
                <input type="radio" style="display:none" name="price" class="price" value="{{$type['service_prices']['price'] }}" />
                <!-- End Checkbox -->
            </div>
        </div>
    </div>
</div>
@endif
@endforeach