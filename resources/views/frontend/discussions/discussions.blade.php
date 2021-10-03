@extends('frontend.layouts.master')
  <!-- Hero Section -->
@section('style')


@endsection

@section('content')
<!-- Search Section -->
<div class="bg-dark">
  <div class="bg-img-hero-center" style="background-image: url({{asset('assets/frontend/svg/components/abstract-shapes-19.svg')}});padding-top: 94px;">
    <div class="container space-1">
      <div class="w-lg-80 mx-lg-auto">
        <!-- Input -->
        <form class="input-group input-group-merge input-group-borderless">
          <div class="input-group-prepend">
            <span class="input-group-text" id="askQuestions">
              <i class="fas fa-search"></i>
            </span>
          </div>
          <input type="search" class="form-control" placeholder="Search for topic" aria-label="Search for topic" id="search" aria-describedby="askQuestions">
        </form>
        <!-- End Input -->
      </div>
    </div>
  </div>
</div>
<!-- End Search Section -->

<!-- Breadcrumbs Section -->
<div class="container space-1">
  <div class="w-lg-80 mx-lg-auto">
    <nav aria-label="breadcrumb">
      <ol class="breadcrumb breadcrumb-no-gutter font-size-1">
        <li class="breadcrumb-item"><a href="{{ url('/') }}">Home</a></li>
        <li class="breadcrumb-item active" aria-current="page">Discussions</li>
      </ol>
    </nav>
  </div>
</div>
<!-- End Breadcrumbs Section -->

<!-- FAQ Section -->
<div class="container space-bottom-2">

  <div class="w-lg-80 mx-lg-auto discussion-lists">
    
    
  </div>
  <a class="btn btn-block btn-white load-more" href="javascript:;">
    <i class="tio-refresh mr-1"></i> Load more activities
  </a>
</div>
<!-- End FAQ Section -->
@endsection

@section('javascript')
<script type="text/javascript">
var next_page = 0;
$(document).ready(function(){
  $(".load-more").click(function(){
    loadData(next_page);
  });
  $("#search").keyup(function(){
    var value = $(this).val();
    if(value == ''){
      loadData(1,'search');
    }
    if(value.length > 3){

      loadData(1,'search');
    }
  });
})
loadData();
function loadData(page=1,type=''){
    var search = $("#search").val();
    $.ajax({
        type: "GET",
        url: "{{ url('discussions/fetch-topics') }}?page="+page,
        data:{
            _token:csrf_token,
            search:search
        },
        dataType:'json',
        beforeSend:function(){
            showLoader();
        },
        success: function (data) {
            hideLoader();
            if(type == 'search'){
              $(".discussion-lists").html(data.contents);
            }else{
              $(".discussion-lists").append(data.contents);
            }
            
            if(data.next_page <= data.last_page){
              $(".load-more").show();
              next_page = data.next_page;
            }else{
              $(".load-more").hide();
            }
        },
        error:function(){
            internalError();
        }
    });
}
</script>
@endsection