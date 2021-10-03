@foreach($notes as $key => $note)
@if($note->reminder_date > $current_date)
<li class="justify-content-between mb-4 alert alert-soft-success">
@else
<li class="justify-content-between mb-4 alert alert-soft-danger">
@endif
  <div class="row m-0">
    <div class="col-md-12">
      @if($note->reminder_date > $current_date)
        <div class="float-left">
          <div class="badge p-2 badge-soft-primary">Upcoming</div>
        </div>
      @else
        <div class="float-left">
          <div class="badge p-2 badge-soft-secondary">Ended</div>
        </div>
      @endif
      <div class="float-right mb-2">
        <div class="hs-unfold">
          <a class="js-hs-action btn btn-sm" href="javascript:;"
             data-hs-unfold-options='{
               "target": "#reminder-{{$key}}",
               "type": "css-animation"
             }'>
            <i class="tio-more-vertical"></i>
          </a>

          <div id="reminder-{{$key}}" class="hs-unfold-content dropdown-unfold dropdown-menu dropdown-menu-sm dropdown-menu-right">
            <a class="dropdown-item" onclick="showPopup('<?php echo baseUrl('edit-reminder-note/'.$note->unique_id) ?>')" href="javascript:;">
              <i class="tio-edit dropdown-item-icon"></i>
              Edit
            </a>
            <div class="dropdown-divider"></div>
            <a class="dropdown-item text-danger" href="javascript:;" onclick="confirmAction(this)"  data-href="{{baseUrl('delete-reminder-note/'.$note->unique_id)}}">
              <i class="tio-delete-outlined dropdown-item-icon"></i>
              Delete
            </a> 
          </div>
        </div>
      </div>
      <div class="clearfix"></div>
      <div class="chat-body white p-0 z-depth-1">
        <div class="header text-right">
         <small class="pull-right text-muted"><i class="far fa-clock"></i> {{ dateFormat($note->reminder_date,'F d,Y') }}</small>
        </div>
        <hr class="w-100">
        <p class="mb-0">
          {{$note->notes}}
        </p>
      </div>
    </div>
  </div>
</li>
@endforeach
