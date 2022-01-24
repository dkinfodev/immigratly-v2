@if(count($records) > 0)
@foreach($records as $record)
  <div class="col-12  mb-5">
      <!-- Card -->
      <div class="card card-bordered h-100 imm-all-program-list">
          <!-- Card Body -->

          <div class="imm-all-program-list-header">
              <a href="javascript:;">{{$record->ProgramType->name}}</a>
          </div>



          <div class="imm-all-program-list-body">
              <div class="row mb-3 align-items-center">

                  <!-- End Col -->
                  <div class="col-3">
                      <!-- Media -->
                      <div class="d-flex">
                          <div class="imm-program-logo-container">
                          @if(file_exists(public_path('uploads/visa-groups/'.$record->image)))
                            
                                <img class="imm-program-logo" src="{{ asset('/public/uploads/visa-groups/'.$record->image) }}" class="img-fluid" width="200" />
                            
                          @endif
                          </div>


                      </div>
                      <!-- End Media -->
                  </div>
                  <!-- End Col -->
                  <div class="col-9">
                      <h4 class="card-title mb-2">
                          <a class="text-dark" href="{{ baseUrl('eligibility-check/lists/'.$record->unique_id) }}">{{$record->group_title}}</a>
                      </h4>
                      <div class="imm-self-assessment-container">
                          <div class="row">
                              <div class="col-5">
                                  <div class="d-flex" style="text-align:right">

                                      <img class="me-1" src="assets/img/checked.svg" alt=""
                                          style="width:18px">

                                      <p><b>{{ $record->VisaServices->count() }}</b> Nomination pathways</p>
                                  </div>


                              </div>
                              <div class="col-4">
                                  <button type="button" class="btn btn-info btn-sm w-100  mt-1">Auto
                                      self-assessment</button>
                              </div>
                              <div class="col-3">
                                  <button type="button"
                                      class="btn btn-outline-secondary btn-sm w-100">Learn
                                      more</button>
                              </div>
                          </div>
                      </div>
                  </div>
              </div>
              <!-- End Row -->

          </div>
          <!-- End Card Body -->

          <!-- Card Footer -->
          <div class="imm-all-program-list-footer">
              <ul class="list-inline list-separator small text-body">
                  <li class="list-inline-item">
                      <div class="d-flex  align-items-center">
                          <span class="imm-progam-small-titles">Skilled/Semi skilled
                              <span>2</span></span>


                      </div>
                  </li>
                  <li class="list-inline-item">
                      <div class="d-flex  align-items-center">
                          <span class="imm-progam-small-titles">Students <span
                                  class="imm-title-small-redback">3</span></span>


                      </div>
                  </li>
                  <li class="list-inline-item">
                      <div class="d-flex  align-items-center">
                          <span class="imm-progam-small-titles">Business Investment <span
                                  class="imm-title-small-greenback">2</span></span>


                      </div>
                  </li>
              </ul>
          </div>
          <!-- End Card Footer -->
      </div>
      <!-- End Card -->
  </div>
  @endforeach
@endif

<script>
/*$(document).ready(function(){
  $(".parent-check").change(function(){
      var key = $(this).attr("data-key");
      if($(this).is(":checked")){
        $(".parent-"+key).prop("checked",true);
      }else{
        $(".parent-"+key).prop("checked",false);
      }
  })
  $('.js-hs-action').each(function () {
    var unfold = new HSUnfold($(this)).init();
  });
})*/
</script>