<form action="{{ baseUrl('visa-services/eligibility-questions/'.$visa_service_id.'/combination-questions/save') }}" id="form"
    method="post">
    @csrf
    <input type="hidden" name="component_id" value="{{$component_id}}" />
    <table class="table table-bordered table-align-middle">
        <thead>
            <tr>
                <th>#</th>
                <th>Question</th>
                <th width="30%">Option</th>
                <th>Behaviour</th>
                <th>Score</th>
            </tr>
        </thead>
        <tbody>
            
            @foreach($records as $key => $question)
            <?php
                $uniq = randomNumber(5);
                
            ?>
            <tr class="q-row">
                <td scope="col text-center">
                    <div class="custom-control custom-checkbox">
                        <input type="checkbox" data-key="{{$key}}" <?php echo (isset($combinations['group_'.$key]))?'checked':'' ?> class="custom-control-input row-checkbox" id="row-{{$key}}">
                        <label class="custom-control-label" for="row-{{$key}}"></label>
                    </div>
                </td>
                <td scope="col" colspan="2">
                    <b>Group {{$key+1}}</b>
                </td>
                <td>
                    <select name="combination[{{$uniq}}][behaviour]" class="behaviour_{{$key}} behaviour inp-field" required <?php echo (!isset($combinations['group_'.$key]))?'disabled':'' ?>>
                        <option value="">Select Behaviour</option>
                        <option <?php echo (isset($combinations['group_'.$key]) && $combinations['group_'.$key]['behaviour'] == 'add')?'selected':'' ?> value="add">Add</option>
                        <option <?php echo (isset($combinations['group_'.$key]) && $combinations['group_'.$key]['behaviour'] == 'substract')?'selected':'' ?> value="substract">Substract</option>
                        <option <?php echo (isset($combinations['group_'.$key]) && $combinations['group_'.$key]['behaviour'] == 'overwrite')?'selected':'' ?> value="overwrite">Overwrite</option>
                    </select>
                </td>
                <td scope="col">
                    <input type="text" class="form-control inp-field score" name="combination[{{$uniq}}][score]" required <?php echo (!isset($combinations['group_'.$key]))?'disabled':'' ?> value="<?php echo (isset($combinations['group_'.$key]))?$combinations['group_'.$key]['score']:'' ?>" placeholder="Enter Score" />
                </td>
            </tr>
            @foreach($question as $key2 => $record)
           
            <tr class="qr-row-{{$key}}">
                <td scope="col">
                    Question {{$key2+1}}
                </td>
                <td scope="col">
                    {{$record->Question->question}}
                    <input type="hidden" class="form-control inp-field-{{$key}}" value="{{$record->Question->unique_id}}" name="combination[{{$uniq}}][question_id_{{$key2}}]" required <?php echo (!isset($combinations['group_'.$key]))?'disabled':'' ?>/>
                </td>
                <td scope="col">
                    {{$record->option_label}}
                    <input type="hidden" class="form-control inp-field-{{$key}}" value="{{$record->id}}" name="combination[{{$uniq}}][option_id_{{$key2}}]" required <?php echo (!isset($combinations['group_'.$key]))?'disabled':'' ?>/>
                </td>
                <td>&nbsp;</td>
                <td>&nbsp;</td>
            </tr>
            @endforeach
            @endforeach
        <tbody>
    </table>
    <div class="validation_response p-3 text-center text-danger"></div>
    <div class="form-group text-center">
        <button type="submit" class="btn btn-primary">Save</button>
    </div>
</form>
<script>
$(document).ready(function() {
    $(".row-checkbox").change(function() {
        var key = $(this).attr("data-key");
        
        if ($(this).is(":checked")) {
            $(this).parents(".q-row").find(".inp-field").removeAttr("disabled");
            $(".inp-field-"+key).removeAttr("disabled");
        } else {
            $(this).parents(".q-row").find(".inp-field").attr("disabled", "disabled");
            
            $(".inp-field-"+key).attr("disabled", "disabled");
            $(".score,.behaviour").val('');
            $(this).parents(".q-row").find(".inp-field").trigger("change");
           
        }
    });

    $("#form").submit(function(e){
        e.preventDefault(); 
        
        var formData = $("#form").serialize();
        // formData += "&component_id="+$(".component_id").val();
        $.ajax({
            url:$("#form").attr('action'),
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
                    window.location.href = response.redirect_back;
                }else{
                    $('.validation_response').html(response.message);
                }
            },
            error:function(){
                internalError();
            }
        });
    });
})
</script>