<div class="component-blocks mt-3 bg-light cond-{{ $group->unique_id }}-{{$component_id}}-{{$question_id}}">
    <div class="font-weight-bold text-warning">
        <i class="tio-chevron-right"></i> {{$component->component_title}}
    </div>
    <ul class="sortable-ul mt-2 mb-2">
        @foreach($component->Questions as $ques)
        <?php
            $check_ques = checkGroupConditionalQues($group->unique_id,$component->unique_id,$ques->EligibilityQuestion->unique_id);
            $block = 'block';
            if($ques->EligibilityQuestion->linked_to_cv == 'yes'){
                $block = 'none';
                $cv_section = $ques->EligibilityQuestion->cv_section;
                $elg_options = $ques->EligibilityQuestion->Options;
                $option_selected = cvBasedOptions($cv_section,$elg_options,$ques->EligibilityQuestion);
                
                if($option_selected['option_selected'] == ''){
                    $block = 'block';
                }
            }
        ?>
        <li class="ui-state-default quesli qs-{{ $group->unique_id }}-{{ $component->unique_id }}-{{ $ques->EligibilityQuestion->unique_id }}" data-group="{{ $group->unique_id }}" data-component="{{$component->unique_id}}" data-question="{{$ques->EligibilityQuestion->unique_id}}">

            <div class="font-weight-bold"><i class="tio-arrow-right-circle"></i>
                {{$ques->EligibilityQuestion->question}}</div>
            @if($ques->EligibilityQuestion->additional_notes != '')
            <div class="mt-2"><?php echo $ques->EligibilityQuestion->additional_notes ?></div>
            @endif
            @if($ques->EligibilityQuestion->linked_to_cv == 'yes')
               
                @if(!empty($option_selected) && $option_selected['option_selected'] != '')
                <h2 class='text-danger'>Option Selected Based on CV: {{$option_selected['option_label']}}</h2>
                @endif
            @endif
            <div class="question-options mt-2" style="display:{{ $block }}">
                @if($ques->EligibilityQuestion->option_type == 'dropdown')

                @if(!empty($check_ques))
                    <select class="select2" onchange="conditionalQuestion(this,'select')" name="question[{{$group->unique_id}}][{{ $component->unique_id }}][{{$ques->EligibilityQuestion->unique_id}}]"  required>
                @else
                    <select class="select2" name="question[{{$group->unique_id}}][{{ $component->unique_id }}][{{$ques->EligibilityQuestion->unique_id}}]"  required>
                @endif
                        <option value="">Select Option</option>
                        @foreach($ques->EligibilityQuestion->Options as $option)
                        <option {{ (!empty($option_selected) && $option->option_value == $option_selected['option_selected'])?'selected':'' }} data-option-id="{{$option->id}}" value="{{ $option->option_value }}">
                            {{$option->option_label}} ({{$option->score}})</option>
                        @endforeach
                    </select>
                    @endif
                    @if($ques->EligibilityQuestion->option_type == 'radio')
                    <!-- Form Check -->
                    @foreach($ques->EligibilityQuestion->Options as $option)
                    <div class="form-check form-check-inline">
                        <div class="custom-control custom-radio">
                            
                        @if(!empty($check_ques))
                        <input type="radio" data-option-id="{{$option->id}}"
                            id="customInlineRadio-{{ $component->unique_id }}-{{$option->id}}" 
                            {{ (!empty($option_selected) && $option->id == $option_selected['option_selected'])?'checked':'' }}
                            onchange="conditionalQuestion(this,'radio')"
                            value="{{ $option->option_value }}" class="custom-control-input"
                            name="question[{{$group->unique_id}}][{{ $component->unique_id }}][{{$ques->EligibilityQuestion->unique_id}}]"  required>
                        @else
                        <input type="radio" data-option-id="{{$option->id}}"
                            id="customInlineRadio-{{ $component->unique_id }}-{{$option->id}}" value="{{ $option->option_value }}"
                            class="custom-control-input" 
                            {{ (!empty($option_selected) && $option->id == $option_selected['option_selected'])?'checked':'' }}
                            name="question[{{$group->unique_id}}][{{ $component->unique_id }}][{{$ques->EligibilityQuestion->unique_id}}]" required>
                        @endif
                            
                            <label class="custom-control-label"
                                for="customInlineRadio-{{ $component->unique_id }}-{{$option->id}}">{{$option->option_label}} ({{$option->score}})</label>
                        </div>
                    </div>
                    <!-- End Form Check -->
                    @endforeach

                    @endif
                    <!-- End Form Check -->
            </div>
        </li>
        @if($ques->EligibilityQuestion->linked_to_cv == 'yes' && !empty($check_ques))
            <script>
               setTimeout(function(){

                @if($ques->EligibilityQuestion->option_type == 'radio')
                var e = $(".qs-{{ $record->Group->unique_id }}-{{ $component->Component->unique_id }}-{{ $ques->EligibilityQuestion->unique_id }} input[type=radio]:checked");
                conditionalQuestion(e,'radio');
                @endif

                @if($ques->EligibilityQuestion->option_type == 'select')
                var e = $(".qs-{{ $record->Group->unique_id }}-{{ $component->Component->unique_id }}-{{ $ques->EligibilityQuestion->unique_id }} select");
                conditionalQuestion(e,'select');
                @endif
                },1000);
            </script>
        @endif
        @endforeach
    </ul>
</div>