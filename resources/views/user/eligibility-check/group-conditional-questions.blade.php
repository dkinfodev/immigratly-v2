<?php
$is_comp_conditional = componentPreConditions('component',$component->unique_id);
$comp_display = "block";
$comp_ques_id = '';
if(!empty($is_comp_conditional)){
    $comp_display = "none";
    $comp_ques_id = "comp-ques-".$is_comp_conditional->question_id;
}
?>
<div class="h-100 imm-assessment-form-list-component-wrapper cond-{{ $group->unique_id }}-{{$component_id}}-{{$question_id}} {{$comp_ques_id}} component-{{$component->unique_id}}" data-max="{{ $component->max_score }}" data-min="{{ $component->min_score }}" style="display:{{ $comp_display }}">
    <div class=" h-100 imm-assessment-form-list-component">
        <div class="imm-assessment-form-list-component-header">
            <div class="d-flex" style="text-align:right">
                <img class="me-2" src="./assets/img/checked.svg" alt="" style="width:18px">
                <h4>{{$component->component_title}}</h4>
            </div>
        </div>
        <div class="imm-assessment-form-list-component-body">
            <div class="row">
                <div class="col-8">
                    @if($component->description)
                    <p><?php echo $component->description ?></p>
                    @endif
                </div>
                <div class="col-4">
                </div>
            </div>
        </div>
    </div>
    <ul class="imm-assessment-form-list-sub-wrapper">
    @foreach($component->Questions as $ques)
    <?php
        $option_selected = array();
        $check_ques = checkGroupConditionalQues($group->unique_id,$component->unique_id,$ques->EligibilityQuestion->unique_id);
        $block = 'block';
        $is_pre_conditional = componentPreConditions('question',$ques->EligibilityQuestion->unique_id);
        $preConditionalFunc = "";
        
        if(count($is_pre_conditional)>0){
            $preConditionalFunc = ",preConditionalComp(this.value,".$ques->EligibilityQuestion->unique_id.")";
        }
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
        <li class="quesli qs-{{ $group->unique_id }}-{{ $component->unique_id }}-{{ $ques->EligibilityQuestion->unique_id }}" data-group="{{ $group->unique_id }}" data-component="{{$component->unique_id}}" data-question="{{$ques->EligibilityQuestion->unique_id}}">
            <div class="h-100 imm-assessment-form-list-question-wrapper">
                <div class="h-100 imm-assessment-form-list-question">
                    <div class="imm-assessment-form-list-question-header"> {{$ques->EligibilityQuestion->question}}</div>
                    <div class="imm-assessment-form-list-question-body"> 
                        @if($ques->EligibilityQuestion->linked_to_cv == 'yes')
                            @if(!empty($option_selected) && $option_selected['option_selected'] != '')
                            <p class='text-danger mt-2 mb-2'>Option Selected Based on CV: {{$option_selected['option_score']}}</p>
                            @endif
                        @endif
                        <div class="question-options mt-2" style="display:{{ $block }}">
                            @if($ques->EligibilityQuestion->option_type == 'dropdown')

                            @if(!empty($check_ques))
                            <select {{ ($comp_display == "none")?'disabled':'' }} class="select2"
                                onchange="conditionalQuestion(this,'select'),countTotal(this,{{ $component->unique_id }},{{ $ques->EligibilityQuestion->unique_id }}){{$preConditionalFunc}}"
                                name="question[{{ $group->unique_id }}][{{ $component->unique_id }}][{{$ques->EligibilityQuestion->unique_id}}]">
                                @else
                                <select {{ ($comp_display == "none")?'disabled':'' }} class="select2"
                                    onchange="countTotal(this,{{ $component->unique_id }},{{ $ques->EligibilityQuestion->unique_id }}){{$preConditionalFunc}}"
                                    name="question[{{ $group->unique_id }}][{{ $component->unique_id }}][{{$ques->EligibilityQuestion->unique_id}}]">
                                    @endif
                                    <option value="">Select Option</option>
                                    @foreach($ques->EligibilityQuestion->Options as $option)
                                    @if($ques->EligibilityQuestion->linked_to_cv == 'yes' &&
                                    $ques->EligibilityQuestion->cv_section == 'language_proficiency')
                                    @if(!empty(Auth::user()->FirstProficiency->proficiency))
                                    @if(($ques->EligibilityQuestion->language_type == 'first_official' &&
                                    Auth::user()->FirstProficiency->proficiency == $option->language_proficiency_id) ||
                                    ($ques->EligibilityQuestion->language_type == 'second_official' &&
                                    Auth::user()->SecondProficiency->proficiency == $option->language_proficiency_id))
                                    <option data-noneligible="{{ $option->non_eligible }}"
                                        data-none-eligible-reason="{{ $option->non_eligible_reason }}"
                                        data-score="{{ $option->score }}"
                                        {{ (!empty($option_selected) && $option->option_value == $option_selected['option_selected'])?'selected':'' }}
                                        data-option-id="{{$option->id}}" value="{{ $option->option_value }}">
                                        {{$option->option_label}} ({{$option->score}})
                                    </option>
                                    @endif
                                    @endif
                                    @else
                                    <option data-noneligible="{{ $option->non_eligible }}"
                                        data-none-eligible-reason="{{ $option->non_eligible_reason }}"
                                        data-score="{{ $option->score }}"
                                        {{ (!empty($option_selected) && $option->option_value == $option_selected['option_selected'])?'selected':'' }}
                                        data-option-id="{{$option->id}}" value="{{ $option->option_value }}">
                                        {{$option->option_label}} ({{$option->score}})
                                    </option>
                                    @endif
                                    @endforeach
                                </select>
                                @endif
                                @if($ques->EligibilityQuestion->option_type == 'radio')
                                <!-- Form Check -->
                                @foreach($ques->EligibilityQuestion->Options as $option)
                                <div class="form-check form-check-inline pl-0">
                                    <div class="custom-control custom-radio">
                                        <?php 
                                        $checked = ''; 
                                        if(isset($option_selected['option_selected']) && $option_selected['option_selected'] == $option->option_value){
                                                $checked = 'checked';
                                        }
                                        ?>
                                        @if(!empty($check_ques))


                                        <input {{$checked}} {{ ($comp_display == "none")?'disabled':'' }} type="radio"
                                            data-score="{{ $option->score }}" data-noneligible="{{ $option->non_eligible }}"
                                            data-none-eligible-reason="{{ $option->non_eligible_reason }}"
                                            data-option-id="{{$option->id}}"
                                            id="customInlineRadio-{{$component->component_id}}-{{$option->id}}"
                                            onchange="conditionalQuestion(this,'radio'),countTotal(this,{{ $component->unique_id }},{{ $ques->EligibilityQuestion->unique_id }}){{$preConditionalFunc}}"
                                            value="{{ $option->option_value }}" class="custom-control-input"
                                            name="question[{{ $group->unique_id }}][{{ $component->unique_id }}][{{$ques->EligibilityQuestion->unique_id}}]">
                                        @else
                                        <input {{$checked}} {{ ($comp_display == "none")?'disabled':'' }}
                                            data-score="{{ $option->score }}"
                                            onchange="countTotal(this,{{ $component->unique_id }},{{ $ques->EligibilityQuestion->unique_id }}){{$preConditionalFunc}}"
                                            type="radio" data-noneligible="{{ $option->non_eligible }}"
                                            data-none-eligible-reason="{{ $option->non_eligible_reason }}"
                                            data-option-id="{{$option->id}}"
                                            id="customInlineRadio-{{$component->component_id}}-{{$option->id}}"
                                            value="{{ $option->option_value }}" class="custom-control-input"
                                            name="question[{{ $group->unique_id }}][{{ $component->unique_id }}][{{$ques->EligibilityQuestion->unique_id}}]">
                                        @endif

                                        <label class="custom-control-label"
                                            for="customInlineRadio-{{$component->component_id}}-{{$option->id}}">{{$option->option_label}}
                                            ({{$option->score}})</label>
                                    </div>
                                </div>
                                <!-- End Form Check -->
                                @endforeach
                                <div class="notmsg">
                                    <!-- Toast -->
                                    <div class="toast noneEligibleToast errorToast mt-2"
                                        id="noneEligibleToast-{{ $ques->EligibilityQuestion->unique_id }}" role="alert"
                                        aria-live="assertive" aria-atomic="true">
                                        <div class="toast-header p-2">
                                            <!-- <img class="avatar avatar-sm avatar-circle mr-2" src="../assets/img/160x160/img9.jpg" alt="Image description"> -->
                                            <h5 class="mb-0">None Eligible Option Selected</h5>

                                            <button type="button" class="close ml-3" data-dismiss="toast"
                                                aria-label="Close">
                                                <i class="tio-clear" aria-hidden="true"></i>
                                            </button>
                                        </div>
                                        <div class="toast-body">
                                        </div>
                                    </div>
                                    <!-- End Toast -->

                                </div>
                                @endif
                                <!-- End Form Check -->
                        </div>
                    </div>
                    <div class="imm-assessment-form-list-question-footer">
                        @if($ques->EligibilityQuestion->additional_notes != '')
                        <div class="mt-2"><?php echo $ques->EligibilityQuestion->additional_notes ?></div>
                        @endif
                    </div>
                </div>
            </div>


        </li>
        @if($ques->EligibilityQuestion->linked_to_cv == 'yes' && !empty($check_ques))
        <script>
        setTimeout(function() {

            @if($ques->EligibilityQuestion-> option_type == 'radio')
            var e = $(
                ".qs-{{ $group->unique_id }}-{{ $component->unique_id }}-{{ $ques->EligibilityQuestion->unique_id }} input[type=radio]:checked"
                );
            conditionalQuestion(e, 'radio');
            @endif

            @if($ques->EligibilityQuestion->option_type == 'select')
            var e = $(
                ".qs-{{ $group->unique_id }}-{{ $component->unique_id }}-{{ $ques->EligibilityQuestion->unique_id }} select"
                );
            conditionalQuestion(e, 'select');
            @endif
        }, 1000);
        </script>
        @endif
    @endforeach
    </ul>
</div>
{{-- <div class="component-blocks mt-3 bg-light cond-{{ $group->unique_id }}-{{$component_id}}-{{$question_id}}" style="display:{{$comp_display}}">
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
            $is_pre_conditional = componentPreConditions('question',$ques->EligibilityQuestion->unique_id);
            $preConditionalFunc = "";
            
            if(!empty($is_pre_conditional)){
                $preConditionalFunc = "preConditionalComp(this.value,".$ques->EligibilityQuestion->unique_id.")";
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
                    <select class="select2" onchange="countTotal(this,{{ $component->unique_id }},{{ $ques->EligibilityQuestion->unique_id }}),conditionalQuestion(this,'select'){{($preConditionalFunc !='')?','.$preConditionalFunc:''}}" name="question[{{$group->unique_id}}][{{ $component->unique_id }}][{{$ques->EligibilityQuestion->unique_id}}]"  required>
                @else
                    <select class="select2" onchange="countTotal(this,{{ $component->unique_id }},{{ $ques->EligibilityQuestion->unique_id }}){{ $preConditionalFunc }} name="question[{{$group->unique_id}}][{{ $component->unique_id }}][{{$ques->EligibilityQuestion->unique_id}}]"  required>
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
                            onchange="countTotal(this,{{ $component->unique_id }},{{ $ques->EligibilityQuestion->unique_id }}),conditionalQuestion(this,'radio')"
                            value="{{ $option->option_value }}" class="custom-control-input"
                            name="question[{{$group->unique_id}}][{{ $component->unique_id }}][{{$ques->EligibilityQuestion->unique_id}}]"  required>
                        @else
                        <input type="radio" onchange="countTotal(this,{{ $component->unique_id }},{{ $ques->EligibilityQuestion->unique_id }})" data-option-id="{{$option->id}}"
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
        @if($ques->EligibilityQuestion->linked_to_cv == 'yes' && !empty($check_ques))@if($ques->EligibilityQuestion->linked_to_cv == 'yes' && !empty($check_ques))
            <script>
           
               setTimeout(function(){
 
                @if($ques->EligibilityQuestion->option_type == 'radio' && !empty($group))
                var e = $(".qs-{{ $group->unique_id }}-{{ $component->unique_id }}-{{ $ques->EligibilityQuestion->unique_id }} input[type=radio]:checked");
                conditionalQuestion(e,'radio','gcq');
                @endif

                @if($ques->EligibilityQuestion->option_type == 'dropdown' && !empty($group))
                var e = $(".qs-{{ $group->unique_id }}-{{ $component->unique_id }}-{{ $ques->EligibilityQuestion->unique_id }} select");
                conditionalQuestion(e,'select','gcq');
                @endif
                },1000);
            </script>
        @endif
        @endforeach
    </ul>
</div> --}}