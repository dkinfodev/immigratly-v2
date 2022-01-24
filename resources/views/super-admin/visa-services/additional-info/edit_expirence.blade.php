<style>
.additional-section select {
    -moz-appearance: none;
    -webkit-appearance: none;
}

</style>
<div class="modal-dialog modal-xl expirence-modal" role="document">
    <div class="modal-content">
        <div class="modal-header">
            <h5 class="modal-title" id="exampleModalCenterTitle">Expirence</h5>
            <button type="button" class="close" data-dismiss="modal" data-target="addNewCategory" aria-label="Close">
                <span aria-hidden="true">&times;</span>
            </button>
        </div>
        <div class="modal-body">
            <div class="additional-block">
                <form class="form-horizontal" action="{{ baseUrl('/visa-types/update-visa-block/'.$record->id) }}" id="overviewForm" autocomplete="off" method="post" novalidate>
                    {{ csrf_field() }}
                    <input type="hidden" name="visa_type_id" value="{{ $visa_type_id }}">
                    <input type="hidden" name="block" value="expirence">
                    <div class="row">
                        <div class="col-md-12">
                            <div class="form-group {{ ($errors->has('title'))?'error':'' }}">
                                <label>Title</label>
                                <div class="controls">
                                    <input type="text" name="title" value="{{ isset($record->title)?$record->title:old('title') }}" class="form-control" data-validation-required-message="This field is required" placeholder="Name">
                                    @if ($errors->has('title'))
                                        <span class="help-block">
                                            <strong>{{ $errors->first('title') }}</strong>
                                        </span>
                                    @endif
                                </div>
                            </div>
                            <div class="form-group {{ ($errors->has('description'))?'error':'' }}">
                                <label class="mb-1">Description</label>
                                <textarea id="over_desc" name="description">{{ isset($record->description)?$record->description:old('description')  }}</textarea>
                                @if ($errors->has('description'))
                                    <span class="help-block">
                                        <strong>{{ $errors->first('description') }}</strong>
                                    </span>
                                @endif
                            </div>
                            <div class="criteria">
                                <?php
                                    
                                    $count = 1;
                                    $add_data = array();
                                    $additional_data = array();
                                    if(isset($record->additional_data)){
                                        
                                        $add_data = json_decode($record->additional_data,true);
                                        
                                        $count = count($add_data);
                                    }
                                    for($i=0;$i < $count;$i++){
                                        $index = mt_rand(1000,9999);
                                        $additional_data = $add_data[$i];
                                        // pre($additional_data);
                                ?>
                                    <div class="additional-section" data-index="<?php echo $index ?>" id="criteria_<?php echo $index ?>">
                                        <div class='col-md-12 text-right'><span onclick='removeCriteria(this)' class='badge badge-danger criteria-remove'><i class='fa fa-times'></i></span></div>
                                        <fieldset>
                                            <legend>Criteria</legend>
                                            <div class="row additional-block">
                                                <div class="col-md-8">
                                                    <label>Expirence</label>
                                                    <div class="row">
                                                        <div class="col-md-6">
                                                            <div class="form-group">
                                                                <input type="number" name="ads[<?php echo $index ?>][no_of_expirence][year]" value="<?php echo isset($additional_data['no_of_expirence']['year'])?$additional_data['no_of_expirence']['year']:'' ?>" required class="form-control"  placeholder="Year" />
                                                            </div>
                                                        </div>
                                                        <div class="col-md-6">
                                                            <div class="form-group">
                                                                <input type="number" max="12" name="ads[<?php echo $index ?>][no_of_expirence][month]" value="<?php echo isset($additional_data['no_of_expirence']['month'])?$additional_data['no_of_expirence']['month']:'' ?>" required class="form-control"  placeholder="Month" />
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="col-md-4">
                                                    <div class="form-group">
                                                        <label>Expirence From</label>
                                                        <select class="form-control" name="ads[<?php echo $index ?>][expirence_from]">
                                                            <option value="">Select Value</option>
                                                            <option <?php echo (!empty($additional_data) && $additional_data['expirence_from'] == 'Canadian Expirence')?'selected':'' ?> value="Canadian Expirence">Canadian Expirence</option>
                                                            <option <?php echo (!empty($additional_data) && $additional_data['expirence_from'] == 'Foriegn Expirence')?'selected':'' ?> value="Foriegn Expirence">Foriegn Expirence</option>
                                                        </select>
                                                    </div>
                                                </div>
                                                <div class="col-md-8">
                                                    <div class="form-group">
                                                        <select class="form-control" name="ads[<?php echo $index ?>][conditional]">
                                                            <option value="">Select Value</option>
                                                            <option <?php echo (!empty($additional_data) && $additional_data['conditional'] == 'Greater Than')?'selected':'' ?> value="Greater Than">Greater Than</option>
                                                            <option <?php echo (!empty($additional_data) && $additional_data['conditional'] == 'Greater Than Equal to')?'selected':'' ?> value="Greater Than Equal to">Greater Than Equal to</option>
                                                            <option <?php echo (!empty($additional_data) && $additional_data['conditional'] == 'Equal to')?'selected':'' ?> value="Equal to">Equal to</option>
                                                            <option <?php echo (!empty($additional_data) && $additional_data['conditional'] == 'Less Than Equal to')?'selected':'' ?> value="Less Than Equal to">Less Than Equal to</option>
                                                            <option <?php echo (!empty($additional_data) && $additional_data['conditional'] == 'Less Than')?'selected':'' ?> value="Less Than">Less Than</option>
                                                        </select>
                                                    </div>
                                                    <div class="form-group">
                                                        <div class="vs-checkbox-con vs-checkbox-primary">
                                                            <input type="checkbox" <?php echo (isset($additional_data['depend_on_noc']) && $additional_data['depend_on_noc'] == '1')?'checked':'' ?> onchange="show_noc(this,<?php echo $index ?>)" name="ads[<?php echo $index ?>][depend_on_noc]" value="1">
                                                            <span class="vs-checkbox">
                                                                <span class="vs-checkbox--check">
                                                                    <i class="vs-icon feather icon-check"></i>
                                                                </span>
                                                            </span>
                                                            <span class="">Is this criteria dependent on NOC</span>
                                                        </div>
                                                        <div class="vs-checkbox-con vs-checkbox-primary">
                                                            <input type="checkbox" name="ads[<?php echo $index ?>][exemption_canada_edu]" value="1">
                                                            <span class="vs-checkbox">
                                                                <span class="vs-checkbox--check">
                                                                    <i class="vs-icon feather icon-check"></i>
                                                                </span>
                                                            </span>
                                                            <span class="">Exemption for Canadian Education</span>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="col-md-4">
                                                    <div class="form-group" id="noc_condition_<?php echo $index ?>" style="display:<?php echo (!empty($additional_data) && $additional_data['depend_on_noc'] == '1')?'block':'none' ?>">
                                                        <select class="form-control"  <?php echo (!empty($additional_data) && $additional_data['depend_on_noc'] != '1')?"disabled":"" ?> requried name="ads[<?php echo $index ?>][noc]">
                                                            <option value="">Select Value</option>
                                                            <option <?php echo (isset($additional_data['noc']) && $additional_data['noc'] == 'NOC A')?'selected':'' ?> value="NOC A">NOC A</option>
                                                            <option <?php echo (isset($additional_data['noc']) && $additional_data['noc'] == 'NOC B')?'selected':'' ?> value="NOC B">NOC B</option>
                                                        </select>
                                                    </div>
                                                </div>
                                                <div class="col-md-12">
                                                    <div class="vs-checkbox-con vs-checkbox-primary">
                                                        <input type="checkbox" <?php echo (!empty($additional_data) && $additional_data['based_on_expirence'] == '1')?'checked':'' ?> name="ads[<?php echo $index ?>][based_on_expirence]" onchange="show_ielts_points(this,<?php echo $index ?>)" value="1">
                                                        <span class="vs-checkbox">
                                                            <span class="vs-checkbox--check">
                                                                <i class="vs-icon feather icon-check"></i>
                                                            </span>
                                                        </span>
                                                        <span class="">Are there points based on Expirence?</span>
                                                    </div>
                                                    <div class="exp_points" data-index="<?php echo $index ?>" id="ielts_points_<?php echo $index ?>" style="display:<?php echo (!empty($additional_data) && $additional_data['based_on_expirence'] == '1')?'block':'none' ?>">
                                                        <div class="ielts_points">
                                                            <?php
                                                                $ielts_points = array();
                                                                if(isset($additional_data['expirence_points']['expirence'])){
                                                                    $icount = count($additional_data['expirence_points']['points']);

                                                                    $expirence_points = $additional_data['expirence_points'];
                                                                }else{
                                                                    $icount = 1;
                                                                }
                                                                for($j=0;$j < $icount;$j++){
                                                                    $index2 = mt_rand(1,9999);
                                                            ?>
                                                                    <div class="row exp_block">
                                                                        <div class='col-md-12 text-right'><span onclick='removePoint(this)' class='badge badge-danger point-remove'><i class='fa fa-times'></i></span></div>
                                                                        <div class="col-md-9">
                                                                            <div class="row">
                                                                                <div class="col-md-6">
                                                                                    <div class="form-group">
                                                                                        <input type="number" name="ads[<?php echo $index ?>][expirence_points][expirence][year][]" value="<?php echo (!empty($expirence_points))?$expirence_points['expirence']['year'][$j]:"" ?>" <?php echo (empty($expirence_points))?"disabled":"" ?> requried class="form-control" placeholder="Year" />
                                                                                    </div>
                                                                                </div>
                                                                                <div class="col-md-6">
                                                                                    <div class="form-group">
                                                                                        <input type="number" max="12" name="ads[<?php echo $index ?>][expirence_points][expirence][month][]"  value="<?php echo (!empty($expirence_points))?$expirence_points['expirence']['month'][$j]:"" ?>" <?php echo (empty($expirence_points))?"disabled":"" ?> requried class="form-control" placeholder="Month" />
                                                                                    </div>
                                                                                </div>
                                                                            </div>
                                                                        </div>
                                                                        <div class="col-md-3">
                                                                            <div class="form-group">
                                                                                <input type="text" name="ads[<?php echo $index ?>][expirence_points][points][]" value="<?php echo (!empty($expirence_points))?$expirence_points['points'][$j]:"" ?>" <?php echo (empty($expirence_points))?"disabled":"" ?> required data-validation-containsnumber-regex="(\d)+" data-validation-containsnumber-message="The points field may only contain numeric characters." class="form-control" placeholder="Points" />
                                                                            </div>
                                                                        </div>
                                                                    </div>
                                                            <?php } ?>
                                                        </div>
                                                        <a href="javascript:;" class="badge badge-info pull-right" onclick="addmorepoints(this)">Add More</a>
                                                        <div class="clearfix"></div>
                                                    </div>
                                                    <div class="col-md-12">
                                                        <div class="form-group">
                                                            <label>Comment</label>
                                                            <textarea class="form-control"  name="ads[<?php echo $index ?>][comment]" row="3"><?php  echo $additional_data['comment'] ?></textarea>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </fieldset>
                                    </div>
                                <?php } ?>
                            </div>
                            <a href="javascript:;" class="badge badge-danger pull-right" onclick="addmorecriteria(this)"><i class="fa fa-plus"></i> Add Criteria</a>
                            <button type="submit" class="btn btn-primary">Submit</button>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
<script src="assets/app-assets/vendors/js/forms/validation/jqBootstrapValidation.js"></script>
<script src="assets/app-assets/js/scripts/forms/validation/form-validation.js"></script>
<script type="text/javascript">
tinymce.remove("#over_desc");
setTimeout(function(){
    var editor = initEditor("over_desc");
},500);

function addmorepoints(e){
    var index = $(e).parents(".exp_points").data("index");

    var rand_no = Math.floor(Math.random() * 1000);
    var clone = $(e).parents(".exp_points").find('.ielts_points .row:first-child').html();
    var html = "<div class='row exp_block' id='ip_"+rand_no+"'>";
    // html +="<div class='col-md-12 text-right'><span onclick='removePoint(this)' class='badge badge-danger point-remove'><i class='fa fa-times'></i></span></div>";
    html +=clone;
    html +="</div>";
    $("#ielts_points_"+index+" .ielts_points").append(html);  

    $("#ip_"+rand_no).find("input").val('');
    $("input").not("[type=submit]").jqBootstrapValidation();
    // $.ajax({
    //     url:"{{ baseUrl('visa-types/string-replace') }}",
    //     type:"post",
    //     data:{
    //         _token:csrf_token,
    //         html:clone,
    //         from:index,
    //         to:rand_no
    //     },
    //     dataType:"html",
    //     success:function(response){
    //         var html = "<div class='row' id='ip_"+rand_no+"'>";
    //         html +="<div class='col-md-12 text-right'><span onclick='removePoint("+rand_no+")' class='badge badge-danger point-remove'><i class='fa fa-times'></i></span></div>";
    //         html +=response;
    //         html +="</div>";
    //         $("#ielts_points_"+index+" .ielts_points").append(html);            // $("#criteria_"+rand_no+" select").select2("destroy").select2();
    //         $("input").not("[type=submit]").jqBootstrapValidation();
    //     }
    // });
}
function show_noc(e,index){
    if($(e).is(":checked")){
        $("#noc_condition_"+index).show();
        $("#noc_condition_"+index).find("select").removeAttr("disabled");
    }else{
        $("#noc_condition_"+index).hide();
        $("#noc_condition_"+index).find("select").attr("disabled","disabled");
    }
}
function show_ielts_points(e,index){
    if($(e).is(":checked")){
        $("#ielts_points_"+index).show();
        $("#ielts_points_"+index).find("input").removeAttr("disabled");
    }else{
        $("#ielts_points_"+index).hide();
        $("#noc_condition_"+index).find("input").attr("disabled","disabled");
    }
}

function addmorecriteria(e){
    var index = $(".criteria").find(".additional-section:first-child").data("index");
    
    var criteria_clone = $("#criteria_"+index).html();    
    var rand_no = Math.floor(Math.random() * 1000); 
    
    $.ajax({
        url:"{{ baseUrl('visa-types/string-replace') }}",
        type:"post",
        data:{
            _token:csrf_token,
            html:criteria_clone,
            from:index,
            to:rand_no
        },
        dataType:"html",
        success:function(response){
            var html ="<div id='criteria_"+rand_no+"' class='additional-section'>";
            // html +="<div class='col-md-12 text-right'><span onclick='removeCriteria(this)' class='badge badge-danger criteria-remove'><i class='fa fa-times'></i></span></div>";
            html +=response;
            html +="</div>";
            $(".criteria").append(html);
            var i = 0;
            $("#criteria_"+rand_no+" .point-remove").each(function(){
                if(i > 0){
                    $(this).trigger("click");
                }
                i++;
            });
            $("#criteria_"+rand_no).find("input[type=text],input[type=number],select,textarea").val('');
            $("#criteria_"+rand_no).find("input[type=checkbox]").prop("checked",false).trigger("change");
            $("input,select,textarea").not("[type=submit]").jqBootstrapValidation();
            // $("#criteria_"+rand_no+" select").select2("destroy").select2();
        }
    });
    // var res = clone.replace(index,rand_no);
    // // res += res.replace("["+index+"]","["+rand_no+"]");
    // // res += res.replaceAll(index, rand_no,false);
    // var html ="<div id='criteria_"+rand_no+"' class='additional-section'>";
    // html +=res;
    // html +="</div>";
    // $(".criteria").append(html);
}
function removePoint(e){
    var length = $(e).parents(".ielts_points").find(".exp_block").length;
    if(length > 1){
        $(e).parents(".exp_block").remove();    
    }else{
        errorMessage("Need atleast one point");
    }
    
}
function removeCriteria(e){
    var length = $(e).parents(".criteria").find(".additional-section").length;
    if(length > 1){
        $(e).parents('.additional-section').remove();    
    }else{
        errorMessage("Need atleast one criteria");
    }
    
}
$(document).ready(function(){
    // initSelect();
    $("#overviewForm").submit(function(e){
        $("#overviewForm input,#overviewForm select").not("[type=submit]").jqBootstrapValidation();
        e.preventDefault();
        var desc = tinymce.get('over_desc').getContent();
        $("#over_desc").val(desc);

        var formData = $("#overviewForm").serialize();
        
        var url = $("#overviewForm").attr("action");
        $.ajax({
            url:url,
            type:"post",
            data:formData,
            beforeSend:function(){
                showLoader();
            },
            success:function(response){
              hideLoader();
              if(response.status == true){
                successMessage(response.message);
                location.reload();
              }else{
                errorMessage(response.message);
              }
            },
            error:function(){
                hideLoader();
                errorMessage("Something wents wrong");
                // internalServerError();
            }
        });
    });
});
</script>