<?php
$is_comp_conditional = componentPreConditions('component',$component->unique_id);
$comp_display = "block";
$comp_ques_id = '';
if(!empty($is_comp_conditional)){
    $comp_display = "none";
    $comp_ques_id = "comp-ques-".$is_comp_conditional->question_id;
}
$init_change = '';
if($visa_service->question_as_sequence == 1){
    $init_change = 'initChange(this),';
}
?>
<div class="h-100 imm-assessment-form-list-component-wrapper cond-{{ $group->unique_id }}-{{$component_id}}-{{$question_id}} {{$comp_ques_id}} component-{{$component->unique_id}} conditional-question" data-max="{{ $component->max_score }}" data-min="{{ $component->min_score }}" style="display:{{ $comp_display }}">
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
        $dependent_data = '';
        if($ques->dependent_question != ''){
            $dependent_data = 'data-dependent='.$ques->dependent_question;
        }
        $checkIfDependent = dependentQuestions($component->unique_id,$ques->question_id);
        $option_selected = array();
        $check_ques = checkGroupConditionalQues($group->unique_id,$component->unique_id,$ques->EligibilityQuestion->unique_id);
        $block = 'block';
        $is_pre_conditional = componentPreConditions('question',$ques->EligibilityQuestion->unique_id);
        $preConditionalFunc = "";
        
        if(count($is_pre_conditional)>0){
            $preConditionalFunc = ",preConditionalComp(this.value,".$ques->EligibilityQuestion->unique_id.")";
        }
        $depcomclass='';
        // pre($component->toArray());
        if($checkIfDependent->count() > 0){
            $preConditionalFunc .=",dependentQuestion(this,".$ques->EligibilityQuestion->unique_id.",'".$ques->EligibilityQuestion->option_type."')";
            
            if(isset($component)){
                $depcomclass='data-depcom='.$component->unique_id."-".$ques->EligibilityQuestion->unique_id;
            }
        }
        if($ques->EligibilityQuestion->language_prof_type == 0){
            // if($ques->EligibilityQuestion->linked_to_cv == 'yes'){
            //     $block = 'none';
            //     $cv_section = $ques->EligibilityQuestion->cv_section;
            //     $elg_options = $ques->EligibilityQuestion->Options;
            //     $option_selected = cvBasedOptions($cv_section,$elg_options,$ques->EligibilityQuestion,$component->unique_id);
                
            //     if($option_selected['option_selected'] == ''){
            //         $block = 'block';
            //     }
            // }
        }else{
            $block="none";
        }
    ?>
        <li class="quesli qs-{{ $group->unique_id }}-{{ $component->unique_id }}-{{ $ques->EligibilityQuestion->unique_id }}" 
        data-group="{{ $group->unique_id }}" 
        data-component="{{$component->unique_id}}" 
        data-question="{{$ques->EligibilityQuestion->unique_id}}"
        style="display:{{($ques->dependent_question != '')?'none':'block' }}">
            <div class="h-100 imm-assessment-form-list-question-wrapper">
                <div class="h-100 imm-assessment-form-list-question">
                    <div class="imm-assessment-form-list-question-header"> {{$ques->EligibilityQuestion->question}}</div>
                    <span class="preselect text-danger"></span> 
                    <div class="imm-assessment-form-list-question-body" style="display:{{($ques->dependent_question != '')?'none':'block' }}">
                    @if($ques->EligibilityQuestion->language_prof_type == 0)
                        @if($ques->EligibilityQuestion->linked_to_cv == 'yes')
                            @if(!empty($option_selected) && $option_selected['option_selected'] != '')
                            <p class='text-danger mt-2 mb-2'>Option Selected Based on CV: {{$option_selected['option_score']}}</p>
                            @endif
                        @endif
                    @endif
                        @if($ques->EligibilityQuestion->language_prof_type == 1)
                        <div class="question-options mt-2">
                            <div class="row gx-2 language_prof_type" data-question-id="{{$ques->EligibilityQuestion->unique_id}}">
                                <div class="col-md-9">
                                    <div class="row gx-3">
                                        <div class="col-sm-3">
                                            <div class="mb-4">
                                                <label for="addlisteningLabel" class="form-label">Listening</label>
                                                <input type="text" class="form-control bg-white p-2 listening" onblur="checkProficiency(this)" placeholder="Listening">
                                            </div>
                                        </div>

                                        <div class="col-sm-3">
                                            <div class="mb-4">
                                                <label for="addreadingLabel" class="form-label">Reading</label>
                                                <input type="text" class="form-control bg-white p-2 reading" onblur="checkProficiency(this)" placeholder="Reading" />
                                            </div>
                                        </div>


                                        <div class="col-sm-3">
                                            <div class="mb-4">
                                                <label for="addwritingLabel" class="form-label">Writing</label>
                                                <input type="text" class="form-control bg-white p-2 writing" onblur="checkProficiency(this)" placeholder="Writing">
                                            </div>
                                        </div>
                                        <div class="col-sm-3">
                                            <div class="mb-4">
                                                <label for="addwritingLabel" class="form-label">Speaking</label>
                                                <input type="text" class="form-control bg-white p-2 speaking" onblur="checkProficiency(this)" placeholder="Speaking">
                                            </div>
                                        </div>
                                        
                                    </div>
                                </div>
                                <div class="col-md-3">
                                    <?php
                                        $proficiencies = languageProficiencies($ques->EligibilityQuestion->language_type);
                                    ?>
                                    
                                        <div class="mb-4">
                                            <label for="addspeakingLabel" class="form-label">Language Test</label>
                                            <Select class="language_test" onchange="checkProficiency(this)">
                                                <option value="">Select Language</option>
                                                @foreach($proficiencies as $prof)
                                                <option value="{{ $prof->unique_id }}">{{$prof->name}} ({{$prof->OffLang->name}})</option>
                                                @endforeach
                                            </select>
                                        </div>

                                    </div>
                                </div>
                            </div>
                        </div>
                        <span class="lngpreselect text-danger"></span>
                        @endif
                        <div class="question-options mt-2" style="display:{{ $block }}">
                        @if($ques->EligibilityQuestion->wage_type == '1')
                            <div class="row">
                                <div class="col-md-4">
                                    <input type="number" placeholder="Enter your wage" class="form-control bg-white p-2" name="question[{{$group->unique_id}}][{{ $component->unique_id }}][{{$ques->EligibilityQuestion->unique_id}}][wage_value]"  required />
                                </div>
                                <div class="col-md-4">
                                    <select name="question[{{$group->unique_id}}][{{ $component->unique_id }}][{{$ques->EligibilityQuestion->unique_id}}][wage_type]" class="wage_type">
                                        <option value="">Select Wage Type</div>
                                        @foreach(wagesTypes() as $wagetype)
                                        <option value="{{ $wagetype }}">{{ucfirst($wagetype)}}</option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>
                        @else
                            @if($ques->EligibilityQuestion->option_type == 'dropdown')

                            @if(!empty($check_ques))
                            <select {{ ($comp_display == "none")?'disabled':'' }} 
                                class="select2 dropdown-field" 
                                data-element="select" 
                                data-quesid="{{ $ques->EligibilityQuestion->unique_id }}"
                                onchange="conditionalQuestion(this,'select'),countTotal(this,{{ $component->unique_id }},{{ $ques->EligibilityQuestion->unique_id }}){{$preConditionalFunc}}"
                                {{$dependent_data}}
                                {{$depcomclass}}
                                name="question[{{ $group->unique_id }}][{{ $component->unique_id }}][{{$ques->EligibilityQuestion->unique_id}}]">
                            @else
                            <select {{ ($comp_display == "none")?'disabled':'' }} 
                                class="select2 dropdown-field" 
                                data-element="select" 
                                data-quesid="{{ $ques->EligibilityQuestion->unique_id }}"
                                onchange="{{$init_change}}countTotal(this,{{ $component->unique_id }},{{ $ques->EligibilityQuestion->unique_id }}){{$preConditionalFunc}}"
                                {{$dependent_data}}
                                {{$depcomclass}}
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
                                            data-element="radio"
                                            {{$dependent_data}}
                                            {{$depcomclass}}
                                            data-quesid="{{ $ques->EligibilityQuestion->unique_id }}"
                                            id="customInlineRadio-{{$component->component_id}}-{{$option->id}}"
                                            onchange="conditionalQuestion(this,'radio'),countTotal(this,{{ $component->unique_id }},{{ $ques->EligibilityQuestion->unique_id }}){{$preConditionalFunc}}"
                                            value="{{ $option->option_value }}" 
                                            class="custom-control-input radio-field"
                                            name="question[{{ $group->unique_id }}][{{ $component->unique_id }}][{{$ques->EligibilityQuestion->unique_id}}]">
                                        @else
                                        <input {{$checked}} {{ ($comp_display == "none")?'disabled':'' }}
                                            data-score="{{ $option->score }}"
                                            onchange="{{$init_change}}countTotal(this,{{ $component->unique_id }},{{ $ques->EligibilityQuestion->unique_id }}){{$preConditionalFunc}}"
                                            type="radio" data-noneligible="{{ $option->non_eligible }}"
                                            data-none-eligible-reason="{{ $option->non_eligible_reason }}"
                                            data-option-id="{{$option->id}}"
                                            data-element="radio"
                                            {{$dependent_data}}
                                            {{$depcomclass}}
                                            data-quesid="{{ $ques->EligibilityQuestion->unique_id }}"
                                            id="customInlineRadio-{{$component->component_id}}-{{$option->id}}"
                                            value="{{ $option->option_value }}" 
                                            class="custom-control-input radio-field"
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
                            @endif
                        </div>
                    </div>
                    <div class="imm-assessment-form-list-question-footer">
                        @if($ques->EligibilityQuestion->additional_notes != '')
                        <div class="mt-2"><strong>Note: </strong><?php echo $ques->EligibilityQuestion->additional_notes ?></div>
                        @endif

                        @if(!empty($ques->EligibilityQuestion->RandomFunFacts($ques->EligibilityQuestion->unique_id)))
                        <div class="mt-2"><strong>Fun Facts: </strong><?php echo $ques->EligibilityQuestion->RandomFunFacts($ques->EligibilityQuestion->unique_id)->fun_facts ?></div>
                        @endif
                    </div>
                </div>
            </div>
        </li>
        @if($ques->EligibilityQuestion->linked_to_cv == 'yes' && !empty($check_ques))
        <script>
        setTimeout(function() {
           
            @if($ques->EligibilityQuestion->option_type == 'radio')
            var e = $(
                ".qs-{{ $group->unique_id }}-{{ $component->unique_id }}-{{ $ques->EligibilityQuestion->unique_id }} input[type=radio]:checked"
                );
            conditionalQuestion(e, 'radio');
            @endif

            @if($ques->EligibilityQuestion->option_type == 'dropdown')
            var e = $(
                ".qs-{{ $group->unique_id }}-{{ $component->unique_id }}-{{ $ques->EligibilityQuestion->unique_id }} select"
                );
            conditionalQuestion(e, 'select');
            @endif
        }, 1000);
        </script>
        @endif
        <script>
            var index = $(".cond-{{ $group->unique_id }}-{{$component_id}}-{{$question_id}}").find("*[data-quesid='{{ $question_id }}']").length;
            // alert(index+" = {{ $question_id }}");
            @if($ques->dependent_question != '')
                var value = $("*[data-depcom='{{$ques->dependent_component}}-{{$ques->dependent_question}}']:checked").val();
                
                @if($ques->EligibilityQuestion->option_type == 'dropdown')
                    $("*[data-dependent='{{$ques->dependent_question}}']").find("option[value='"+value+"']").attr("selected","selected");
                    setTimeout(function(){   
                        $("*[data-dependent='{{$ques->dependent_question}}']").trigger("change");
                    },1000);
                    var text = $("*[data-dependent='{{$ques->dependent_question}}']").find("option[value='"+value+"']").text();
                    $("*[data-dependent='{{$ques->dependent_question}}']").parents(".quesli").show();
                    $("*[data-dependent='{{$ques->dependent_question}}'][value='"+value+"']").parents(".imm-assessment-form-list-question").find(".preselect").html(text);

                @else
                    $("*[data-dependent='{{$ques->dependent_question}}'][value='"+value+"']").prop("checked",true);
                    $("*[data-dependent='{{$ques->dependent_question}}']").parents(".quesli").show();
                    var text = $("*[data-depcom='{{$ques->dependent_component}}-{{$ques->dependent_question}}']:checked").parents(".form-check").text();
                    $("*[data-dependent='{{$ques->dependent_question}}'][value='"+value+"']").parents(".imm-assessment-form-list-question").find(".preselect").html(text);
                    setTimeout(function(){   
                        $("*[data-dependent='{{ $question_id }}'][value='"+value+"']").trigger("change");
                    },1000);
                @endif
              
                
                 
            @endif
        </script>
    @endforeach
    </ul>
</div>
<script>
    // initChange();
</script>





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
                $option_selected = cvBasedOptions($cv_section,$elg_options,$ques->EligibilityQuestion,$component->unique_id);
                
                if($option_selected['option_selected'] == ''){
                    $block = 'block';
                }
            }
            $is_pre_conditional = componentPreConditions('question',$ques->EligibilityQuestion->unique_id);
            $preConditionalFunc = "";
            
            if(!empty($is_pre_conditional)){
                $preConditionalFunc = "preConditionalComp(this.value,".$ques->EligibilityQuestion->unique_id.")";
            }
            if($ques->dependent_question != ''){
                if($preConditionalFunc != ''){
                    $preConditionalFunc .=",dependentQuestion(".$ques->dependent_component.",".$ques->dependent_question.",'".$ques->EligibilityQuestion->option_type."')";
                }else{
                    $preConditionalFunc .="dependentQuestion(".$ques->dependent_component.",".$ques->dependent_question.",'".$ques->EligibilityQuestion->option_type."')";
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

