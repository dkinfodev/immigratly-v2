<style>
.additional-section select {
    -moz-appearance: none;
    -webkit-appearance: none;
}

</style>
<div class="modal-dialog modal-xl language-model" role="document">
    <div class="modal-content">
        <div class="modal-header">
            <h5 class="modal-title" id="exampleModalCenterTitle">Education</h5>
            <button type="button" class="close" data-dismiss="modal" data-target="addNewCategory" aria-label="Close">
                <span aria-hidden="true">&times;</span>
            </button>
        </div>
        <div class="modal-body">
            <div class="additional-block">
                
                <form class="form-horizontal" action="{{ baseUrl('/visa-types/save-visa-block') }}" id="overviewForm" autocomplete="off" method="post" novalidate>
               
                    {{ csrf_field() }}
                    <input type="hidden" name="visa_type_id" value="{{ $visa_type_id }}">
                    <input type="hidden" name="block" value="education">
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

                                <div class="additional-section" id="criteria_<?php echo $index ?>">
                                    <fieldset>
                                        <legend>Criteria</legend>
                                        <div class="row additional-block">
                                            <div class="col-md-8">
                                                <div class="row">
                                                    <div class="col-md-12">
                                                        <div class="form-group">
                                                            <select class="form-control" name="ads[<?php echo $index ?>][education]" required>
                                                                <option value="">Select Value</option>
                                                                <option value="None or less than secondary(high school)">None or less than secondary(high school)</option>
                                                                <option value="Secondary diploma (high school graduation)">Secondary diploma (high school graduation)</option>
                                                                <option value="One-year program at a university, collage, trade or technical school, or other institute">One-year program at a university, collage, trade or technical school, or other institute</option>
                                                                <option value="Two-year program at a university, collage, trade or technical school, or other institute">Two-year program at a university, collage, trade or technical school, or other institute</option>
                                                                <option value="Bachelor's degree (three or more year program at a university, collage, trade or technical school, or other institute)">Bachelor's degree (three or more year program at a university, collage, trade or technical school, or other institute)</option>
                                                                <option value="Two or more certificates, diplomas or degree. One must be for a program of three or more years">Two or more certificates, diplomas or degree. One must be for a program of three or more years</option>
                                                                <option value="Master's degree, or professional degree needed to practice in a licensed profession(see help)">Master's degree, or professional degree needed to practice in a licensed profession(see help)</option>
                                                                <option value="Doctoral level university degree (PhD)">Doctoral level university degree (PhD)</option>
                                                            </select>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="col-md-4">
                                                <div class="form-group">
                                                    <select class="form-control" name="ads[<?php echo $index ?>][education_from]">
                                                        <option value="">Select Value</option>
                                                        <option value="Canadian Education">Canadian Education</option>
                                                        <option value="Foreign Education">Foreign Education</option>
                                                    </select>
                                                </div>
                                            </div>
                                            <div class="col-md-8">
                                                <div class="form-group">
                                                    <select class="form-control" name="ads[<?php echo $index ?>][conditional]">
                                                        <option value="">Select Value</option>
                                                        <option value="Greater Than">Greater Than</option>
                                                        <option value="Greater Than Equal to">Greater Than Equal to</option>
                                                        <option value="Equal to">Equal to</option>
                                                        <option value="Less Than Equal to">Less Than Equal to</option>
                                                        <option value="Less Than">Less Than</option>
                                                    </select>
                                                </div>
                                                <div class="form-group">
                                                    <div class="vs-checkbox-con vs-checkbox-primary">
                                                        <input type="checkbox" onchange="show_noc(this,<?php echo $index ?>)" name="ads[<?php echo $index ?>][depend_on_noc]" value="1">
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
                                                <div class="form-group" id="noc_condition_<?php echo $index ?>" style="display:none">
                                                    <select class="form-control" disabled requried name="ads[<?php echo $index ?>][noc]">
                                                        <option value="">Select Value</option>
                                                        <option value="NOC A">NOC A</option>
                                                        <option value="NOC B">NOC B</option>
                                                    </select>
                                                </div>
                                            </div>
                                            <div class="col-md-12">
                                                <div class="vs-checkbox-con vs-checkbox-primary">
                                                    <input type="checkbox" name="ads[<?php echo $index ?>][ielts_points]" onchange="show_ielts_points(this,<?php echo $index ?>)" value="1">
                                                    <span class="vs-checkbox">
                                                        <span class="vs-checkbox--check">
                                                            <i class="vs-icon feather icon-check"></i>
                                                        </span>
                                                    </span>
                                                    <span class="">Are there points based on IELTS?</span>
                                                </div>
                                                <div id="ielts_points_<?php echo $index ?>" style="display:none">
                                                    <div class="ielts_points">
                                                        <div class="row" id="ip_<?php echo $index ?>">
                                                            <div class="col-md-9">
                                                                <div class="row">
                                                                    <div class="col-md-12">
                                                                        <div class="form-group">
                                                                            <select class="form-control" name="ads[<?php echo $index ?>][ielts_point][education][]" required>
                                                                                <option value="">Select Value</option>
                                                                                <option value="None or less than secondary(high school)">None or less than secondary(high school)</option>
                                                                                <option value="Secondary diploma (high school graduation)">Secondary diploma (high school graduation)</option>
                                                                                <option value="One-year program at a university, collage, trade or technical school, or other institute">One-year program at a university, collage, trade or technical school, or other institute</option>
                                                                                <option value="Two-year program at a university, collage, trade or technical school, or other institute">Two-year program at a university, collage, trade or technical school, or other institute</option>
                                                                                <option value="Bachelor's degree (three or more year program at a university, collage, trade or technical school, or other institute)">Bachelor's degree (three or more year program at a university, collage, trade or technical school, or other institute)</option>
                                                                                <option value="Two or more certificates, diplomas or degree. One must be for a program of three or more years">Two or more certificates, diplomas or degree. One must be for a program of three or more years</option>
                                                                                <option value="Master's degree, or professional degree needed to practice in a licensed profession(see help)">Master's degree, or professional degree needed to practice in a licensed profession(see help)</option>
                                                                                <option value="Doctoral level university degree (PhD)">Doctoral level university degree (PhD)</option>
                                                                            </select>
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                            <div class="col-md-3">
                                                                <div class="form-group">
                                                                    <input type="text" name="ads[<?php echo $index ?>][ielts_point][points][]" required data-validation-containsnumber-regex="(\d)+" data-validation-containsnumber-message="The point field may only contain numeric characters." class="form-control" placeholder="Points" />
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <a href="javascript:;" class="badge badge-info pull-right" onclick="addmorepoints(<?php echo $index ?>)">Add More</a>
                                                    <div class="clearfix"></div>
                                                </div>
                                                
                                            </div>
                                            <div class="col-md-12">
                                                <div class="form-group">
                                                    <label>Comment</label>
                                                    <textarea class="form-control" name="ads[<?php echo $index ?>][comment]" row="3"></textarea>
                                                </div>
                                            </div>
                                        </div>
                                    </fieldset>
                                </div>
                            </div>
                            <a href="javascript:;" class="badge badge-danger pull-right" onclick="addmorecriteria(<?php echo $index ?>)"><i class="fa fa-plus"></i> Add Criteria</a>
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

function addmorepoints(index){
    var rand_no = Math.floor(Math.random() * 1000);
    var clone = $("#ip_"+index).html();
    var html = "<div class='row' id='ip_"+rand_no+"'>";
    html +="<div class='col-md-12 text-right'><span onclick='removePoint("+rand_no+")' class='badge badge-danger point-remove'><i class='fa fa-times'></i></span></div>";
    html +=clone;
    html +="</div>";
    $("#ielts_points_"+index+" .ielts_points").append(html);            // $("#criteria_"+rand_no+" select").select2("destroy").select2();
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
var criteria_clone = $("#criteria_"+<?php echo $index ?>).html();
function addmorecriteria(index){
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
            html +="<div class='col-md-12 text-right'><span onclick='removeCriteria("+rand_no+")' class='badge badge-danger criteria-remove'><i class='fa fa-times'></i></span></div>";
            html +=response;
            html +="</div>";
            $(".criteria").append(html);
            $("#criteria_"+rand_no+" .point-remove").trigger("click");
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
function removePoint(id){
    $("#ip_"+id).remove();
}
function removeCriteria(id){
    $("#criteria_"+id).remove();
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