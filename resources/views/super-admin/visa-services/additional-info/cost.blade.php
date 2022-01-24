<style>
.additional-section select {
    -moz-appearance: none;
    -webkit-appearance: none;
}

</style>
<div class="modal-dialog modal-xl" role="document">
    <div class="modal-content">
        <div class="modal-header">
            <h5 class="modal-title" id="staticBackdropLabel">Cost</h5>
            <button type="button" class="btn btn-xs btn-icon btn-ghost-secondary" data-dismiss="modal"
                aria-label="Close">
                <i class="tio-clear tio-lg"></i>
            </button>
        </div>
        <div class="modal-body">
            <div class="additional-block">
                @if(isset($record))
                    <form class="form-horizontal" action="{{ baseUrl('/visa-services/additional-information/'.base64_encode($visa_type_id).'/update-visa-block/'.$record->id) }}" id="popup-form" autocomplete="off" method="post" novalidate>
                @else
                    <form class="form-horizontal" action="{{ baseUrl('/visa-services/additional-information/'.base64_encode($visa_type_id).'/save-visa-block') }}" id="popup-form" autocomplete="off" method="post" novalidate>
                @endif
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
                                    $index = mt_rand(1,9999);
                                ?>
                                <div class="additional-section" data-index="<?php echo $index ?>" id="criteria_<?php echo $index ?>">
                                    <fieldset>
                                        <legend>Criteria</legend>
                                        <div class="row additional-block">
                                            <div class="col-md-12">
                                                <div class="exp_points p-3">
                                                    <div class="ielts_points" id="cost_<?php echo $index ?>" data-index="<?php echo $index ?>">
                                                        <div class="row">
                                                            <div class="col-md-4">
                                                                <div class="form-group">
                                                                    <input type="text" name="ads[<?php echo $index ?>][label][]" requried  class="form-control" placeholder="Cost Label" />
                                                                </div>
                                                            </div>
                                                            <div class="col-md-4">
                                                                <div class="form-group">
                                                                    <input type="text" name="ads[<?php echo $index ?>][cost][]" required class="form-control" placeholder="Cost" />
                                                                </div>
                                                            </div>
                                                            <div class="col-md-4">
                                                                <div class="form-group">
                                                                    <select class="form-control" name="ads[<?php echo $index ?>][fees_type][]">
                                                                        <option value="">Select Value</option>
                                                                        <option value="Application Fees">Application Fees</option>
                                                                        <option value="Professional Fees">Professional Fees</option>
                                                                        <option value="Other Fees">Other Fees</option>
                                                                    </select>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <a href="javascript:;" class="badge badge-info pull-right" onclick="addmorepoints(this)">Add More</a>
                                                    <div class="clearfix"></div>
                                                </div>
                                            </div>
                                            <div class="col-md-12 p-3">
                                                <div class="form-group">
                                                    <label>Comment</label>
                                                    <textarea class="form-control" name="ads[<?php echo $index ?>][comment]" row="3"></textarea>
                                                </div>
                                            </div>
                                        </div>
                                    </fieldset>
                                </div>
                            </div>
                            <!-- <a href="javascript:;" class="badge badge-danger pull-right" onclick="addmorecriteria(this)"><i class="fa fa-plus"></i> Add Criteria</a> -->
                            <!-- <button type="submit" class="btn btn-primary">Submit</button> -->
                        </div>
                    </div>
                </form>
            </div>
        </div>
        <div class="modal-footer">
            <button type="button" class="btn btn-white" data-dismiss="modal">Close</button>
            <button form="popup-form" class="btn btn-primary">Save</button>
        </div>
    </div>
</div>

<script type="text/javascript">
setTimeout(function(){
    var editor = initEditor("over_desc");
},500);

function addmorepoints(e){
    var index = $(e).parents(".exp_points").find('.ielts_points').data("index");
    
    var rand_no = Math.floor(Math.random() * 1000);
    var clone = $(e).parents(".exp_points").find('.ielts_points .row:first-child').html();
    var html = "<div class='row exp_block' id='cost_"+rand_no+"'>";
    html +="<div class='col-md-12 text-right'><span onclick='removePoint(this)' class='badge badge-danger point-remove'><i class='tio-clear'></i></span></div>";
    html += clone;
    html +="</div>";
    $("#cost_"+index).append(html);
    $("#cost_"+rand_no).find('.form-control').val('');
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
    $(e).parents(".exp_block").remove();
}
function removeCriteria(e){
    $(e).parents('.additional-section').remove();
}
$(document).ready(function(){
    // initSelect();
    $("#popup-form").submit(function(e){
        e.preventDefault();
        var formData = $("#popup-form").serialize();
        
        var url = $("#popup-form").attr("action");
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