<form action="{{ baseUrl('visa-services/eligibility-questions/'.base64_encode($visa_service->id).'/multi-option-groups/'.base64_encode($question->id).'/save') }}" id="form"
    method="post">
    @csrf
    <input type="hidden" value="{{ $visa_service->unique_id }}" name="visa_service_id" />
    <input type="hidden" value="{{ $question->unique_id }}" name="current_question_id" />
    <table class="table table-bordered table-align-middle">
        <thead>
            <tr>
                <th>#</th>
                <th>Group Options</th>
                <th>Question Option</th>
                <th>Score</th>
            </tr>
        </thead>
        <tbody>
           @foreach($comb_options as $key => $option)
           <?php
               $index = randomNumber(5); 
           ?>
            <tr>
                <th>{{$key+1}}</th>
                <td>
                    <b>Option One: </b>{{$option['comb_group']['option_one']['option_label']}} <Br>
                    <b>Option Two: </b>{{$option['comb_group']['option_two']['option_label']}}
                    <input type="hidden" name="option[{{ $index }}][comb_option_id]" value="{{ $option['comb_group']['id'] }}" />
                </td>
                <td>
                    {{$option['option']['option_label']}}
                    <input type="hidden" name="option[{{ $index }}][question_id]" value="{{ $option['option']['question_id'] }}" />
                    <input type="hidden" name="option[{{ $index }}][option_id]" value="{{ $option['option']['id'] }}" />
                    <input type="hidden" name="option[{{ $index }}][option_value]" value="{{ $option['option']['option_value'] }}" />
                </td>
                <td>
                    <input type="text" class="form-control" placeholder="Enter Score" name="option[{{ $index }}][score]" value="{{ $option['score'] }}" />
                </td>
                
            </tr>
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