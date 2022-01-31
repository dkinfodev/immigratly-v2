@extends('layouts.master')


@section('breadcrumb')
<!-- Content -->
<ol class="breadcrumb breadcrumb-no-gutter">
  <li class="breadcrumb-item"><a class="breadcrumb-link" href="{{ baseUrl('/') }}">Dashboard</a></li>
  <li class="breadcrumb-item"><a class="breadcrumb-link" href="{{ baseUrl('/discussions') }}">Chat Groups</a></li>
  <li class="breadcrumb-item active" aria-current="page">{{$pageTitle}}</li>
</ol>
<!-- End Content -->
@endsection


@section('header-right')
        <a class="btn btn-primary" href="{{ baseUrl('/discussions') }}">
          <i class="tio mr-1"></i> Back 
        </a>
@endsection



@section('content')
<style type="text/css">
.comments{
  min-height: 400px;
}
</style>
<!-- Content -->
<div class="discussions">

  <!-- Card -->
  <div class="card">

    <div class="card-body">
      
        <div class="row justify-content-lg-center">
        <div class="col-lg-12">
          <!-- Alert -->
          <div class="alert alert-soft-dark mb-5 mb-lg-7" role="alert">
            <div class="media align-items-top">
              <img class="avatar avatar-xl mr-3" src="./assets/svg/illustrations/yelling-reverse.svg" alt="Image Description">

              <div class="media-body">
                <h3 class="alert-heading mb-1">{{$record->group_title}}</h3>
                <p class="mb-0">
                  <?php echo $record->description ?>
                </p>
              </div>
            </div>
          </div>
          <!-- End Alert -->

          <!-- Step -->
          <div class="comments">
            <ul class="step">
            </ul>
          </div>
          <!-- End Step -->

          <!-- Footer -->
          <form id="form" class="js-validate" action="{{ baseUrl('discussions/update/'.$record->unique_id) }}" method="post">
            @csrf
            <div class="row alert alert-soft-dark">
              <div class="col-md-12 mb-2">
                <textarea name="message" class="form-control js-count-characters" id="message" rows="1" maxlength="100" placeholder="Place your comments here..."></textarea>
              </div>
              <div class="col-md-6 text-left">
                <label class="btn btn-sm btn-primary transition-3d-hover custom-file-btn" for="fileAttachmentBtn">
                  <span id="customFileExample5">Choose file to upload</span>
                  <input id="fileAttachmentBtn" name="custom-file" type="file" class="js-file-attach custom-file-btn-input"
                         data-hs-file-attach-options='{
                            "textTarget": "#customFileExample5",
                            "resetTarget": ".js-file-attach-reset-img"
                         }'>
                </label>
                  <button type="button" class="js-file-attach-reset-img btn btn-sm btn-white ml-2">Reset</button>
              </div>
              <div class="col-md-6 text-right">
                <button type="button" id="submitbtn" class="btn btn-dark"><i class="fa fa-send"></i> Send</button>
              </div>
            </div>
          </form>
          <!-- End Footer -->
        </div>
      </div>
    </div>
  </div>
<!-- End Content -->
@endsection

@section('javascript')
<!-- JS Implementing Plugins -->
<script src="assets/vendor/hs-file-attach/dist/hs-file-attach.min.js"></script>
<script src="assets/vendor/hs-count-characters/dist/js/hs-count-characters.js"></script>
<script>
  fetchComments();
  function fetchComments(){
    var chat_id = "{{$chat_id}}";
    $.ajax({
      url: BASEURL + '/discussions/fetch-comments/'+chat_id,
      dataType:'json',
      beforeSend:function(){
          // showLoader();
      },
      success: function (data) {
          // hideLoader();
          $(".step").html(data.contents);
          
      },
      error:function(){
        internalError();
      }
    });
  }
  $(document).on('ready', function () {
    
    $('.js-count-characters').each(function () {
      new HSCountCharacters($(this)).init()
    });
    $(".js-file-attach-reset-img").click(function(){
      $("#customFileExample5").html("Choose file to upload");
    });
    $("#submitbtn").click(function(){
      
      var formData = new FormData();
      var _isvalid = 0;
      formData.append("_token",csrf_token);
      formData.append("chat_id","{{ $chat_id }}");
      if($("#message").val() != ''){
        _isvalid = 1;
        formData.append("message",$("#message").val());
      }
      if($('#fileAttachmentBtn').val() != ''){
        _isvalid = 1;
        formData.append('file', $('#fileAttachmentBtn')[0].files[0]);
      }
      if(_isvalid == 0){
        errorMessage("No value to send");
        return false;
      }
      var url  = "{{ baseUrl('discussions/send-comment') }}";
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
  });
</script>

@endsection