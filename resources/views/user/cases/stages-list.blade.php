<div class="card m-0 p-0 ml-0 mr-0 pl-0 pr-0" >
  <div class="card-body ">
    @foreach($records as $key => $record)
    <div class="mt-5 pt-3">
    <div class="row mb-2" >
      <div class="col-md-9" >
        <h5 class="cards-title pt-3 pb-2">{{ ucwords($record->name) }}</h5>
      </div>
      <div class="col-md-3 float-right" style="float: right">

        <a class="btn btn-primary btn-sm" onclick="showPopup('<?php echo baseUrl('cases/sub-stages/add/'.base64_encode($record->id)) ?>')" href="javascript:;">
            Sub Stages
        </a>

        <div class="hs-unfold">
          <a class="js-hs-action btn btn-sm btn-white" href="javascript:;"
            data-hs-unfold-options='{
              "target": "#action-{{$record->unique_id}}",
              "type": "css-animation"
            }'>More  <i class="tio-chevron-down ml-1"></i>
          </a>
          <div id="action-{{$record->unique_id}}" class="hs-unfold-content dropdown-unfold dropdown-menu dropdown-menu-right">

            <a href="<?php echo baseUrl('cases/stages/edit/'.$record->unique_id) ?>" class="dropdown-item"><i class="tio-edit"></i> Edit </a>

            <a href="<?php echo baseUrl('cases/stages/view/'.$record->unique_id) ?>" class="dropdown-item"><i class="tio-globe"></i> View </a>

            <div class="dropdown-divider"></div>
            <a  href="javascript:;" onclick="confirmAction(this)" data-href="{{baseUrl('cases/stages/delete/'.base64_encode($record->id))}}" class="dropdown-item"><i class="tio-delete"></i> Delete </a>

          </div>
        </div>
      </div>
    </div>

    <p class="card-text mb-2">{{ $record->short_description }}</p>
    </div>
    
    @endforeach
    
  </div>
</div>


<script type="text/javascript">
$(document).ready(function(){
  $('.js-nav-tooltip-link').tooltip({ boundary: 'window' })
  $('.js-hs-action').each(function () {
    var unfold = new HSUnfold($(this)).init();
  });
})
</script>