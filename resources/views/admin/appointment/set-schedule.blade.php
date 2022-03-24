@extends('layouts.master')

@section('breadcrumb')
<!-- Content -->
<ol class="breadcrumb breadcrumb-no-gutter">
  <li class="breadcrumb-item"><a class="breadcrumb-link" href="{{ baseUrl('/') }}">Dashboard</a></li>
  <li class="breadcrumb-item active" aria-current="page">{{$pageTitle}}</li>
</ol>
<!-- End Content -->
@endsection

@section('header-right')
    
    <a class="btn btn-primary float-right" onclick="showPopup('<?php echo baseUrl('custom-time/'.$location_id.'/add') ?>')" href="javascript:;">
            Customized Time
    </a>

    
    <!-- <div class="hs-unfold">
        <a class="js-hs-action btn btn-sm btn-white" href="javascript:;"
          data-hs-unfold-options='{
            "target": "#action",
            "type": "css-animation"
          }'>More  <i class="tio-chevron-down ml-1"></i>
        </a>
        <div id="action" class="hs-unfold-content dropdown-unfold dropdown-menu dropdown-menu-right">

          <i class="tio-edit dropdown-item-icon"></i>
          Edit
          
          <a class="dropdown-item" href="{{baseUrl('/')}}">
          <i class="tio-globe dropdown-item-icon"></i>
          View
          </a>
          
        </div>
    </div> -->
   
@endsection



@section('content')
<?php $hours = 24; ?>
<link rel="stylesheet" href="assets/vendor/quill/dist/quill.snow.css">
<style type="text/css">
.page-header-tabs {
    margin-bottom: 0px !important;
}
</style>
<!-- Content -->


<!-- Content -->
<div class="case-list">


  <!-- Card -->
  <div class="card">
    
    <div class="card-body">
        
    <form id="form" class="js-validate" action="{{ baseUrl('appointment/'.$location_id.'/save-schedule') }}" method="post">
    
    @csrf
        
        <div class="row mb-3">
            <div class="col-md-4">

            </div>
            <div class="col-md-8">
                <div class="row">
                    <div class="col-md-6 h5">
                        <label>From (24 Hrs)</label>
                    </div>
                    <div class="col-md-6 h5">
                        <label>To (24 Hrs)</label>
                    </div>
                </div>
            </div>
        </div>
<?php
    $days = array("monday","tuesday","wednesday","thursday","friday","saturday","sunday");
    for($d=0;$d < count($days);$d++){
      
?>
    <div class="row item-row">
            <div class="col-md-4 mt-3">
                <div class="row">
                    <div class="col-md-3">
                    <!-- <input type="checkbox" name="monday" id="monday" value="1" > -->
                        <div class="custom-control custom-checkbox">
                            <input <?php echo (isset($schedules[$days[$d]]))?'checked':'' ?> type="checkbox" class="custom-control-input row-checkbox" name="schedule[{{$d}}][day]" value="{{ $days[$d] }}" id="row-{{$d}}">
                            <label class="custom-control-label" for="row-{{$d}}"></label>
                        </div>
                    </div>
                    <div class="col-md-6 h5">
                    <label for="{{ ucfirst($days[$d]) }}">{{ ucfirst($days[$d]) }}</label>
                    </div>
                </div>
            </div>
            <div class="col-md-8">
                <div class="row">
                    <div class="col-md-6">
                        <!-- <label>From</label> -->
                        <div class="form-group">
                            <!-- <label for="HourLabel" class="input-label">FromHour</label> -->
                            <input type="text" class="js-masked-input form-control from" required  <?php echo (!isset($schedules[$days[$d]]))?'disabled':'' ?> id="from-hour-{{$d}}" name="schedule[{{$d}}][from]" placeholder="xx:xx"
                                value="<?php echo (isset($schedules[$days[$d]]))?$schedules[$days[$d]]['from']:'' ?>"
                                data-hs-mask-options='{
                                "template": "00:00"
                                }'>
                        </div>
                        <!-- <select class="form-control" name="mon_from" id="mon_from">
                            <option value="">Select</option>
                            @for($i=0;$i<$hours;$i++)
                            <option value="{{$i}}">{{$i}}</option>
                            @endfor
                        </select> -->
                    </div>
                    <div class="col-md-6">
                        <!-- <label>To</label> -->
                        <div class="form-group">
                            <!-- <label for="HourLabel" class="input-label">FromHour</label> -->
                            <input type="text" class="js-masked-input form-control to" required  <?php echo (!isset($schedules[$days[$d]]))?'disabled':'' ?> id="to-hour-{{$d}}" name="schedule[{{$d}}][to]" placeholder="xx:xx"
                                value="<?php echo (isset($schedules[$days[$d]]))?$schedules[$days[$d]]['to']:'' ?>"
                                data-hs-mask-options='{
                                "template": "00:00"
                                }'>
                        </div>
                        <!-- <select class="form-control" name="mon_to" id="mon_to">
                            <option value="">Select</option>
                            @for($i=0;$i<$hours;$i++)
                            <option value="{{$i}}">{{$i}}</option>
                            @endfor
                        </select> -->
                    </div>
                </div>
            </div>
        </div>
    <?php } ?>

       
        <div class="row text-center mt-4 align-items-center justify-content-center">
            <div class="col-md-2">    
              <div class="form-group">
                <button type="submit" class="btn add-btn btn-primary">Add</button>
              </div>
            </div>
        </div>

    </form>    


    @if(count($customTime)>0)
    <div class="row mt-5">
      <h4>Custom Time</h4>  
      <div class="col-md-12 datatable-custom mt-5">
        <table class="table table-lg table-borderless table-thead-bordered table-nowrap table-align-middle card-table">
        <tr>
          <th>Date</th>
          <th>Type</th>
          <th>Description</th>
          <th>From</th>
          <th>To</th>
          <th>Action</th>
        </tr>

        @foreach($customTime as $key=>$cT)
          <tr>
            <td>{{dateFormat($cT->custom_date,'d-m-Y')}}</td>
            <td>{{$cT->type}}</td>
            <td>
                @if(!empty($cT->description))
                {{$cT->description}}
                @else
                <span class="text-danger">-</span>  
                @endif
            </td>
            <td>
              @if(!empty($cT->from_time))
              {{$cT->from_time}}
              @else
              <span class="text-danger">-</span>
              @endif
            </td>
            <td>
              @if(!empty($cT->to_time))
              {{$cT->to_time}}
              @else
              <span class="text-danger">-</span>
              @endif
            </td>
            <td>
            <a onclick="showPopup('<?php echo baseUrl('custom-time/'.$location_id.'/edit/'.base64_encode($cT->id)) ?>')" href="javascript:;"><i class="tio-edit"></i></a>
            <a onclick="confirmAction(this)" href="javascript:;" data-href="{{baseUrl('custom-time/'.$location_id.'/delete/'.base64_encode($cT->id))}}"><i class="tio-delete"></i></a>
            </td>
          </tr>
        @endforeach
        </table>
      </div>
    </div>
    @endif
    </div> <!-- card body -->

  </div>
  <!-- End Card -->

</div>
<!-- End Content -->

@endsection


@section('javascript')

<!-- JS Implementing Plugins -->
<script src="assets/vendor/hs-navbar-vertical-aside/hs-navbar-vertical-aside.min.js"></script>
<script src="assets/vendor/hs-nav-scroller/dist/hs-nav-scroller.min.js"></script>
<script src="assets/vendor/hs-go-to/dist/hs-go-to.min.js"></script>
<script src="assets/vendor/list.js/dist/list.min.js"></script>
<script src="assets/vendor/prism/prism.js"></script>
<script src="assets/vendor/hs-step-form/dist/hs-step-form.min.js"></script>
<script src="assets/vendor/jquery-validation/dist/jquery.validate.min.js"></script>
<!-- JS Front -->
<script src="assets/vendor/jquery-mask-plugin/dist/jquery.mask.min.js"></script>

<script src="assets/vendor/quill/dist/quill.min.js"></script>

<script>
    
$(document).on('ready', function () {
    $('.js-masked-input').each(function () {
      $.HSCore.components.HSMask.init($(this));
    });

    $(".row-checkbox").change(function(){
        if($(this).is(":checked")){
            $(this).parents(".item-row").find(".from").removeAttr("disabled");
            $(this).parents(".item-row").find(".to").removeAttr("disabled");
        }else{
            $(this).parents(".item-row").find(".from").attr("disabled","disabled");
            $(this).parents(".item-row").find(".to").attr("disabled","disabled");
        }
    })
    $("#form").submit(function(e){
      e.preventDefault();
      var formData = new FormData($(this)[0]);
      var url  = $("#form").attr('action');
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
            location.reload();
          }else{
            validation(response.message);
          }
        },
        error:function(){
            internalError();
        }
      });
      
    });
  });
  
  function confirmDelete(e){

    var id = e.id;
    var url1 = e.attr("data-href");
    alert(url1);
    Swal.fire({
      title: 'Are you sure?',
      text: "You won't be able to revert this!",
      type: 'warning',
      showCancelButton: true,
      confirmButtonColor: '#3085d6',
      cancelButtonColor: '#d33',
      confirmButtonText: 'Yes, delete it!',
      confirmButtonClass: 'btn btn-primary',
      cancelButtonClass: 'btn btn-danger ml-1',
      buttonsStyling: false,
    }).then(function(result) {
      if (result.value) {
        $.ajax({
            type: "POST",
            url: url1,
            data:{
                _token:csrf_token,
                user_id:id,
            },
            dataType:'json',
            success: function (result) {
                if(result.status == true){
                    Swal.fire({
                        type: "success",
                        title: 'Deleted!',
                        text: 'Record has been deleted.',
                        confirmButtonClass: 'btn btn-success',
                    }).then(function () {
                        window.location.href= result.redirect;
                    });
                }else{
                    Swal.fire({
                        title: "Error!",
                        text: "Error while deleting",
                        type: "error",
                        confirmButtonClass: 'btn btn-primary',
                        buttonsStyling: false,
                    });
                }
            },
        });
      }
    })
}
</script>
@endsection