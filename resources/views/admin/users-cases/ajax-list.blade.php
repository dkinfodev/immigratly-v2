@foreach($records as $key => $record)
<div class="card">
  <div class="card-header">
    <h5 class="card-header-title float-left">{{$record->case_title}}</h5>
    <div class="text-muted float-right">{{dateFormat($record->created_at) }}</div>
    <div class="clearfix"></div>
    <small class="text-muted">User ID: {{$record->user_id}}</small>
  </div>
  <div class="card-body">
    <p class="card-text">{{ substr(strip_tags($record->description),0,200) }}....</p>
    <a href="{{ baseUrl('users-cases/detail/'.$record->unique_id) }}" class="btn btn-primary float-right">View More</a>
  </div>
</div>
<hr>
@endforeach
<script type="text/javascript">
$(document).ready(function(){
  $('.js-nav-tooltip-link').tooltip({ boundary: 'window' })
  $('.js-hs-action').each(function () {
    var unfold = new HSUnfold($(this)).init();
  });
})

</script>