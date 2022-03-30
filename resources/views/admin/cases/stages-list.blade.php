@foreach($records as $key => $record)
<div class="card">
  <!-- <div class="card-header">
    
  </div>
  <hr> -->
  <div class="card-body">
    <h5 class="card-title">{{ $record->name }}</h5>
    <p class="card-text">{{ $record->short_description }}</p>
    <a href="#" class="btn btn-sm btn-primary">Add Sub Stages</a> <a href="<?php echo baseUrl('cases/stages/edit/'.$record->unique_id) ?>" class="btn btn-warning btn-sm"><i class="tio-edit"></i> Edit </a>
      <a href="<?php echo baseUrl('cases/stages/view/'.$record->unique_id) ?>" class="btn btn-info btn-sm"><i class="fa fa-eye"></i> View </a>
      <a  href="javascript:;" onclick="confirmAction(this)" data-href="{{baseUrl('cases/stages/delete/'.base64_encode($record->id))}}" class="btn btn-danger btn-sm"><i class="tio-delete"></i> Delete </a> 
  </div>
</div>

@endforeach

@foreach($records as $key => $record)
{{--
<tr>
  <td class="table-column-pr-0">
    <div class="custom-control custom-checkbox">
      <input type="checkbox" class="custom-control-input row-checkbox" value="{{ base64_encode($record->id) }}" id="row-{{$key}}">
      <label class="custom-control-label" for="row-{{$key}}"></label>
    </div>
  </td>
  <td scope="col">
    {{ $record->name }}
  </td>
 
 <td scope="col">
    {{ $record->short_description }}
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
--}}
@endforeach
<script type="text/javascript">
$(document).ready(function(){
  $('.js-nav-tooltip-link').tooltip({ boundary: 'window' })
  $('.js-hs-action').each(function () {
    var unfold = new HSUnfold($(this)).init();
  });
})
</script>