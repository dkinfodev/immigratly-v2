<style>
.invalid-feedback {
    position: absolute;
    bottom: -20px;
}
</style>
<div class="modal-dialog modal-lg" role="document">
  <div class="modal-content">
    <div class="modal-header">
      <h5 class="modal-title" id="staticBackdropLabel">{{$pageTitle}}</h5>
      <button type="button" class="btn btn-xs btn-icon btn-ghost-secondary" data-dismiss="modal" aria-label="Close">
        <i class="tio-clear tio-lg"></i>
      </button>
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

<script type="text/javascript">
$(document).ready(function(){
    initSelect();
    $("#is_eca").change(function(){
      if($(this).is(":checked")){
        $("#eca_fields").show();
        $("#eca_fields input").removeAttr("disabled");
      }else{
        $("#eca_fields").hide();
        $("#eca_fields input").attr("disabled","disabled");
      }
    })
    $('#year_passed').datepicker({
          format: "MM yyyy",
          viewMode: "months", 
          minViewMode: "months",
          orientation: 'auto bottom'
    })
    $('#eca_year').datepicker({
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
</script>