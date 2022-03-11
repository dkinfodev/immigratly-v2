@extends('layouts.master')

@section('breadcrumb')
<!-- Content -->
<ol class="breadcrumb breadcrumb-no-gutter">
  <li class="breadcrumb-item"><a class="breadcrumb-link" href="{{ baseUrl('/') }}">Dashboard</a></li>
  <li class="breadcrumb-item active" aria-current="page">{{$pageTitle}}</li>
</ol>
<!-- End Content -->
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
        
    <form id="form" class="js-validate" action="{{ baseUrl('appointment/save-schedule') }}" method="post">
    
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

        {{-- 
        <div class="row">
            <div class="col-md-4 mt-3">
                <div class="row">
                    <div class="col-md-3">
                    <input type="checkbox" name="monday" id="monday" value="1" >
                    </div>
                    <div class="col-md-6 h5">
                    <label for="monday">Monday</label>
                    </div>
                </div>
            </div>
            <div class="col-md-8">
                <div class="row">
                    <div class="col-md-6">
                        <!-- <label>From</label> -->
                        <select class="form-control" name="mon_from" id="mon_from">
                            <option value="">Select</option>
                            @for($i=0;$i<$hours;$i++)
                            <option value="{{$i}}">{{$i}}</option>
                            @endfor
                        </select>
                    </div>
                    <div class="col-md-6">
                        <!-- <label>To</label> -->
                        <select class="form-control" name="mon_to" id="mon_to">
                            <option value="">Select</option>
                            @for($i=0;$i<$hours;$i++)
                            <option value="{{$i}}">{{$i}}</option>
                            @endfor
                        </select>
                    </div>
                </div>
            </div>
        </div>

        <div class="row mt-4">
            <div class="col-md-4 mt-3">
                <div class="row">
                    <div class="col-md-3">
                    <input type="checkbox" name="tuesday" id="tuesday" value="1">
                    </div>
                    <div class="col-md-6 h5">
                    <label for="tuesday">Tuesday</label>
                    </div>
                </div>
            </div>
            <div class="col-md-8">
                <div class="row">
                    <div class="col-md-6">
                        <!-- <label>From</label> -->
                        <select class="form-control" name="tue_from" id="tue_from">
                            <option value="">Select</option>
                            @for($i=0;$i<$hours;$i++)
                            <option value="{{$i}}">{{$i}}</option>
                            @endfor
                        </select>
                    </div>
                    <div class="col-md-6">
                        <!-- <label>To</label> -->
                        <select class="form-control" name="tue_to" id="tue_to">
                            <option value="">Select</option>
                            @for($i=0;$i<$hours;$i++)
                            <option value="{{$i}}">{{$i}}</option>
                            @endfor
                        </select>
                    </div>
                </div>
            </div>
        </div>

        <div class="row mt-4">
            <div class="col-md-4 mt-3">
                <div class="row">
                    <div class="col-md-3">
                    <input type="checkbox" name="wednesday" id="wednesday" value="1">
                    </div>
                    <div class="col-md-6 h5">
                    <label for="wednesday">Wednesday</label>
                    </div>
                </div>
            </div>
            <div class="col-md-8">
                <div class="row">
                    <div class="col-md-6">
                        <!-- <label>From</label> -->
                        <select class="form-control" name="wed_from" id="wed_from">
                            <option value="">Select</option>
                            @for($i=0;$i<$hours;$i++)
                            <option value="{{$i}}">{{$i}}</option>
                            @endfor
                        </select>
                    </div>
                    <div class="col-md-6">
                        <!-- <label>To</label> -->
                        <select class="form-control" name="wed_to" id="wed_to">
                            <option value="">Select</option>
                            @for($i=0;$i<$hours;$i++)
                            <option value="{{$i}}">{{$i}}</option>
                            @endfor
                        </select>
                    </div>
                </div>
            </div>
        </div>

        <div class="row mt-4">
            <div class="col-md-4 mt-3">
                <div class="row">
                    <div class="col-md-3">
                    <input type="checkbox" name="thursday" id="thursday" value="1">
                    </div>
                    <div class="col-md-6 h5">
                    <label for="thursday">Thursday</label>
                    </div>
                </div>
            </div>
            <div class="col-md-8">
                <div class="row">
                    <div class="col-md-6">
                        <!-- <label>From</label> -->
                        <select class="form-control" name="thu_from" id="thu_from">
                            <option value="">Select</option>
                            @for($i=0;$i<$hours;$i++)
                            <option value="{{$i}}">{{$i}}</option>
                            @endfor
                        </select>
                    </div>
                    <div class="col-md-6">
                        <!-- <label>To</label> -->
                        <select class="form-control" name="thu_to" id="thu_to">
                            <option value="">Select</option>
                            @for($i=0;$i<$hours;$i++)
                            <option value="{{$i}}">{{$i}}</option>
                            @endfor
                        </select>
                    </div>
                </div>
            </div>
        </div>

        <div class="row mt-4">
            <div class="col-md-4 mt-3">
                <div class="row">
                    <div class="col-md-3">
                    <input type="checkbox" name="friday" id="friday" value="1">
                    </div>
                    <div class="col-md-6 h5">
                    <label for="friday">Friday</label>
                    </div>
                </div>
            </div>
            <div class="col-md-8">
                <div class="row">
                    <div class="col-md-6">
                        <!-- <label>From</label> -->
                        <select class="form-control" name="fri_from" id="fri_from">
                            <option value="">Select</option>
                            @for($i=0;$i<$hours;$i++)
                            <option value="{{$i}}">{{$i}}</option>
                            @endfor
                        </select>
                    </div>
                    <div class="col-md-6">
                        <!-- <label>To</label> -->
                        <select class="form-control" name="fri_to" id="fri_to">
                            <option value="">Select</option>
                            @for($i=0;$i<$hours;$i++)
                            <option value="{{$i}}">{{$i}}</option>
                            @endfor
                        </select>
                    </div>
                </div>
            </div>
        </div>

        <div class="row mt-4">
            <div class="col-md-4 mt-3">
                <div class="row">
                    <div class="col-md-3">
                    <input type="checkbox" name="saturday" id="saturday" value="1">
                    </div>
                    <div class="col-md-6 h5">
                    <label for="saturday">Saturday</label>
                    </div>
                </div>
            </div>
            <div class="col-md-8">
                <div class="row">
                    <div class="col-md-6">
                        <!-- <label>From</label> -->
                        <select class="form-control" name="sat_from" id="sat_from">
                            <option value="">Select</option>
                            @for($i=0;$i<$hours;$i++)
                            <option value="{{$i}}">{{$i}}</option>
                            @endfor
                        </select>
                    </div>
                    <div class="col-md-6">
                        <!-- <label>To</label> -->
                        <select class="form-control" name="sat_to" id="sat_to">
                            <option value="">Select</option>
                            @for($i=0;$i<$hours;$i++)
                            <option value="{{$i}}">{{$i}}</option>
                            @endfor
                        </select>
                    </div>
                </div>
            </div>
        </div>

        <div class="row mt-4">
            <div class="col-md-4 mt-3">
                <div class="row">
                    <div class="col-md-3">
                    <input type="checkbox" name="sunday" id="sunday" value="1">
                    </div>
                    <div class="col-md-6 h5">
                    <label for="sunday">Sunday</label>
                    </div>
                </div>
            </div>
            <div class="col-md-8">
                <div class="row">
                    <div class="col-md-6">
                        <!-- <label>From</label> -->
                        <select class="form-control" name="sun_from" id="sun_from">
                            <option value="">Select</option>
                            @for($i=0;$i<$hours;$i++)
                            <option value="{{$i}}">{{$i}}</option>
                            @endfor
                        </select>
                    </div>
                    <div class="col-md-6">
                        <!-- <label>To</label> -->
                        <select class="form-control" name="sun_to" id="sun_to">
                            <option value="">Select</option>
                            @for($i=0;$i<$hours;$i++)
                            <option value="{{$i}}">{{$i}}</option>
                            @endfor
                        </select>
                    </div>
                </div>
            </div>
        </div> --}}

        <div class="row text-center mt-4 align-items-center justify-content-center">
            <div class="col-md-2">    
              <div class="form-group">
                <button type="submit" class="btn add-btn btn-primary">Add</button>
              </div>
            </div>
        </div>

    </form>    

    </div>

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
  
</script>
@endsection