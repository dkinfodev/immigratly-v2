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
<section class="input-validation">
    <div class="row">
        <div class="col-md-12">
            <div class="card">
                <div class="card-header">
                    <h4 class="card-title">Fill form details</h4>
                </div>
                <div class="card-content">
                    <div class="card-body">
                        <div class="row">
                            <div class="col-md-8">
                                <div class="form-group {{ ($errors->has('additional_block'))?'error':'' }}">
                                    <div class="controls">
                                        <select class="form-control"  name="additional_block" id="additional_block"  data-validation-required-message="This field required">
                                            <option value="">Select Block</option>
                                            <option value="overview">Overview</option>
                                            <option value="language">Language</option>
                                            <option value="expirence">Expirence</option>
                                            <option value="cost">Cost</option>
                                            <option value="education">Education</option>
                                        </select>
                                        @if ($errors->has('additional_block'))
                                            <span class="help-block">
                                                <strong>{{ $errors->first('additional_block') }}</strong>
                                            </span>
                                        @endif
                                    </div>
                                </div>
                            </div>
                            <div  class="col-md-2">
                             <button type="button" onclick="addBlock()" class="btn btn-primary">Add Block</button>
                            </div>
                        </div>
                        <div class="block_overview">
                            <h3>Contents</h3>
                            <ul class="block_content">
                                 @foreach($additional_data as $data)
                                   <li>
                                    <a href="javascript:;" onclick="scrollToSection('block-<?php echo $data->id ?>')">
                                       <i class="fa fa-angle-right"></i> {{$data->title}}
                                    </a>
                                   </li>
                                 @endforeach
                                 <div class="clearfix"></div>
                            </ul>

                        </div>
                        <div class="clearfix"></div>
                        <form id="blockForm" name="blockForm">
                            {{ csrf_field() }}
                            <div class="block_list">
                                
                                @foreach($additional_data as $data)
 
                                <div id="block-{{$data->id}}" class="additional-section p-3">
                                    <input type="hidden" class="orders" name="orders[{{ $data->id }}]" value="{{ $data->sort_order }}"> 
                                    <fieldset class="p-3">
                                        <div class="row">
                                            <div class="col-md-9">
                                                <legend class="float-left">{{ucfirst($data->block)}}: {{$data->title}}</legend>
                                            </div>
                                            <div class="col-md-3">
                                                <button onclick="toggleBlock(this)" type="button" class="btn collapsible badge badge-primary float-right">
                                                    <i class="tio-add"></i>
                                                    <i class="tio-remove" style="display:none"></i>
                                                </button>
                                            </div>
                                        </div>
                                        <div class="clearfix"></div>
                                        <div class="additional-block" style="display:none">
                                            <div class="text-right">
                                                <a href="javascript:;" onclick="showPopup('{{ baseUrl('visa-services/additional-information/edit-block/'.$data->id) }}')" class="badge btn-sm badge-warning"><i class="fa fa-edit"></i> Edit</a>
                                                <a href="javascript:;" onclick="confirmDelete('{{ $data->id }}')" class="badge btn-sm badge-danger"><i class="fa fa-trash"></i> Delete</a>
                                            </div>
                                            <div class="form-group">
                                                <label>Title:{{$data->title}}</label>
                                                <div class="content">
                                                    <?php echo $data->description ?>
                                                </div>
                                            </div>
                                            @if($data->block == 'overview')
                                            <div class="form-group">
                                                <label>Tags</label>
                                                <div class="content">
                                                    <?php
                                                        $additional_data = json_decode($data->additional_data,true);
                                                        $tag_ids = $additional_data['tags'];
                                                        $tags = generalTags($tag_ids);
                                                        foreach($tags as $tag){
                                                            echo "<span class='badge badge-default mr-1'>".$tag->name."</span>";
                                                        }
                                                    ?>
                                                </div>
                                            </div>
                                            @endif
                                            <?php
                                            if($data->block == 'language'){
                                            
                                            $additional_data = json_decode($data->additional_data,true);
                                            foreach($additional_data as $ads){
                                            ?>
                                             <div class="additional-section criteria-list">
                                                <fieldset>
                                                    <legend>Criteria</legend>
                                                    <div class="row pl-2 pr-2">
                                                        <div class="col-md-8">
                                                            <div class="row">
                                                                <div class="col-md-3">
                                                                    <div class="form-group">
                                                                        <label>Listening</label>
                                                                        <div class="form-control">{{$ads['language_requirement']['listening']}}</div>
                                                                    </div>
                                                                </div>
                                                                <div class="col-md-3">
                                                                    <div class="form-group">
                                                                        <label>Reading</label>
                                                                        <div class="form-control">{{$ads['language_requirement']['reading']}}</div>
                                                                    </div>
                                                                </div>
                                                                <div class="col-md-3">
                                                                    <div class="form-group">
                                                                        <label>Writing</label>
                                                                        <div class="form-control">{{$ads['language_requirement']['writing']}}</div>
                                                                    </div>
                                                                </div>
                                                                <div class="col-md-3">
                                                                    <div class="form-group">
                                                                        <label>Speaking</label>
                                                                        <div class="form-control">{{$ads['language_requirement']['speaking']}}</div>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        </div>
                                                        <div class="col-md-4">
                                                            <div class="form-group">
                                                                <label>Testing Agency</label>
                                                                <div class="form-control">{{$ads['testing_agency']}}</div>
                                                            </div>
                                                        </div>  
                                                        <div class="col-md-12">
                                                            <div class="form-group">
                                                                <div class="form-group">
                                                                    <label>Condition:</label> {{$ads['conditional']}}
                                                                </div>
                                                            </div>
                                                            <div class="form-group">
                                                                @if(isset($ads['depend_on_noc']) && $ads['depend_on_noc'] == 1)
                                                                <div class="vs-checkbox-con vs-checkbox-primary">
                                                                    <i class="fa fa-check text-success"></i> Criteria dependent on NOC: {{$ads['noc']}}
                                                                </div>
                                                                @endif
                                                                
                                                                @if(isset($ads['exemption_canada_edu']) && $ads['exemption_canada_edu'] == 1)
                                                                <div class="vs-checkbox-con vs-checkbox-primary">
                                                                    <i class="fa fa-check text-success"></i> Exemption for Canadian Education
                                                                    </div>    
                                                                @endif
                                                            </div>
                                                            @if(isset($ads['ielts_points']) && $ads['ielts_points'] == 1)
                                                            <div class="form-group">
                                                                <label>There points based on IELTS</label>
                                                                <div class="ielts_points">
                                                                    <div class="row">
                                                                        <div class="col-md-9">
                                                                            <div class="row">
                                                                                <div class="col-md-3">
                                                                                    <b>Listening</b>
                                                                                </div>
                                                                                <div class="col-md-3">
                                                                                    <b>Reading</b>
                                                                                </div>
                                                                                <div class="col-md-3">
                                                                                    <b>Writing</b>
                                                                                </div>
                                                                                <div class="col-md-3">
                                                                                    <b>Speaking</b>
                                                                                </div>
                                                                            </div>
                                                                        </div>
                                                                        <div class="col-md-3">
                                                                            <b>Points</b>
                                                                        </div>
                                                                    </div>
                                                                    <?php 
                                                                        $ielts_point = $ads['ielts_point'];
                                                                        for($i=0;$i < count($ads['ielts_point']['listening']);$i++){
                                                                    ?>
                                                                    <div class="row">
                                                                        <div class="col-md-9">
                                                                            <div class="row">
                                                                                <div class="col-md-3">
                                                                                    <div class="form-group">
                                                                                        <div class="form-control"><?php echo $ielts_point['listening'][$i] ?></div>
                                                                                    </div>
                                                                                </div>
                                                                                <div class="col-md-3">
                                                                                    <div class="form-group">
                                                                                        <div class="form-control"><?php echo $ielts_point['reading'][$i] ?></div>
                                                                                    </div>
                                                                                </div>
                                                                                <div class="col-md-3">
                                                                                    <div class="form-group">
                                                                                        <div class="form-control"><?php echo $ielts_point['writing'][$i] ?></div>
                                                                                    </div>
                                                                                </div>
                                                                                <div class="col-md-3">
                                                                                    <div class="form-group">
                                                                                        <div class="form-control"><?php echo $ielts_point['speaking'][$i] ?></div>
                                                                                    </div>
                                                                                </div>
                                                                            </div>
                                                                        </div>
                                                                        <div class="col-md-3">
                                                                            <div class="form-group">
                                                                                <div class="form-control"><?php echo $ielts_point['points'][$i] ?></div>
                                                                            </div>
                                                                        </div>
                                                                    </div>
                                                                    <?php } ?>
                                                                </div>
                                                            </div>
                                                            @endif
                                                        </div>  
                                                    </div>
                                                </fieldset>
                                            </div>   
                                            <?php } 
                                            } ?>
                                            <?php
                                            
                                            if($data->block == 'expirence'){
                                            $additional_data = json_decode($data->additional_data,true);
                                           
                                            foreach($additional_data as $ads){
                                            ?>
                                             <div class="additional-section criteria-list">
                                                <fieldset>
                                                    <legend>Criteria</legend>
                                                    <div class="row pl-2 pr-2">
                                                        <div class="col-md-8">
                                                            <div class="row">
                                                                <div class="col-md-12">
                                                                    <div class="form-group">
                                                                        <label>Expirence</label>
                                                                        <div class="form-control">{{$ads['no_of_expirence']['year']}} Year {{ $ads['no_of_expirence']['month'] }} Month</div>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        </div>
                                                        <div class="col-md-4">
                                                            <div class="form-group">
                                                                <label>Expirence From</label>
                                                                <div class="form-control">{{$ads['expirence_from']}}</div>
                                                            </div>
                                                        </div>  
                                                        <div class="col-md-12">
                                                            <div class="form-group">
                                                                <div class="form-group">
                                                                    <label>Condition:</label> {{$ads['conditional']}}
                                                                </div>
                                                            </div>
                                                            <div class="form-group">
                                                                @if(isset($ads['depend_on_noc']) && $ads['depend_on_noc'] == 1)
                                                                <div class="vs-checkbox-con vs-checkbox-primary">
                                                                    <i class="fa fa-check text-success"></i> Criteria dependent on NOC:
                                                                </div>
                                                                @endif
                                                                
                                                                @if(isset($ads['exemption_canada_edu']) && $ads['exemption_canada_edu'] == 1)
                                                                <div class="vs-checkbox-con vs-checkbox-primary">
                                                                    <i class="fa fa-check text-success"></i> Exemption for Canadian Education
                                                                    </div>    
                                                                @endif
                                                            </div>
                                                            @if(isset($ads['based_on_expirence']) && $ads['based_on_expirence'] == 1)
                                                            <div class="form-group">
                                                                <label>There points based on IELTS</label>
                                                                <div class="ielts_points">
                                                                    <div class="row">
                                                                        <div class="col-md-9">
                                                                            <div class="row">
                                                                                <div class="col-md-12">
                                                                                    <b>Expirence</b>
                                                                                </div>
                                                                            </div>
                                                                        </div>
                                                                        <div class="col-md-3">
                                                                            <b>Points</b>
                                                                        </div>
                                                                    </div>
                                                                    <?php 
                                                                        $expirence_points = $ads['expirence_points'];
                                                                      
                                                                        $exp_count = count($expirence_points['points']);
                                                                        for($i=0;$i < $exp_count;$i++){
                                                                            // $ads['expirence_points']['expirence'] = array_values($ads['expirence_points']['expirence']);
                                                                    ?>
                                                                                <div class="row">
                                                                                    <div class="col-md-9">
                                                                                        <div class="row">
                                                                                            <div class="col-md-12">
                                                                                                <div class="form-group">
                                                                                                    <div class="form-control"><?php echo $expirence_points['expirence']['year'][$i] ?> Year <?php echo $expirence_points['expirence']['month'][$i] ?> Month</div>
                                                                                                </div>
                                                                                            </div>
                                                                                            
                                                                                        </div>
                                                                                    </div>
                                                                                    <div class="col-md-3">
                                                                                        <div class="form-group">
                                                                                            <div class="form-control"><?php echo $expirence_points['points'][$i] ?></div>
                                                                                        </div>
                                                                                    </div>
                                                                                </div>
                                                                    <?php } ?>
                                                                </div>
                                                            </div>
                                                            @endif
                                                        </div>  
                                                    </div>
                                                </fieldset>
                                            </div>   
                                            <?php } 
                                            } ?>

                                            <?php
                                            if($data->block == 'cost'){
                                                $additional_data = json_decode($data->additional_data,true);
                                            ?>
                                            <div class="additional-section criteria-list">
                                                <fieldset>
                                                    <legend>Criteria</legend>
                                                    <div class="pl-2 pr-2">
                                                        <div class="row">
                                                            <div class="col-md-4">
                                                                <b>Label</b>
                                                            </div>
                                                            <div class="col-md-4">
                                                                <b>Cost</b>
                                                            </div>
                                                            <div class="col-md-4">
                                                                <b>Fees Type</b>
                                                            </div>
                                                        </div>
                                                        <?php
                                                            foreach($additional_data as $ads){
                                                                $count = count($ads['label']);
                                                                for($i=0;$i < $count;$i++){
                                                        ?>
                                                                <div class="row">
                                                                    <div class="col-md-4">
                                                                        <?php echo $ads['label'][$i] ?>
                                                                    </div>
                                                                    <div class="col-md-4">
                                                                        <?php echo $ads['cost'][$i] ?>
                                                                    </div>
                                                                    <div class="col-md-4">
                                                                        <?php echo $ads['fees_type'][$i] ?>
                                                                    </div>
                                                                </div>
                                                        <?php } ?>
                                                        <div class="form-group {{ ($errors->has('title'))?'error':'' }}">
                                                            <label>Comment</label>
                                                            <div class="controls">
                                                                {{$ads['comment']}}
                                                                @if ($errors->has('title'))
                                                                    <span class="help-block">
                                                                        <strong>{{ $errors->first('title') }}</strong>
                                                                    </span>
                                                                @endif
                                                            </div>
                                                        </div>
                                                        <?php } ?>  
                                                    </div>
                                                    </fieldset>
                                                </div>
                                            <?php
                                            }
                                            ?>
                                            <?php
                                            if($data->block == 'education'){
                                            
                                            $additional_data = json_decode($data->additional_data,true);
                                            foreach($additional_data as $ads){
                                            ?>
                                             <div class="additional-section criteria-list">
                                                <fieldset>
                                                    <legend>Criteria</legend>
                                                    <div class="row pl-2 pr-2">
                                                        <div class="col-md-8">
                                                            <div class="row">
                                                                <div class="col-md-12">
                                                                    <div class="form-group">
                                                                        <label>Education</label>
                                                                        <div class="form-control">{{$ads['education']}}</div>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        </div>
                                                        <div class="col-md-4">
                                                            <div class="form-group">
                                                                <label>Education From</label>
                                                                <div class="form-control">{{$ads['education_from']}}</div>
                                                            </div>
                                                        </div>  
                                                        <div class="col-md-12">
                                                            <div class="form-group">
                                                                <div class="form-group">
                                                                    <label>Condition:</label> {{$ads['conditional']}}
                                                                </div>
                                                            </div>
                                                            <div class="form-group">
                                                                @if(isset($ads['depend_on_noc']) && $ads['depend_on_noc'] == 1)
                                                                <div class="vs-checkbox-con vs-checkbox-primary">
                                                                    <i class="fa fa-check text-success"></i> Criteria dependent on NOC: {{$ads['noc']}}
                                                                </div>
                                                                @endif
                                                                
                                                                @if(isset($ads['exemption_canada_edu']) && $ads['exemption_canada_edu'] == 1)
                                                                <div class="vs-checkbox-con vs-checkbox-primary">
                                                                    <i class="fa fa-check text-success"></i> Exemption for Canadian Education
                                                                    </div>    
                                                                @endif
                                                            </div>
                                                            @if(isset($ads['ielts_points']) && $ads['ielts_points'] == 1)
                                                            <div class="form-group">
                                                                <label>There points based on IELTS</label>
                                                                <div class="ielts_points">
                                                                    <div class="row">
                                                                        <div class="col-md-9">
                                                                            <div class="row">
                                                                                <div class="col-md-12">
                                                                                    <b>Education</b>
                                                                                </div>
                                                                            </div>
                                                                        </div>
                                                                        <div class="col-md-3">
                                                                            <b>Points</b>
                                                                        </div>
                                                                    </div>
                                                                    <?php 
                                                                        $ielts_point = $ads['ielts_point'];
                                                                        for($i=0;$i < count($ads['ielts_point']['education']);$i++){
                                                                    ?>
                                                                    <div class="row">
                                                                        <div class="col-md-9">
                                                                            <div class="row">
                                                                                <div class="col-md-12">
                                                                                    <div class="form-group">
                                                                                        <div class="form-control"><?php echo $ielts_point['education'][$i] ?></div>
                                                                                    </div>
                                                                                </div>
                                                                            </div>
                                                                        </div>
                                                                        <div class="col-md-3">
                                                                            <div class="form-group">
                                                                                <div class="form-control"><?php echo $ielts_point['points'][$i] ?></div>
                                                                            </div>
                                                                        </div>
                                                                    </div>
                                                                    <?php } ?>
                                                                </div>
                                                            </div>
                                                            @endif
                                                        </div>  
                                                        <div class="form-group {{ ($errors->has('title'))?'error':'' }}">
                                                            @if(isset($ads['comment']))
                                                            <label>Comment</label>
                                                            <div class="controls">
                                                                {{$ads['comment']}}
                                                                
                                                            </div>
                                                            @endif
                                                        </div>
                                                    </div>
                                                </fieldset>
                                            </div>   
                                            <?php } 
                                            } ?>
                                        </div>
                                    </fieldset>
                                </div>
                                @endforeach
                            </div>  
                        </form> 
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>
@stop

@section("javascript")
<link rel="stylesheet" href="//code.jquery.com/ui/1.12.1/themes/base/jquery-ui.css">
<script src="https://code.jquery.com/ui/1.12.1/jquery-ui.js"></script>
<script type="text/javascript">
var blocks = [];
function addBlock(){
    var block = $("#additional_block").val();
    if(block == ''){
        errorMessage("Please select the block!");
        return false;

    }
    var exists = 0;
    $(".additional-section").each(function(){
        var id = $(this).attr("id");
        if(id == block){
            exists = 1;
        }
    })
    if(exists == 0){
        showPopup('{{ baseUrl("visa-services/additional-information/".base64_encode($visa_service->id)."/add-block?block=") }}'+block+"&visa_type_id={{$visa_service->id}}");
    }else{
        errorMessage("Block already exists");
        return false;
    }
    // $.ajax({
    //     url:"{{ baseUrl('/visa-services/additional-information/add-block') }}",
    //     type:"post",
    //     data:{
    //         _token:csrf_token,
    //         visa_type_id:"{{$visa_service->id}}",
    //         block:block,
    //     },
    //     beforeSend:function(){
    //         showLoader();
    //     },
    //     success:function(response){
    //       hideLoader();
    //       if(response.status == true){
    //           $(".block_list").append(response.contents);
    //           $("#additional_block").val('').trigger("change");
    //           $('html, body').animate({
    //                 scrollTop: ($('#'+block).offset().top-200)
    //          },500);
    //       }else{
    //         errorMessage(response.message);
    //       }
    //     },
    //     error:function(){
    //         hideLoader();
    //         internalServerError();
    //     }
    // });
}
function confirmDelete(id){
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
            url: BASEURL + '/visa-services/additional-information/delete-block',
            data:{
                _token:csrf_token,
                id:id,
            },
            dataType:'json',
            success: function (result) {
                if(result.status == true){
                    Swal.fire({
                        type: "success",
                        title: 'Deleted!',
                        text: 'Your record has been deleted.',
                        confirmButtonClass: 'btn btn-success',
                    }).then(function () {
                        location.reload();
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
            error:function(){
                hideLoader();
                internalServerError();
            }
        });
      }
    })
}
function scrollToSection(block){
     $('html, body').animate({
            scrollTop: ($('#'+block).offset().top-200)
     },500);
}
function toggleBlock(e){
    $(e).find(".fa-plus").toggle();
    $(e).find(".fa-minus").toggle();
    $(e).parents(".additional-section").find(".additional-block").slideToggle();
}
$(document).ready(function(){
    $( ".block_list" ).sortable();
    $( ".block_list" ).sortable({
        stop: function( ) {
            var order = 1;
            $(".orders").each(function(){
                $(this).val(order);
                order++;
            });

            $.ajax({
                url:"{{ baseUrl('/visa-services/additional-information/change-block-order') }}",
                type:"post",
                data:$("#blockForm").serialize(),
                beforeSend:function(){
                    showLoader();
                },
                success:function(response){
                  hideLoader();
                  if(response.status == true){
                      successMessage(response.message);
                      // location.reload();
                  }else{
                    errorMessage(response.message);
                  }
                },
                error:function(){
                    hideLoader();
                    internalServerError();
                }
            })     
        }
    });
})
</script>
@stop