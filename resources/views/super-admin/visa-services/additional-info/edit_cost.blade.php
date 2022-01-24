<style>
.additional-section select {
    -moz-appearance: none;
    -webkit-appearance: none;
}

</style>
<div class="modal-dialog modal-xl expirence-modal" role="document">
    <div class="modal-content">
        <div class="modal-header">
            <h5 class="modal-title" id="exampleModalCenterTitle">Cost</h5>
            <button type="button" class="close" data-dismiss="modal" data-target="addNewCategory" aria-label="Close">
                <span aria-hidden="true">&times;</span>
            </button>
        </div>
        <div class="modal-body">
            <div class="additional-block">
                
                <form class="form-horizontal" action="{{ baseUrl('/visa-types/update-visa-block/'.$record->id) }}" id="overviewForm" autocomplete="off" method="post" novalidate>
                
                    {{ csrf_field() }}
                    <input type="hidden" name="visa_type_id" value="{{ $visa_type_id }}">
                    <input type="hidden" name="block" value="cost">
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
                                        $jcount = count($additional_data['label']);
                                ?>  
                                        <div class="additional-section" data-index="<?php echo $index ?>" id="criteria_<?php echo $index ?>">
                                            <fieldset>
                                                <legend>Criteria</legend>
                                                <div class="row additional-block">
                                                    <div class="col-md-12">
                                                        <div class="exp_points">
                                                            <div class="ielts_points" id="cost_<?php echo $index ?>" data-index="<?php echo $index ?>">
                                                                <?php for($j=0;$j < $jcount;$j++){ ?>
                                                                <div class="row exp_block">
                                                                    <div class='col-md-12 text-right'><span onclick='removePoint(this)' class='badge badge-danger point-remove'><i class='fa fa-times'></i></span></div>
                                                                    <div class="col-md-4">
                                                                        <div class="form-group">
                                                                            <input type="text" name="ads[<?php echo $index ?>][label][]" requried  class="form-control" value="<?php echo $additional_data['label'][$j] ?>" placeholder="Cost Label" />
                                                                        </div>
                                                                    </div>
                                                                    <div class="col-md-4">
                                                                        <div class="form-group">
                                                                            <input type="text" name="ads[<?php echo $index ?>][cost][]" required class="form-control" value="<?php echo $additional_data['cost'][$j] ?>" placeholder="Cost" />
                                                                        </div>
                                                                    </div>
                                                                    <div class="col-md-4">
                                                                        <div class="form-group">
                                                                            <select class="form-control" name="ads[<?php echo $index ?>][fees_type][]">
                                                                                <option value="">Select Value</option>
                                                                                <option <?php echo ($additional_data['fees_type'][$j] == 'Application Fees')?"selected":"" ?> value="Application Fees">Application Fees</option>
                                                                                <option <?php echo ($additional_data['fees_type'][$j] == 'Professional Fees')?"selected":"" ?> value="Professional Fees">Professional Fees</option>
                                                                                <option <?php echo ($additional_data['fees_type'][$j] == 'Other Fees')?"selected":"" ?> value="Other Fees">Other Fees</option>
                                                                            </select>
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                                <?php } ?>
                                                            </div>
                                                            <a href="javascript:;" class="badge badge-info pull-right" onclick="addmorepoints(this)">Add More</a>
                                                            <div class="clearfix"></div>
                                                        </div>
                                                    </div>
                                                    <div class="col-md-12">
                                                        <div class="form-group">
                                                            <label>Comment</label>
                                                            <textarea class="form-control" name="ads[<?php echo $index ?>][comment]" row="3"><?php  echo $additional_data['comment'] ?></textarea>
                                                        </div>
                                                    </div>
                                                </div>
                                            </fieldset>
                                        </div>
                                    <?php } ?>
                            </div>
                            <!-- <a href="javascript:;" class="badge badge-danger pull-right" onclick="addmorecriteria(this)"><i class="fa fa-plus"></i> Add Criteria</a> -->
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
    var index = $(e).parents(".exp_points").find('.ielts_points').data("index");
    
    var rand_no = Math.floor(Math.random() * 1000);
    var clone = $(e).parents(".exp_points").find('.ielts_points .row:first-child').html();
    var html = "<div class='row exp_block' id='cost_"+rand_no+"'>";
    // html +="<div class='col-md-12 text-right'><span onclick='removePoint(this)' class='badge badge-danger point-remove'><i class='fa fa-times'></i></span></div>";
    html += clone;
    html +="</div>";
    $("#cost_"+index).append(html);
    $("#cost_"+rand_no).find('.form-control').val('');
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

function removePoint(e){
    var length = $(e).parents(".ielts_points").find('.exp_block').length;
    if(length > 1){
        $(e).parents(".exp_block").remove();    
    }else{
        errorMessage("Need atleast one price");
    }
    
}
function removeCriteria(e){
    $(e).parents('.additional-section').remove();
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