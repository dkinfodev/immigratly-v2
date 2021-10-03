<div class="row  js-form-message">
    <div class="col-md-12 mb-3">
        <h3>Select Professional to assign assessment:</h3>
    </div>
  
    @foreach($professionals as $key=>$prof)
    <?php 
            $check_service = professionalService($prof->subdomain,$visa_service_id);
            $company_data = professionalDetail($prof->subdomain);
          ?>
    @if(!empty($check_service))
    @if(!empty($company_data))
    <div class="col-md-3">
        <div class="card mb-4 professional-card">
            <div class="card-image">
                <img class="img-fluid w-100 rounded-lg" src="{{professionalLogo('m',$prof->subdomain)}}"
                    alt="Image Description">
            </div>
            <div class="card-footer text-center">
                <div class="custom-control custom-radio">
                    <input type="radio" {{$professional == $prof->subdomain?'checked':''}} value="{{$prof->subdomain}}" id="customRadio-{{$key}}" class="custom-control-input"
                        name="professional">
                    <label class="custom-control-label" for="customRadio-{{$key}}">
                        <h3>{{ $company_data->company_name }}</h3>
                    </label>
                </div>
            </div>
        </div>
    </div>
    @endif
    @endif
    @endforeach
</div>