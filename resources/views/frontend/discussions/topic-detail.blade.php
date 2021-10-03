@extends('frontend.layouts.master')
  <!-- Hero Section -->
@section('style')


@endsection

@section('content')
<!-- Search Section -->
<div class="bg-dark">
  <div class="bg-img-hero-center" style="background-image: url({{asset('assets/frontend/svg/components/abstract-shapes-19.svg')}});padding-top: 94px;">
    <div class="container space-1">
      <div class="w-lg-100 mx-lg-auto">
        <!-- Input -->
        <h1 class="text-lh-sm text-white">{{$record->group_title}}</h1>
        <!-- End Input -->
      </div>
    </div>
  </div>
</div>
<div class="container space-bottom-2">
  <div class="w-lg-100 mx-lg-auto">
    <!-- Breadcrumbs -->
    <nav aria-label="breadcrumb">
      <ol class="breadcrumb breadcrumb-no-gutter font-size-1 space-1">
        <li class="breadcrumb-item"><a href="{{url('/')}}">Home</a></li>
        <li class="breadcrumb-item"><a href="{{ url('discussions') }}">Discussions</a></li>
        <li class="breadcrumb-item active" aria-current="page">{{$record->group_title}}</li>
      </ol>
    </nav>
    <!-- End Breadcrumbs -->

    <!-- Article -->
    <div class="card card-bordered">
      <!-- <h1 class="h2">What's Front?</h1> -->
      <!-- <p>How Front works, what it can do for your business and what makes it different to other solutions.</p> -->

      <!-- Article Authors -->
      <div class="media mb-5">
        <div class="avatar avatar-xs avatar-circle mr-2">
          <img class="avatar-img" src="{{ userProfile($record->created_by,'m') }}" alt="Image Description">
        </div>

        <div class="media-body">
          <small class="d-block">
            <span class="text-muted">Added by</span>
            <span class="text-dark">{{$record->User->first_name." ".$record->User->last_name}}</span>
          </small>
          <small class="d-block text-body">
            {{dateFormat($record->created_at)}}
          </small>
        </div>
      </div>
      <!-- End Article Authors -->
      <div class="description">
        <?php echo $record->description ?>
      </div>

    </div>
    <!-- End Article -->
  </div>
  
  <hr class="my-10">

  <ul class="list-unstyled list-lg-article comments">
    
  </ul>
  <!-- Footer -->
  @if(Auth::check())
  <form id="form" class="js-validate" method="post">
    @csrf
    <div class="row alert alert-soft-dark">
      <div class="col-md-12 mb-2">
        <textarea name="message" class="form-control js-count-characters" id="message" rows="1" maxlength="100" placeholder="Place your comments here..."></textarea>
      </div>
      <div class="col-md-4 text-left">
         <div class="custom-file">
            <input type="file" class="js-file-attach custom-file-input" id="customFile"
                    data-hs-file-attach-options='{
                      "textTarget": "[for=\"customFile\"]",
                      "resetTarget": ".js-file-attach-reset-img"
                   }'>
            <label class="custom-file-label" for="customFile">Choose file</label>
          </div>
        
      </div>
      <div class="col-md-2 text-left">
        <button type="button" class="js-file-attach-reset-img btn btn-sm btn-outline-dark mt-1">Reset</button>
      </div>
      <div class="col-md-6 text-right">
        <button type="button" id="submitbtn" class="btn btn-dark"><i class="fa fa-send"></i> Send</button>
      </div>
    </div>
  </form>
  <!-- <div class="text-danger h3">Login to place your comments</div> -->
  @endif
          <!-- End Footer -->
</div>
@endsection

@section("javascript")
<script src="assets/vendor/hs-file-attach/dist/hs-file-attach.min.js"></script>

<script type="text/javascript">
$(document).ready(function(){
  $(".js-file-attach-reset-img").click(function(){
      $("#customFile").val(null);
      $(".custom-file-label").html("Choose File");
     
  });
  $('.js-file-attach').each(function () {
    var customFile = new HSFileAttach($(this)).init();
  });
  $("#submitbtn").click(function(){
      
      var formData = new FormData();
      var _isvalid = 0;
      formData.append("_token",csrf_token);
      formData.append("chat_id","{{ $record->unique_id }}");
      if($("#message").val() != ''){
        _isvalid = 1;
        formData.append("message",$("#message").val());
      }
      if($('#customFile').val() != ''){
        _isvalid = 1;
        formData.append('file', $('#customFile')[0].files[0]);
      }
      if(_isvalid == 0){
        errorMessage("No value to send");
        return false;
      }
      var url  = "{{ url('discussions/send-comment') }}";
      $.ajax({
        url:url,
        type:"post",
        data:formData,
        cache: false,
        contentType: false,
        processData: false,
        dataType:"json",
        beforeSend:function(){
          showLoader();
        },
        success:function(response){
          hideLoader();
          if(response.status == true){
            successMessage(response.message);
            $("#form")[0].reset();
            $(".js-file-attach-reset-img").trigger("click");
            $("#customFileExample5").html("Choose file to upload");
            fetchComments();
          }else{
            errorMessage(response.message);
          }
        },
        error:function(){
            internalError();
        }
      });
      
    });
})
fetchComments();

function fetchComments(){

    $.ajax({
        type: "POST",
        url:"{{url('discussions/fetch-comments')}}",
        data:{
          _token:csrf_token,
          chat_id:"{{ $record->unique_id }}"
        },
        dataType:'json',
        beforeSend:function(){
            showLoader();
        },
        success: function (data) {
            hideLoader();
            $(".comments").html(data.contents);
            
        },
        error:function(){
            internalError();
        }
    });
}
</script>
@endsection