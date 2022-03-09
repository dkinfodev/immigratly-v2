@if(!empty($records))
@foreach($records as $key => $record)
<div class="col-md-12 article-block">
  <!-- Card -->
  <div class="card card-hover-shadow h-100">

    <!-- Body -->
    <div class="card-body">
        
        <div class="col-md-3 bg-light p-5 ">
          <div class="h5 text-center ">{{$record->name}}</div>
          <p>{!! $record->description !!}</p>

          <div class="">{{$record->link}}</div>

        </div>

    </div>
  </div>
  <!-- End Card -->
</div>
@endforeach
@else
<div class="col-md-12 text-danger text-center">No records available</div>
@endif
<script type="text/javascript">
$(document).ready(function(){
  $('.js-hs-action').each(function () {
    var unfold = new HSUnfold($(this)).init();
  });
  $(".row-checkbox").change(function(){
    if($(".row-checkbox:checked").length > 0){
      $("#datatableCounterInfo").show();
    }else{
      $("#datatableCounterInfo").show();
    }
    $("#datatableCounter").html($(".row-checkbox:checked").length);
  });
})
</script>