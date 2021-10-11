@extends('layouts.master')
@section('pageheader')
<!-- Content -->
<div class="">
    <div class="content container" style="height: 25rem;">
        <!-- Page Header -->
        <div class="page-header page-header-light page-header-reset">
            <div class="row align-items-center">
                <div class="col">
                    <h1 class="page-header-title">{{$pageTitle}}</h1>
                </div>
            </div>
            <!-- End Row -->
        </div>
        <!-- End Page Header -->
    </div>
</div> 
<!-- End Content -->
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
<div class="cron_url">
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
        <a class="btn btn-primary" href="{{ baseUrl('/cron-urls') }}">
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
              <h2>Page URL</h2>
            </th>
            <td>
                <a href="{{$record['url']}}" target="_blank">{{$record['url']}}</a>
            </td>
          </tr>
          <tr>
            <th>
              <h2>Schedule Time</h2>
            </th>
            <td>
                {{$record['cron_time'] }}
            </td>
          </tr>
        </table>
        <div class="row">
          <div class="col-md-6">
           
          </div>
          <div class="col-md-6">
            <div class="mt-2 mb-2 text-right">
              <!-- <button onclick="compareImage()" type="button" class="btn btn-warning"><i class="tio-pages-outlined"></i> Compare Image</button> -->
              <div class="w-30 float-right ml-4 text-right">
                <div class="form-control">
                  <div class="custom-control custom-checkbox custom-checkbox-reverse">
                      <input type="checkbox" class="custom-control-input" id="chooseImage">
                      <label class="custom-control-label media align-items-center" for="chooseImage">
                        <i class="tio-agenda-view-outlined text-muted mr-2"></i>
                        <span class="media-body">
                          Compare Images
                        </span>
                      </label>
                    </div>
                </div>
              </div>
              
              <div class="clearfix"></div>
            </div>
           
          </div>
          <div class="col-md-12 text-right">
            <div class="cmp-btn" style='display:none'>
              <button class="btn btn-warning" onclick="showImgDiff('')"> Show Differences</button>
            </div>
          </div>
        </div>
      </div>
  </div>

    <div class="card-body">
    <!-- Gallery -->
      <div id="fancyboxGalleryEg" class="js-fancybox row justify-content-sm-center gx-2"
        data-hs-fancybox-options='{
          "selector": "#fancyboxGalleryEg .js-fancybox-item"
        }'>
        @if(!empty($record['screenshots']))
        @foreach($record['screenshots'] as $page)
        
        <div class="col-sm-4 mb-4">
          <div class="diff_percent">
              <span class="percent"><small>{{ $page['difference_percent'] }}%</small></span>
          </div>
          <!-- Card -->
          <div class="sel-img" style="display:none">
            <div class="form-control">
              <div class="custom-control custom-checkbox custom-checkbox-reverse">
                  <input type="checkbox" class="custom-control-input compare-input" data-img-id="{{ $page['id'] }}" data-img="{{ $image_url.'/'.$page['image_name'] }}" name="compare_image[]" id="screenshot-{{ $page['id'] }}">
                  <label class="custom-control-label media align-items-center" for="screenshot-{{ $page['id'] }}">
                    <i class="tio-agenda-view-outlined text-muted mr-2"></i>
                    <span class="media-body">
                      Choose Image
                    </span>
                  </label>
                </div>
            </div>
          </div>
          <div class="card card-sm">
            <div class="card-body text-center">
              <div class="site-screenshot">
                <img class="card-img-top" src="{{ $image_url.'/'.$page['image_name'] }}" alt="Image Description">
              </div>
            </div>
            <div class="card-footer">
              <div class="row">
                <div class="col-md-6">
                  <div class="btn-group">
                    <a class="js-fancybox-item text-body btn btn-warning btn-sm" href="javascript:;" data-toggle="tooltip" data-placement="top" title="View"
                        data-src="{{ $image_url.'/'.$page['image_name'] }}"
                        data-caption="Image">
                      <i class="tio-visible-outlined mr-1"></i> View
                    </a>
                    {{--<a class="btn btn-danger btn-sm text-white" href="javascript:;" data-toggle="tooltip" data-placement="top" title="Delete Screenshot"
                      onclick="confirmAction(this)" data-href="{{ baseUrl('cron-urls/delete-screenshot/'.base64_encode($category->id).'/delete-screenshot/'.base64_encode($page->id)) }}"
                      >
                      <i class="tio-visible-outlined mr-1"></i> Delete
                    </a> --}}
                  </div>
                </div>
                <div class="col-md-6">
                    <div class="text-danger text-right"><b>Captured Date:</b> {{dateFormat($page['created_at'],"d M, Y H:i:s")}}</div>
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
<!-- Modal -->
<div class="modal fade" id="imgDiffModal" data-backdrop="static" tabindex="-1" role="dialog" aria-labelledby="staticBackdropLabel" aria-hidden="true">
  <div class="modal-dialog modal-xl" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="staticBackdropLabel">Image Difference</h5>
        <button type="button" class="btn btn-xs btn-icon btn-ghost-secondary" data-dismiss="modal" aria-label="Close">
          <i class="tio-clear tio-lg"></i>
        </button>
      </div>
      <div class="modal-body">
        <img id="diffimg" class="img-fluid" />
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-white" data-dismiss="modal">Close</button>
      </div>
    </div>
  </div>
</div>
<!-- End Modal -->
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
  $("#contentForm").submit(function(e){
        e.preventDefault();
        var formData = $("#contentForm").serialize();
        var url  = $("#contentForm").attr('action');
        $.ajax({
            url:url,
            type:"post",
            data:formData,
            dataType:"json",
            beforeSend:function(){
              showLoader();
            },
            success:function(response){
              hideLoader();
              if(response.status == true){
                successMessage(response.message);
              }else{
                validation(response.message);
              }
            },
            error:function(){
              internalError();
            }
        });
    });

    $("#chooseImage").change(function(){
      if($(this).is(":checked")){
        $(".sel-img").show();
      }else{
        $(".sel-img").hide();
      }
    });

    $(".compare-input").change(function(){
      if($(".compare-input:checked").length > 2){
        $(this).prop("checked",false);
        errorMessage("Allowed only two images to select");
      }
      if($(".compare-input:checked").length == 2){
        $(".cmp-btn").show();
      }else{
        $(".cmp-btn").hide();
      }
    })
})

function showImgDiff(id){
  var imgArr = [];
  $(".compare-input:checked").each(function(){
    imgArr.push($(this).attr("data-img-id"));
  })
    $.ajax({
        type: "POST",
        url: BASEURL + '/cron-urls/show-img-diff',
        dataType:'json',
        data:{
          _token:"{{ csrf_token() }}",
          id:"{{ $record['id'] }}",
          image1:imgArr[0],
          image2:imgArr[1],
        },
        beforeSend:function(){
            showLoader();
        },
        success: function (response) {
            hideLoader();
            if(response.status == true){
                $("#imgDiffModal").modal("show");
                $("#diffimg").attr("src",response.image_url);
                // redirect(response.redirect_url);
            }else{
                
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