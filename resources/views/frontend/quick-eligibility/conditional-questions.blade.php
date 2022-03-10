<style>
.group_title{
display:block !important;
}
.quest_group .quest_group .group_title{
display:none !important;
}


</style>
<div class="quest_group conditional-{{ $question_id }}">
@if(!empty($conditional_question) && $condition_type == 'normal')
<h3 class="mt-3 text-danger group_title">Group: {{$conditional_question->GroupComponentIds->QuestionsGroups->group_title}}</h3>
@endif
<ul class="sortable conditional_questions" >
@if($is_component == 1)
    @if($component->show_in_question == 1)
        <li>
            <div><b>{{$component->component_title}}</b></div>
            <div><?php echo $component->description ?></div>
        </li>
    @endif
@endif
@foreach($records as $key => $record)
<li class="ui-state-default ques_li" data-key="{{$key}}" style="display:{{ ($key == 0)?'block':'none' }}" data-question="{{$record->unique_id}}">
    
    <div class="font-weight-bold"><i class="tio-arrow-large-forward"></i> {{$record->question}}</div>
    @if($record->additional_notes != '')
    <div class="mt-2"><?php echo $record->additional_notes ?></div>
    @endif
    <div class="question-options mt-2">
    @if($record->option_type == 'dropdown')
        @if(!empty($record->ComponentQuestions) || !empty($record->ConditionalQuestions))
            <select class="select2 ques_tag" onchange="conditionalQuestion('{{ $record->unique_id }}',this,'select')" name="question[{{$record->unique_id}}]">
        @else
            <select class="select2 ques_tag" name="question[{{$record->unique_id}}]">
        @endif
            <option value="">Select Option</option>
            @foreach($record->Options as $option)
                <option data-option-id="{{$option->id}}" value="{{ $option->option_value }}">{{$option->option_label}} ({{$option->score}})</option>
            @endforeach
        </select>
    @endif
    @if($record->option_type == 'radio')
    <!-- Form Check -->
        @foreach($record->Options as $option)
            <div class="form-check form-check-inline">
                <div class="custom-control custom-radio">
                @if(!empty($record->ComponentQuestions) || !empty($record->ConditionalQuestions))
                    <input type="radio" data-option-id="{{$option->id}}" id="customInlineRadio-{{$option->id}}" onchange="conditionalQuestion('{{ $record->unique_id }}',this,'radio')"  value="{{ $option->option_value }}" class="custom-control-input ques_tag" name="question[{{$record->unique_id}}]">
                @else
                    <input type="radio" data-option-id="{{$option->id}}" id="customInlineRadio-{{$option->id}}" value="{{ $option->option_value }}" class="custom-control-input ques_tag" name="question[{{$record->unique_id}}]">
                @endif
                    <label class="custom-control-label" for="customInlineRadio-{{$option->id}}">{{$option->option_label}} ({{$option->score}})</label>
                </div>
            </div>
            <!-- End Form Check -->
        @endforeach
        
    @endif
        <!-- End Form Check -->
    </div>
</li>
@endforeach
</ul>
</div>

<script>
$(".conditional-{{ $question_id }} .ques_tag").change(function(){
    var key = $(this).parents(".ques_li").attr("data-key");
    var next_index = parseInt(key)+1;
    $(".conditional-{{ $question_id }} li[data-key="+next_index+"]").show();
});
</script>