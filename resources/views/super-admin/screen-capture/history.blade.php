@extends('layouts.master')


@section('breadcrumb')
<!-- Content -->
<ol class="breadcrumb breadcrumb-no-gutter">
  <li class="breadcrumb-item"><a class="breadcrumb-link" href="{{ baseUrl('/') }}">Dashboard</a></li>
  <li class="breadcrumb-item active">Screen Capture</li>
 
</ol>
<!-- End Content -->
@endsection

@section('header-right')
 <a class="btn btn-primary" href="{{ baseUrl('/screen-capture/'.base64_encode($category->id)) }}">
          Back
        </a>
@endsection


@section('content')
<style>
.site-screenshot {
    height: 450px;
    overflow: hidden;
    margin: auto;
}
</style>
<!-- Content -->
<div class="screen_capture">
  <!-- Page Header -->
  <div class="page-header">
    <div class="row align-items-end">
      <div class="col-sm mb-2 mb-sm-0">
        <nav aria-label="breadcrumb">
          <ol class="breadcrumb breadcrumb-no-gutter">
            <li class="breadcrumb-item"><a class="breadcrumb-link" href="{{ baseUrl('/') }}">Dashboard</a></li>
            <li class="breadcrumb-item active" aria-current="page">{{$pageTitle}}</li>
          </ol>
        </nav>

        <h1 class="page-title">{{$pageTitle}}</h1>
      </div>

      <div class="col-sm-auto">
        <a class="btn btn-primary" href="{{ baseUrl('/screen-capture/'.base64_encode($category->id)) }}">
          Back
        </a>
      </div>
    </div>
    <!-- End Row -->
  </div>
  <!-- End Page Header -->
  <div class="card card-sm mb-2">
      <div class="card-body">
        <table class="table table-bordered">
          <tr>
            <th>
              <h2>Page Name</h2>
            </th>
            <td>
                <b>{{$screen_capture->page_name}}</b>
            </td>
          </tr>
          <tr>
            <th>
              <h2>Page Url</h2>
            </th>
            <td>
                <a href="{{$screen_capture->page_url}}" target="_blank">{{$screen_capture->page_url}}</a>
            </td>
          </tr>
        </table>
        <div class="mt-2 mb-2">
          <a class="btn btn-outline-primary" onclick="captureScreen('{{ base64_encode($screen_capture->id) }}')" href="javascript:;" data-href="{{ baseUrl('screen-capture/'.base64_encode($screen_capture->id)) }}">
            <i style="font-size:24px" class="tio-panorama-image"></i> Click to Capture
          </a>
        </div>
      </div>
  </div>

    <div class="card-body">
    <!-- Gallery -->
      <div id="fancyboxGalleryEg" class="js-fancybox row justify-content-sm-center gx-2"
        data-hs-fancybox-options='{
          "selector": "#fancyboxGalleryEg .js-fancybox-item"
        }'>
        @if(!empty($screenhistory))
        @foreach($screenhistory as $page)
        <?php 
            $slug = $page->ScreenCapture->id;
        ?>
        <div class="col-sm-6 mb-4">
          <!-- Card -->
          <div class="card card-sm">
            <div class="card-body text-center">
              <div class="site-screenshot">
                <img class="card-img-top" src="{{ asset('public/uploads/screen-capture/'.$slug.'/'.$page->image_name) }}" alt="Image Description">
              </div>
            </div>
            <div class="card-footer">
              <div class="row">
                <div class="col-md-6">
                  <a class="js-fancybox-item text-body btn btn-warning btn-sm" href="javascript:;" data-toggle="tooltip" data-placement="top" title="View"
                      data-src="{{ asset('public/uploads/screen-capture/'.$slug.'/'.$page->image_name) }}"
                      data-caption="Image">
                    <i class="tio-visible-outlined mr-1"></i> View
                  </a>
                  <a class="btn btn-danger btn-sm text-white" href="javascript:;" data-toggle="tooltip" data-placement="top" title="Delete Screenshot"
                    onclick="confirmAction(this)" data-href="{{ baseUrl('screen-capture/'.base64_encode($category->id).'/delete-screenshot/'.base64_encode($page->id)) }}"
                     >
                    <i class="tio-visible-outlined mr-1"></i> Delete
                  </a>
                </div>
                <div class="col-md-6">
                    <div class="text-danger text-right"><b>Captured Date:</b> {{dateFormat($page->created_at,"d M, Y H:i:s")}}</div>
                </div>
              </div>
            </div>
          </div>
          <!-- End Card -->
        </div>
        @endforeach
        @else
          <div class="col-sm-12 text-center">
              <div class="text-danger">No Screenshot Capture</div>
          </div>
        @endif
      </div>
      <!-- End Gallery -->
    </div>

  </div>
  <!-- End Card -->
</div>
<!-- End Content -->
@endsection

@section('javascript')
<link rel="stylesheet" href="assets/vendor/@fancyapps/fancybox/dist/jquery.fancybox.min.css">
<script src="assets/vendor/@fancyapps/fancybox/dist/jquery.fancybox.min.js"></script>
<script type="text/javascript">
$(document).ready(function(){

  $('.js-fancybox-item').each(function() {
      // var fancybox = $.HSCore.components.HSFancyBox.init($(this));
      $(this).fancybox();
  })
 
})
var category_id = "{{ base64_encode($screen_capture->category_id) }}";
function captureScreen(id){
    $.ajax({
        type: "GET",
        url: BASEURL + '/screen-capture/'+category_id+'/capture/'+id,
        dataType:'json',
        beforeSend:function(){
            showLoader();
        },
        success: function (response) {
            if(response.status == true){
                successMessage(response.message);
                redirect(response.redirect_url);
            }else{
                hideLoader();
                errorMessage(response.message);
            }
        },
        error:function(){
            hideLoader();
            internalError();
        }
    });
}
</script>
@endsection