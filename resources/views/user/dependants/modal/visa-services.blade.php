<style>
.invalid-feedback {
    position: absolute;
    bottom: -20px;
}
</style>

<div class="modal-dialog" role="document">
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
      <div class="accordion" id="accordionExample">
        @foreach($cv_types as $key => $type)
        <div class="card" id="heading-{{$key}}">
          <a class="card-header card-btn btn-block" href="javascript:;" data-toggle="collapse" data-target="#collapse-{{$key}}" aria-expanded="true" aria-controls="collapse-{{$key}}">
            {{$type->name}}
            <span class="card-btn-toggle">
              <span class="card-btn-toggle-default">
                <i class="tio-add"></i>
              </span>
              <span class="card-btn-toggle-active">
                <i class="tio-remove"></i>
              </span>
            </span>
          </a>

          <div id="collapse-{{$key}}" class="collapse {{ $key == 0?'show':'' }}" aria-labelledby="heading-{{$key}}" data-parent="#accordionExample">
            <!-- Header -->
              <div class="card-header">
                <div class="row justify-content-between align-items-center flex-grow-1">
                

                  <div class="col-auto">
                    <!-- Filter -->
                    <form>
                      <!-- Search -->
                      <div class="input-group input-group-merge input-group-flush">
                        <div class="input-group-prepend">
                          <div class="input-group-text">
                            <i class="tio-search"></i>
                          </div>
                        </div>
                        <input id="datatableWithSearchInput-{{$key}}" type="search" class="form-control" placeholder="Search Service" aria-label="Search Service">
                      </div>
                      <!-- End Search -->
                    </form>
                    <!-- End Filter -->
                  </div>
                </div>
              </div>
                <!-- End Header -->
              <div class="card-body">
                <div class="table-responsive datatable-custom">
                    <table id="datatable-{{$key}}" class="datatable table table-borderless table-thead-bordered table-nowrap table-align-middle card-table"  data-hs-datatables-options='{
                        "order": [],
                        "search": "#datatableWithSearchInput-{{$key}}",
                        "isResponsive": false,
                        "isShowPaging": false,
                        "pagination": "datatableWithSearch-{{$key}}"
                      }'>
                        <thead>
                            <tr>
                                <th>#</th>
                                <th>Visa Service</th>
                                <th>Visa Profile</th>
                                <th>Assessment Price</th>
                                <th>Action</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($type->VisaServices as $key => $service)
                            <tr>
                                <td>{{$key+1}}</td>
                                <td>{{$service->name}}</td>
                                <td>
                                    @if(!empty($service->CvTypeDetail))
                                    {{$service->CvTypeDetail->name}}
                                    @else
                                        <span class="text-danger">N/A</span>
                                    @endif
                                </td>
                                <td>{{currencyFormat($service->assessment_price)}}</td>
                                <td><button onclick="chooseService('{{ $service->unique_id }}','{{ $service->name }}')" type="button" class="btn btn-sm btn-soft-primary">Select</button></td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>

                </div>
              </div>
              <div class="card-footer">
                <!-- Pagination -->
                <div class="d-flex justify-content-center justify-content-sm-end">
                  <nav id="datatableWithSearch-{{$key}}" aria-label="Activity pagination"></nav>
                </div>
                <!-- End Pagination -->
              </div>
          </div>
        </div>
        @endforeach
      </div>
    </div>
    <div class="modal-footer">
      <button type="button" class="btn btn-white" data-dismiss="modal">Close</button>
      
    </div>

  </div>
</div>


<script src="assets/vendor/datatables/media/js/jquery.dataTables.min.js"></script>
<script type="text/javascript">
  function chooseService(id,name){
      $("#visa_service_id").val(id);
      $("#visa_service").html(name);
      closeModal();
  }
  $(document).ready(function(){
    $(".datatable").each(function(){
        var id ="#"+$(this).attr("id");
        $.HSCore.components.HSDatatables.init($(id));
    })
    
  })
</script>