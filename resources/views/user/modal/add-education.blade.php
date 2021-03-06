<style>


span.select2-selection.select2-selection--multiple.custom-select {
    height: auto !important;
    padding-bottom: 10px !important;
}

.custom-select {
  background-color: #fff;
}

/*.form-label {
    color: #304e95;
    font-weight: 600;
}*/

</style>

@php
$start_year = date("Y");
$end_year = date("Y") - 20;
@endphp
<div class="modal-dialog modal-lg" role="document">
  <div class="modal-content">
    <div class="modal-header">
        <div class="imm-modal-slanted-div angled lower-start">
          <div class="row">
            <div class="col-10">
              <h3 class="modal-title" id="exampleModalLongTitle">{{$pageTitle}}</h3>
            </div>
           <div class="col-2" style="text-align:right"> 
              <button type="button" class="btn-close" data-dismiss="modal" aria-label="Close"></button>
            </div>
          </div>
        </div>
    </div>
    <div class="modal-body imm-education-modal-body">
      <form method="post" id="popup-form"  action="{{ baseUrl('/educations/add') }}">
          @csrf
          <div class="imm-education-add-inner">
            <div class="col-12">
              <!-- Form -->
              <div class="mb-4 js-form-message">
                <label for="fieldOfStudyNameLabel" class="form-label">Education Level</label>
                
                  <!-- Select -->
                  <select id="degree_id"  class="form-select" name="degree_id">
                    <option value="">Select Education Level</option>
                    @foreach($primary_degree as $degree)
                    <option value="{{$degree->id}}">{{$degree->name}}</option>
                    @endforeach
                  </select>
                  <!-- End Select -->
                
                <!-- Check -->
                <div class="form-check mt-2">
                  <input type="checkbox" class="form-check-input" name="is_highest_degree" id="is_highest_degree" value="1" class="custom-control-input">
                  <label class="form-check-label" for="is_highest_degree">Highest Degree?</label>
                </div>
                <!-- End Check -->
                <div class="imm-display-notification  mt-2">
                  <b>Select the checkbox to override the ECA equivalency level with education level.</b> The system
                  picks the highest level of degree given as per Educational Credential Assessment(ECA). If the ECA
                  result is not there, it picks the highest level selected in the education level.
                </div>
              </div>
            </div>
            <!-- End Form -->
            <div class="col-12">
              <!-- Form -->
              <div class="mb-4">

                <div class="js-form-message">
                <label for="fieldOfStudyNameLabel" class="form-label">Name of credential</label>
                <input type="text" class="form-control @error('qualification') is-invalid @enderror" name="qualification" id="qualification" placeholder="Enter degree name" aria-label="Qualification" value="">
               @error('qualification')
                <span class="invalid-feedback" role="alert">
                  <strong>{{ $message }}</strong>
                </span>
               @enderror
               </div>
                <!-- <span>Dev Note: this column will only show when PHD, Bachelors, masters, diploma, associate degree. PG
                  diploma option is showed. </span> -->
              </div>
              <!-- End Form -->
            </div>
            <div class="col-12">
              <!-- Form -->
              <div class="mb-4">
                <div class="js-form-message">
                  <label for="schoolNameLabel" class="form-label">School</label>
                  <input type="text" class="form-control" name="school_name" id="school_name"
                    placeholder="University of Oxford" aria-label="University of Oxford">
                </div>
              </div>
              <!-- End Form -->
            </div>
            <div class="col-12">
              <!-- Form -->
              <div class="mb-4">
                <div class="row">
                  <div class="col-6">
                    <label for="we_country_id" class="form-label">Country</label>

                    <!-- Select -->
                    <div class="js-form-message">
                     <select id="we_country_id" onchange="stateList(this.value,'we_state_id')" class="form-select no_select2" name="country_id">
                     <option value="">Select</option>
                      @foreach($countries as $country)
                      <option value="{{$country->id}}">{{ $country->name }}</option>
                      @endforeach
                    </select>
                    </div>
                    <!-- End Select -->
                  </div>
                  <div class="col-6">
                    <!-- Select --> 
                    <label for="we_state_id" class="form-label">State/Province</label>
                    
                    <div class="js-form-message">
                      <select id="we_state_id" class="form-select no_select2" name="state_id">
                        <option value="">Select State</option>
                      </select>
                    </div>
                    <!-- End Select -->

                  </div>
                </div>
              </div>
              <!-- End Form -->
            </div>
            <div class="form-check mt-2 mb-2">

              <input type="checkbox" class="form-check-input" name="is_ongoing_study" id="is_ongoing_study" value="1" class="custom-control-input">

              <label class="form-check-label" for="is_ongoing_study">Is this is an ongoing study?</label>

            </div>
            <div class="col-12">
              <!-- Form -->
              <div class="mb-4">
                <div class="row">
                  <div class="col-6">
                    <label for="schoolFromMonthLabel" class="form-label">From</label>

                    <div class="row gx-2">
                      <div class="col-sm-8 mb-2 mb-sm-1">
                        <!-- Select -->
                        <div class="js-form-message">
                          <select id="from_month" name="from_month" class="form-select ">
                            <option value="">Select</option>
                             @foreach(monthsName() as $month)
                              <option value="{{ $month }}">{{$month}}</option>
                            @endforeach
                            
                          </select>
                        </div>
                        <!-- End Select -->
                      </div>
                      <!-- End Col -->

                      <div class="col-sm-4">
                        <div class="js-form-message">
                          <select class="form-select" id="from_year" name="from_year" class="form-select">
                            <option value="">Select</option>
                            @for($i=$start_year;$i >= $end_year;$i--)
                              <option value="{{$i}}">{{$i}}</option>
                            @endfor
                          </select>
                        </div>
                        
                      </div>
                      <!-- End Col -->
                    </div>
                    <!-- End Row -->
                  </div>
                  <!-- End Form -->
                  <div class="col-6">
                    <label class="form-label">To</label>

                    <div class="row gx-2">
                      <div class="col-sm-8 mb-2 mb-sm-0">
                        <div id="invalid-feedback" class="js-form-message">
                          <select class="form-select" name="to_month" id="to_month">
                              <option value="">Select</option>
                             @foreach(monthsName() as $month)
                              <option value="{{ $month }}">{{$month}}</option>
                            @endforeach                          
                          </select>
                        </div>
                      </div>
                      <!-- End Col -->

                      <div class="col-sm-4 js-form-message">
                        
                        
                          <select class="form-select" id="to_year" name="to_year">
                            <option value="">Select</option>
                            @for($i=$start_year;$i >= $end_year;$i--)
                              <option value="{{$i}}">{{$i}}</option>
                            @endfor
                          </select>
                        
                        
                      </div>
                    </div>
                    <!-- End Col -->
                  </div>
                  <!-- End Row -->
                </div>
              </div>
            </div>
            <!-- End Form -->

            <!-- Container For Input Field -->
            <a href="javascript:;" class="js-create-field form-link">
              <i class="bi-plus-circle me-1"></i>
              Educational Credential Assessment (ECA)
            </a>
            <div class="col-12">
              <div class="imm-eca-add-section">
                <!-- Form -->
               
                  <div class="row">
                    <div class="col-xs-12 col-sm-6"> <div class="mb-4 js-form-message">

                      
                        <label for="educationLabel" class="form-label">Canadian equivalency Level</label>

                        <!-- Select -->
                        <select id="canadian_equivalency_level" class="form-select" name="canadian_equivalency_level">
                          <option value="">Select Job Type</option>
                          @foreach($CanadianEqLevel as $CEL)
                            <option value="{{$CEL->id}}">{{ $CEL->name }}</option>
                          @endforeach
                        </select> <!-- End Select -->
                      

                    </div>
                    </div>
                    <div class="col-xs-12  col-sm-6">

                      <div class="mb-4 js-form-message">

                        <label for="educationLabel" class="form-label">Evaluating agency</label>
                        <!-- Select -->
                        <select id="evaluating_agency" class="form-select" name="evaluating_agency">

                        <option value="">Select Job Type</option>    
                        @foreach($EvaluatingAgency as $EA)
                        <option value="{{$EA->id}}">{{ $EA->name }}</option>
                        @endforeach
                           
                        </select> <!-- End Select -->
                        
                      </div>
                    </div>
                  </div>
                
                <div class="imm-display-notification bg-soft-primary mt-2 mb-4">
                  An Educational credential assessment (ECA) is used to verify that your foreign degree, diploma, or
                  certificate (or other proof of your credential) is valid and equal to a Canadian one. There are
                  different types of ECAs. You need to get an ECA for immigration purposes.
                </div>
              </div>

            </div>

          </div>

      </form>
    </div>

    <div class="modal-footer">
      <button type="button" class="btn btn-white" data-dismiss="modal">Close</button>
      <button form="popup-form" class="btn btn-primary">Save</button>
    </div>

  </div>
</div>


{{--
<div class="modal-dialog modal-lg" role="document">
  <div class="modal-content">
    <div class="modal-header">
        <div class="imm-modal-slanted-div angled lower-start">
          <div class="row">
            <div class="col-10">
              <h3 class="modal-title" id="exampleModalLongTitle">{{$pageTitle}}</h3>
            </div>
            <div class="col-2" style="text-align:right"> <button type="button" class="btn-close"
                data-bs-dismiss="modal" aria-label="Close"></button></div>

          </div>
        </div>
    </div>
    <div class="modal-body">
      <form method="post" id="popup-form"  action="{{ baseUrl('/educations/add') }}">  
          @csrf
          <!-- Form Group -->
          <div class="row form-group">
            <label class="col-sm-3 col-form-label input-label">Primary Degree</label>

            <div class="col-sm-9 js-form-message">
              <select name="degree_id" id="degree_id" class="custom-select">
                  <option value="">Select Degree</option>
                  @foreach($primary_degree as $degree)
                  <option value="{{$degree->id}}">{{$degree->name}}</option>
                  @endforeach
              </select>
            </div>
          </div>
          <!-- End Form Group -->

          <!-- Form Group -->
          <div class="row form-group">
            <label class="col-sm-3 col-form-label input-label">Qualification</label>

            <div class="col-sm-9 js-form-message">
              <input type="text" class="form-control @error('qualification') is-invalid @enderror" name="qualification" id="qualification" placeholder="Enter degree name" aria-label="Qualification" value="">
              @error('qualification')
              <span class="invalid-feedback" role="alert">
                <strong>{{ $message }}</strong>
              </span>
              @enderror
            </div>
          </div>
          <!-- End Form Group -->

          <!-- Form Group -->
          <div class="row form-group">
            <label class="col-sm-3 col-form-label input-label">Percentage</label>

            <div class="col-sm-9 js-form-message">
              <input type="text" class="form-control @error('percentage') is-invalid @enderror" name="percentage" id="percentage" placeholder="Enter Percentage" aria-label="Percentage" value="">
              @error('percentage')
              <span class="invalid-feedback" role="alert">
                <strong>{{ $message }}</strong>
              </span>
              @enderror
            </div>
          </div>
          <!-- End Form Group -->

          <!-- Form Group -->
          <div class="row form-group">
            <label class="col-sm-3 col-form-label input-label">Year Passed</label>
            <div class="col-sm-9 js-form-message">
              <input type="text" class="form-control @error('year_passed') is-invalid @enderror" name="year_passed" id="year_passed" placeholder="Year Passed" aria-label="Year Passed" value="">
              @error('year_passed')
              <span class="invalid-feedback" role="alert">
                <strong>{{ $message }}</strong>
              </span>
              @enderror
            </div>
          </div>
          <!-- End Form Group -->
          <div class="form-group">
            <!-- Checkbox -->
            <div class="custom-control custom-checkbox">
              <input type="checkbox" name="is_eca" id="is_eca" value="1" class="custom-control-input">
              <label class="custom-control-label" for="is_eca">Is ECA?</label>
            </div>
            <!-- End Checkbox -->
          </div>
          <div id="eca_fields" style="display:none">
              <!-- Form Group -->
              <div class="row form-group">
                <label class="col-sm-3 col-form-label input-label">ECA Equalency</label>

                <div class="col-sm-9 js-form-message">
                  <input type="text" class="form-control @error('eca_equalency') is-invalid @enderror" name="eca_equalency" id="eca_equalency" placeholder="Enter ECA Equalency" aria-label="ECA Equalency" disabled value="">
                  @error('eca_equalency')
                  <span class="invalid-feedback" role="alert">
                    <strong>{{ $message }}</strong>
                  </span>
                  @enderror
                </div>
              </div>
              <!-- End Form Group -->

              <!-- Form Group -->
              <div class="row form-group">
                <label class="col-sm-3 col-form-label input-label">ECA Doc No</label>

                <div class="col-sm-9 js-form-message">
                  <input type="text" class="form-control @error('eca_doc_no') is-invalid @enderror" name="eca_doc_no" id="eca_doc_no" placeholder="Enter ECA Doc No" aria-label="ECA Doc No" disabled value="">
                  @error('eca_doc_no')
                  <span class="invalid-feedback" role="alert">
                    <strong>{{ $message }}</strong>
                  </span>
                  @enderror
                </div>
              </div>
              <!-- End Form Group -->

              <!-- Form Group -->
              <div class="row form-group">
                <label class="col-sm-3 col-form-label input-label">ECA Agency</label>

                <div class="col-sm-9 js-form-message">
                  <input type="text" class="form-control @error('eca_agency') is-invalid @enderror" name="eca_agency" id="eca_agency" placeholder="Enter ECA Agency" aria-label="ECA Agency" disabled value="">
                  @error('eca_agency')
                  <span class="invalid-feedback" role="alert">
                    <strong>{{ $message }}</strong>
                  </span>
                  @enderror
                </div>
              </div>
              <!-- End Form Group -->
              <!-- Form Group -->
              <div class="row form-group">
                <label class="col-sm-3 col-form-label input-label">ECA Year</label>
                <div class="col-sm-9 js-form-message">
                  <input type="text" class="form-control @error('eca_year') is-invalid @enderror" name="eca_year" disabled id="eca_year" placeholder="ECA Year" aria-label="ECA Year" value="">
                  @error('eca_year')
                  <span class="invalid-feedback" role="alert">
                    <strong>{{ $message }}</strong>
                  </span>
                  @enderror
                </div>
              </div>
              <!-- End Form Group -->
          </div>
        </form>
    </div>
    <div class="modal-footer">
      <button type="button" class="btn btn-white" data-dismiss="modal">Close</button>
      <button form="popup-form" class="btn btn-primary">Save</button>
    </div>
  </div>
</div>
--}}
<script type="text/javascript">



$(document).ready(function(){
    initSelect();
    $('#join_date').datepicker({
          format: "MM yyyy",
          viewMode: "months", 
          minViewMode: "months",
          orientation: 'auto bottom'
    })
    .on('changeDate', function (selected) {
        startDate = new Date(selected.date.valueOf());
        startDate.setDate(startDate.getDate(new Date(selected.date.valueOf())));
        $('#leave_date').datepicker('setStartDate', startDate);
    });
    $('#leave_date').datepicker({
          format: "MM yyyy",
          viewMode: "months", 
          minViewMode: "months",
          orientation: 'auto bottom'
    });


    $("#popup-form").submit(function(e){
        e.preventDefault();
        var formData = $("#popup-form").serialize();
        var url  = $("#popup-form").attr('action');
        $.ajax({
            url:url,
            type:"post",
            data:formData,
            dataType:"json",
            beforeSend:function(){
              showLoader();
            },
            success:function(response){
              hideLoader();
              if(response.status == true){
                successMessage(response.message);
                closeModal();
                location.reload();
              }else{
                if(response.error_type == 'validation'){
                  validation(response.message);
                }else{
                  errorMessage(response.message);
                }
              }
            },
            error:function(){
              internalError();
            }
        });
    });
});
// $(document).ready(function(){
//     initSelect();
//     $("#is_eca").change(function(){
//       if($(this).is(":checked")){
//         $("#eca_fields").show();
//         $("#eca_fields input").removeAttr("disabled");
//       }else{
//         $("#eca_fields").hide();
//         $("#eca_fields input").attr("disabled","disabled");
//       }
//     })
//     $('#year_passed').datepicker({
//           format: "MM yyyy",
//           viewMode: "months", 
//           minViewMode: "months",
//           orientation: 'auto bottom'
//     })
//     $('#eca_year').datepicker({
//           format: "MM yyyy",
//           viewMode: "months", 
//           minViewMode: "months",
//           orientation: 'auto bottom'
//     });
//     $("#popup-form").submit(function(e){
//         e.preventDefault();
//         var formData = $("#popup-form").serialize();
//         var url  = $("#popup-form").attr('action');
//         $.ajax({
//             url:url,
//             type:"post",
//             data:formData,
//             dataType:"json",
//             beforeSend:function(){
//               showLoader();
//             },
//             success:function(response){
//               hideLoader();
//               if(response.status == true){
//                 successMessage(response.message);
//                 closeModal();
//                 location.reload();
//               }else{
//                 if(response.error_type == 'validation'){
//                   validation(response.message);
//                 }else{
//                   errorMessage(response.message);
//                 }
//               }
//             },
//             error:function(){
//               internalError();
//             }
//         });
//     });
// });
</script>