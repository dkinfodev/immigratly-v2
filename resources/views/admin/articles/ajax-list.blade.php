@if(!empty($records))
@foreach($records as $key => $record)
<div class="col-md-12 article-block">
  <!-- Card -->
  <div class="card card-hover-shadow h-100">

    <!-- Body -->
    <div class="card-body">
      <div class="row">
        <div class="col-md-3">
            <div class="d-flex justify-content-center mb-2">
              <!-- Avatar -->
              <?php
                if($record['images'] != ''){
                  $images = explode(",",$record['images']);
                  if(file_exists(public_path('uploads/articles/'.$images[0]))){
                      $image = url('public/uploads/articles/'.$images[0]);
                  }
              ?>
              <img src="{{$image}}" width="100%" alt="Image Description">
              <?php
                }else{
              ?>
              <img src="assets/svg/brands/google-webdev.svg" alt="Image Description">
              <?php } ?>
            </div>
        </div>
        <div class="col-md-9">
          <div class="content-detail">
            <div class="float-right">
              <div class="hs-unfold card-unfold">
                <a class="js-hs-action btn btn-icon btn-sm btn-ghost-secondary rounded-circle" href="javascript:;"
                   data-hs-unfold-options='{
                     "target": "#projectsGridDropdown-{{$key}}",
                     "type": "css-animation"
                   }'>
                  <i class="tio-more-vertical"></i>
                </a>

                <div id="projectsGridDropdown-{{$key}}" class="hs-unfold-content dropdown-unfold dropdown-menu dropdown-menu-sm dropdown-menu-right">
                  <a class="dropdown-item" href="{{baseUrl('articles/edit/'.$record['unique_id'])}}">
                    <i class="tio-edit dropdown-item-icon"></i>
                    Edit
                  </a>
                  <!-- <a class="dropdown-item" href="#">Add to favorites</a>
                  <a class="dropdown-item" href="#">Archive project</a> -->
                  <div class="dropdown-divider"></div>
                  <a class="dropdown-item text-danger" href="javascript:;" onclick="confirmAction(this)" data-href="{{ baseUrl('articles/delete/'.$record['unique_id']) }}">
                   <i class="tio-delete-outlined dropdown-item-icon"></i>
                   Delete
                  </a>
                </div>
              </div>
            </div>
            <div class="clearfix"></div>
          
            <div class="mb-4">
              <h2 class="mb-1">{{$record['title']}}</h2>
              <div class="row mb-3">
                <div class="col-auto">
                  <span class="legend-indicator bg-primary"></span> {{$record['category']['name']}}
                </div>
                <div class="col-auto">
                  <span class="font-size-sm"><i class="tio-calendar"></i> {{dateFormat($record['created_at'])}}</span>
                </div>
              </div>
              <p>
                {{substr($record['short_description'],0,150)}}
              </p>
              <div class="article-user">
                <span class="avatar avatar-circle">
                  <img class="avatar-img" src="{{professionalLogo('m',$record['professional'])}}" alt="Image Description">
                </span>
                <span class="h3 avatar-name">{{ $record['professional_info']['company_name'] }}</span>
              </div>
            </div>
            <a class="stretched-link" href="#"></a>
          </div>
        </div>
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