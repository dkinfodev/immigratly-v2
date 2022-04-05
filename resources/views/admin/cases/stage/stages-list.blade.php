@foreach($records as $key => $record)
<div class="card mb-3" >
  <div class="card-header p-4">
    <div class="row" >
      <div class="col-md-4" >
        <h5 class="cards-title pt-3 pb-2">{{ ucwords($record->name) }}</h5>
      </div>
      <div class="col-md-8">
        <div class="row">
          <div class="col-md-2 offset-md-4">
              <div class="float-right">
                @php
                  $total_stages = $record->SubStages->count();
                  $total_completed = $record->CompletedStages->count();
                  if($total_completed  > 0){
                    $percent = ($total_completed/$total_stages)*100;
                  }else{
                    $percent = 0;
                  }

                @endphp
                <div class="js-circle"
                  data-hs-circles-options='{
                    "value": "{{$percent}}",
                    "maxValue": 100,
                    "duration": 2000,
                    "isViewportInit": true,
                    "colors": ["rgba(55, 125, 255, 0.1)", "#377dff"],
                    "radius": 15,
                    "width": 4,
                    "textFontSize": 16,
                    "additionalText": "",
                    "textClass": "circle-custom-text",
                    "textColor": "#377dff"
                  }'>
                </div>
              </div>
          </div>
          <div class="col-md-6">
            <a class="btn btn-primary btn-sm" href="<?php echo baseUrl('cases/sub-stages/add/'.$record->unique_id) ?>" >
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
    </div>
  </div>

  <div class="card-body p-4">
      <p class="card-text">{{ $record->short_description }}</p>
      @if(count($record->SubStages) > 0)
      <div class="substagelists">
          <table class="table table-bordered noborder">
              <thead>
                <tr>
                  <th colspan="4" class="bg-light">Stage Tasks</th>
                </tr>
              </thead>
              <tbody>
            @foreach($record->SubStages as $key=>$substage)
                  <tr>
                    <td>
                      <i class="tio tio-circle"></i> {{$substage->name}} &nbsp;  
                    </td>
                    <td>
                      @if($substage->stage_type == "fill-form")
                        Fill Form
                      @elseif($substage->stage_type == 'case-task')
                        Case Task
                      @elseif($substage->stage_type == 'case-document')
                        Case Document
                      @elseif($substage->stage_type == 'case-task')
                        Case Task
                      @endif
                    </td>
                    <td>
                      @if($substage->status == '1')
                        <span class="badge badge-success">Completed</span>
                      @else
                        <span class="badge badge-danger">Pending</span>
                      @endif
                    </td>
                    <td>
                      <a data-toggle="tooltip" data-html="true" title="Click to Edit" class="btn btn-sm btn-warning p-2 js-nav-tooltip-link" href="<?php echo baseUrl('cases/sub-stages/edit/'.$record->unique_id.'/'.$substage->unique_id); ?>"><i class="tio-edit"></i></a> 
                      <a data-toggle="tooltip" data-html="true" title="Click to View" class="btn btn-sm btn-dark p-2 js-nav-tooltip-link" href="<?php echo baseUrl('cases/sub-stages/view/'.$substage->unique_id); ?>"><i class="tio-globe"></i></a> 
                      <a data-toggle="tooltip" data-html="true" title="Click to Delete" class="btn btn-sm btn-danger p-2 js-nav-tooltip-link" href="javascript:;" onclick="confirmAction(this)" data-href="{{baseUrl('cases/sub-stages/delete/'.base64_encode($substage->id))}}"><i class="tio-delete"></i> </a>
                      @if($substage->status == 0)
                        <a data-toggle="tooltip" data-html="true" title="Mark as Complete" onclick="return confirm('Are you sure to mark as complete')" class="btn btn-sm btn-success p-2 js-nav-tooltip-link" href="<?php echo baseUrl('cases/sub-stages/status/mark-as-complete/'.$record->unique_id.'/'.$substage->unique_id); ?>"><i class="tio-done"></i></a> 
                      @else
                        <a data-toggle="tooltip" data-html="true" title="Mark as Pending" onclick="return confirm('Are you sure to mark as pending')" class="btn btn-sm btn-info p-2 js-nav-tooltip-link" href="<?php echo baseUrl('cases/sub-stages/status/mark-as-pending/'.$record->unique_id.'/'.$substage->unique_id); ?>"><i class="tio-warning"></i></a> 
                      @endif
                    </td>
                  </tr>
            @endforeach
            </tbody>
          </table>
      </div>
      @endif
  </div>
</div>
@endforeach

<script type="text/javascript">
$(document).ready(function(){
  $('.js-nav-tooltip-link').tooltip({ boundary: 'window' })
  $('.js-hs-action').each(function () {
    var unfold = new HSUnfold($(this)).init();
  });
})
</script>