<?php $cnt = 0; ?>
@if(!empty($records))    
    @foreach($records as $key=>$prof)
    
     <?php
          // $professionalAdmin = professionalAdmin($prof->subdomain);

          // $company_data = professionalDetail($prof->subdomain);
          //if(!empty($company_data)){
        ?>
    
    <div class="card card-bordered custom-content-card mt-1 p-5">
      <div class="col-md-12">
        <div class="row">
          <div class="col-md-2 text-center">
            <img class="img-fluid w-100 rounded-lg" src="{{professionalLogo('m','fastzone')}}" alt="Image Description">
             <span class="text-center mt-2"><b>{{ucwords($prof->company_name)}}</b></span> 
            
          </div>
          <div class="col-md-9 pl-5">

            <h3>
              <img class="verified-badge" src="./assets/svg/illustrations/top-vendor.svg" alt="Image Description" data-toggle="tooltip" data-placement="top" title="" data-original-title="Verified user" aria-describedby="tooltip851946">
              {{$prof->company_name}}
            </h3>
            <h5>
                <b><i class="tio-user nav-icon"></i> Owner:</b>{{$prof->user_details->first_name." ".$prof->user_details->last_name}}</h5>
              <div class="row">
                <div class="col-6">
                  <i class="tio-map nav-icon"></i> {{getStateName($prof->state_id)}},{{ getCountryName($prof->country_id)}}
                  <br>
                  
                  <i class="tio-chat nav-icon"></i> 
                  <?php 
                  // pre($prof); 
                  ?>

                  <?php
                  $user_detail = $prof->user_details;
                  if(!empty($user_detail->languages_known)){
                      $languages_known = json_decode($user_detail->languages_known,true);
                      $lngs = array();
                      foreach ($languages_known as $key => $lb) {
                        $languages = getLanguageName($lb);
                        $lngs[] = $languages;
                      }
                      echo implode(",",$lngs);
                  }
                   ?>

                  
                  
                </div>
                <div class="col-6">
                  <i class="tio-documents nav-icon"></i> RIC ID - unknown
                  <br>
                  <i class="tio-call nav-icon"></i> {{$prof->country_code}} {{$prof->phone_no}}

                </div>

              </div>
              <br>

              
              <a href="{{url('professional/'.$subdomains[$cnt])}}" class="btn btn-primary">More Details</a>
              
              <?php ++$cnt; ?>

          </div>
        </div>
      </div>
    </div>

    
    @endforeach
@else
<div class="col-md-12 text-center">
  No data available
</div>
@endif