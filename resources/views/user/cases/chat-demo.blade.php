@extends('layouts.master')
@section('style')
<style>
   textarea::-webkit-scrollbar {
      display: none;
      resize: none;
   }
   textarea{
      resize: none;
   }
</style>
@endsection

@section('breadcrumb')
<!-- Content -->
<ol class="breadcrumb breadcrumb-no-gutter">
  <li class="breadcrumb-item"><a class="breadcrumb-link" href="{{ baseUrl('/') }}">Dashboard</a></li>
  <li class="breadcrumb-item"><a class="breadcrumb-link" href="{{ baseUrl('/cases') }}">Cases</a></li>
  <li class="breadcrumb-item active" aria-current="page">{{$pageTitle}}</li>
</ol><!-- End Content -->
@endsection

@section('content')
<!-- Content -->
<div class="content container-fluid">
  
  <div class="card purple lighten-4 chat-room">
  <div class="card-body">

    <!-- Grid row -->
    <div class="row">

      <div class="col-md-2"></div>
      <!-- Grid column -->
      <div class="col-md-6 col-xl-8 pr-md-4 px-lg-auto px-0">

        <div class="chat-message">

          <ul class="list-unstyled chat">
            <li class="d-flex justify-content-between mb-4">
              <img src="https://mdbootstrap.com/img/Photos/Avatars/avatar-6.jpg" alt="avatar" class="avatar rounded-circle mr-2 ml-0 z-depth-1">
              <div class="chat-body white p-3 ml-2 z-depth-1">
                <div class="header">
                  <strong class="primary-font">Brad Pitt</strong>
                  <small class="pull-right text-muted"><i class="far fa-clock"></i> 12 mins ago</small>
                </div>
                <hr class="w-100">
                <p class="mb-0">
                  Lorem ipsum dolor sit amet,
                </p>
              </div>
            </li>
            <li class="d-flex justify-content-between mb-4">
              <div class="chat-body white p-3 z-depth-1">
                <div class="header">
                  <strong class="primary-font">Lara Croft</strong>
                  <small class="pull-right text-muted"><i class="far fa-clock"></i> 13 mins ago</small>
                </div>
                <hr class="w-100">
                <p class="mb-0">
                  Sed ut perspiciatis unde omnis 
                </p>
              </div>
              <img src="https://mdbootstrap.com/img/Photos/Avatars/avatar-5.jpg" alt="avatar" class="avatar rounded-circle mr-0 ml-3 z-depth-1">
            </li>
            <li class="d-flex justify-content-between mb-4 pb-3">
              <img src="https://mdbootstrap.com/img/Photos/Avatars/avatar-6.jpg" alt="avatar" class="avatar rounded-circle mr-2 ml-0 z-depth-1">
              <div class="chat-body white p-3 ml-2 z-depth-1">
                <div class="header">
                  <strong class="primary-font">Brad Pitt</strong>
                  <small class="pull-right text-muted"><i class="far fa-clock"></i> 12 mins ago</small>
                </div>
                <hr class="w-100">
                <p class="mb-0">
                  Lorem ipsum dolor sit amet, 
                </p>
              </div>
            </li>
            <li class="white">
              <form class="form">  
                <div class="row">
                  <div class="col-7 col-md-9">
                    <div class="form-group basic-textarea">
                      <textarea class="form-control" rows=2 style="border:1px solid #377dff !important;padding: 1px 12px;border-radius:34px;margin-left:0px;"></textarea>
                    </div>
                  </div>

                  <div class="col-5 col-md-3">
                   <button type="button" class="btn btn-primary btn-md" style="background:#377dff;border-radius: 50%;margin-left:-10px;border:0;"><i class="tio-send"></i></button>
                   <button id="yourBtn" type="button" class="btn btn-primary btn-md" style="background:#00c9db;border-radius: 50%;border:0;margin-left:10px;cursor:pointer;"><i class="tio-attachment" onclick="getFile()"></i></button>
                 </div>
               </div>
               <div style='height: 0px;width:0px; overflow:hidden;'><input id="upfile" type="file" value="upload"/></div>
              </form>
            
            </li>
            
          </ul>

        </div>

      </div>
      <!-- Grid column -->

      <!-- Grid column 
      <div class="col-md-6 col-xl-4 px-0">

        <h6 class="font-weight-bold mb-3 text-center text-lg-left">Member</h6>
        <div class="white z-depth-1 px-3 pt-3 pb-0">
          <ul class="list-unstyled friend-list">
            <li class="active grey lighten-3 p-2">
              <a href="#" class="d-flex justify-content-between">
                <img src="https://mdbootstrap.com/img/Photos/Avatars/avatar-8.jpg" alt="avatar" class="avatar rounded-circle d-flex align-self-center mr-2 z-depth-1">
                <div class="text-small">
                  <strong>John Doe</strong>
                  <p class="last-message text-muted">Hello, Are you there?</p>
                </div>
                <div class="chat-footer">
                  <p class="text-smaller text-muted mb-0">Just now</p>
                  <span class="badge badge-danger float-right">1</span>
                </div>
              </a>
            </li>
            <li class="p-2">
              <a href="#" class="d-flex justify-content-between">
                <img src="https://mdbootstrap.com/img/Photos/Avatars/avatar-1.jpg" alt="avatar" class="avatar rounded-circle d-flex align-self-center mr-2 z-depth-1">
                <div class="text-small">
                  <strong>Danny Smith</strong>
                  <p class="last-message text-muted">Lorem ipsum dolor sit.</p>
                </div>
                <div class="chat-footer">
                  <p class="text-smaller text-muted mb-0">5 min ago</p>
                  <span class="text-muted float-right"><i class="fas fa-mail-reply" aria-hidden="true"></i></span>
                </div>
              </a>
            </li>
            <li class="p-2">
              <a href="#" class="d-flex justify-content-between">
                <img src="https://mdbootstrap.com/img/Photos/Avatars/avatar-2.jpg" alt="avatar" class="avatar rounded-circle d-flex align-self-center mr-2 z-depth-1">
                <div class="text-small">
                  <strong>Alex Steward</strong>
                  <p class="last-message text-muted">Lorem ipsum dolor sit.</p>
                </div>
                <div class="chat-footer">
                  <p class="text-smaller text-muted mb-0">Yesterday</p>
                  <span class="text-muted float-right"><i class="fas fa-mail-reply" aria-hidden="true"></i></span>
                </div>
              </a>
            </li>
            <li class="p-2">
              <a href="#" class="d-flex justify-content-between">
                <img src="https://mdbootstrap.com/img/Photos/Avatars/avatar-3.jpg" alt="avatar" class="avatar rounded-circle d-flex align-self-center mr-2 z-depth-1">
                <div class="text-small">
                  <strong>Ashley Olsen</strong>
                  <p class="last-message text-muted">Lorem ipsum dolor sit.</p>
                </div>
                <div class="chat-footer">
                  <p class="text-smaller text-muted mb-0">Yesterday</p>
                  <span class="text-muted float-right"><i class="fas fa-mail-reply" aria-hidden="true"></i></span>
                </div>
              </a>
            </li>
            <li class="p-2">
              <a href="#" class="d-flex justify-content-between">
                <img src="https://mdbootstrap.com/img/Photos/Avatars/avatar-4.jpg" alt="avatar" class="avatar rounded-circle d-flex align-self-center mr-2 z-depth-1">
                <div class="text-small">
                  <strong>Kate Moss</strong>
                  <p class="last-message text-muted">Lorem ipsum dolor sit.</p>
                </div>
                <div class="chat-footer">
                  <p class="text-smaller text-muted mb-0">Yesterday</p>
                  <span class="text-muted float-right"><i class="fas fa-mail-reply" aria-hidden="true"></i></span>
                </div>
              </a>
            </li>
            <li class="p-2">
              <a href="#" class="d-flex justify-content-between">
                <img src="https://mdbootstrap.com/img/Photos/Avatars/avatar-5.jpg" alt="avatar" class="avatar rounded-circle d-flex align-self-center mr-2 z-depth-1">
                <div class="text-small">
                  <strong>Lara Croft</strong>
                  <p class="last-message text-muted">Lorem ipsum dolor sit.</p>
                </div>
                <div class="chat-footer">
                  <p class="text-smaller text-muted mb-0">Yesterday</p>
                  <span class="text-muted float-right"><i class="fas fa-mail-reply" aria-hidden="true"></i></span>
                </div>
              </a>
            </li>
            <li class="p-2">
              <a href="#" class="d-flex justify-content-between">
                <img src="https://mdbootstrap.com/img/Photos/Avatars/avatar-6.jpg" alt="avatar" class="avatar rounded-circle d-flex align-self-center mr-2 z-depth-1">
                <div class="text-small">
                  <strong>Brad Pitt</strong>
                  <p class="last-message text-muted">Lorem ipsum dolor sit.</p>
                </div>
                <div class="chat-footer">
                  <p class="text-smaller text-muted mb-0">5 min ago</p>
                  <span class="text-muted float-right"><i class="fas fa-check" aria-hidden="true"></i></span>
                </div>
              </a>
            </li>
          </ul>
        </div>

      </div>
       Grid column -->

    </div>
    <!-- Grid row -->

  </div>
</div>
  

  
</div>
<!-- End Content -->
@endsection

@section('javascript')
<script type="text/javascript">
$(document).ready(function(){

  $("#datatableSearch").keyup(function(){
    var value = $(this).val();
    if(value == ''){
      loadData();
    }
    if(value.length > 3){
      loadData();
    }
  });
  
});
loadData();
function loadData(page=1){
  var search = $("#datatableSearch").val();
    $.ajax({
        type: "POST",
        url: BASEURL + '/cases/ajax-list?page='+page,
        data:{
            _token:csrf_token,
            search:search
        },
        dataType:'json',
        beforeSend:function(){
            var cols = $("#tableList thead tr > th").length;
            // $("#tableList tbody").html('<tr><td colspan="'+cols+'"><center><i class="fa fa-spin fa-spinner fa-3x"></i></center></td></tr>');
            // $("#paginate").html('');
            showLoader();
        },
        success: function (data) {
            hideLoader();
            $("#tableList tbody").html(data.contents);
            initPagination(data);
            
        },
        error:function(){
          internalError();
        }
    });
}


function getFile(){
     document.getElementById("upfile").click();
}

</script>
@endsection