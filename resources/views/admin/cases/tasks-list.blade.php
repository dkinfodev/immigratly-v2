@foreach($records as $key => $record)
<tr>
  <td class="table-column-pr-0">
    <div class="custom-control custom-checkbox">
      <input type="checkbox" class="custom-control-input row-checkbox" value="{{ base64_encode($record->id) }}" id="row-{{$key}}">
      <label class="custom-control-label" for="row-{{$key}}"></label>
    </div>
  </td>
  <td scope="col">
    {{ $record->task_title }}
  </td>
 
  <td scope="col">
  
    @if($record->status == 'pending')
    <span class="badge badge-soft-warning p-2">Pending</span>
    @elseif($record->status == 'completed')
    <span class="badge badge-soft-success p-2">Completed</span>
    @endif
  </td>
   <td scope="col">
    {{ dateFormat($record->created_at) }}
  </td>
  <td scope="col">
      <a href="<?php echo baseUrl('cases/tasks/edit/'.$record->unique_id) ?>" class="btn btn-warning btn-sm"><i class="tio-edit"></i> Edit </a>
      <a href="<?php echo baseUrl('cases/tasks/view/'.$record->unique_id) ?>" class="btn btn-info btn-sm"><i class="fa fa-eye"></i> View </a>
      <a  href="javascript:;" onclick="confirmAction(this)" data-href="{{baseUrl('cases/tasks/delete/'.base64_encode($record->id))}}" class="btn btn-danger btn-sm"><i class="tio-delete"></i> Delete </a>
   </td>
</tr>
@endforeach
<script type="text/javascript">
$(document).ready(function(){
  $('.js-nav-tooltip-link').tooltip({ boundary: 'window' })
  $('.js-hs-action').each(function () {
    var unfold = new HSUnfold($(this)).init();
  });
})
</script>