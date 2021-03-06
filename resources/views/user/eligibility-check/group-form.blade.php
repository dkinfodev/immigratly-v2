<form data-id="{{$visa_service_id}}" id="form-{{$visa_service_id}}" action="{{ baseUrl('/eligibility-check/g/'.$visa_service_id) }}" class="mt-3">
    @if($action == 'multiple')
        <div class="card-header mb-3 h3 pl-3">{{$visa_service->name}}</div>
    @endif
    @csrf
    <?php
        $init_change = '';

        if($visa_service->question_as_sequence == 1){
            $init_change = 'initChange(this),';
        }
    ?>
    <ul class="imm-assessment-form-list-main-wrapper">
        @foreach($question_sequence as $key => $record)
        <li class="group-block" data-question="{{$record->Group->unique_id}}" style="display:{{ ($visa_service->question_as_sequence == 1 && $key > 0)?'none':'block' }}">
            <!-- Card -->
            <div class=" h-100 imm-assessment-form-list-main">
                <!-- Card Body -->
                <div class="imm-assessment-form-list-main-header">
                    <div class="row align-items-center">
                        <div class="col-xs-12 col-sm-7">
                            <span class="imm-specific-program-score-status">Score based</span>
                        </div>
                        <div class="col-xs-12 col-sm-5" style="text-align:right">
                            <a href="javacript:;">BC Provincial Nominee Program (BC PNP)</a>
                        </div>
                    </div>
                </div>
                <div class="imm-assessment-form-list-main-body mb-2 ">
                    <div class="row align-items-center">
                        <div class="col-xs-12 col-sm-8">

                            <h3 class="imm-group-title mb-2">
                                {{$record->Group->group_title}}
                            </h3>
                        </div>
                        <div class="col-xs-12 col-sm-4">
                            Maximum {{$record->Group->max_score}} Point
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-8">
                        @if($record->Group->description != '')
                            <div class="imm-self-assessment-container">
                                <div class="row">
                                    <div class="col-12">
                                        <p><?php echo $record->Group->description ?></p>
                                    </div>

                                </div>
                            </div>
                        @endif
                        </div>
                        <div class="col-4"> </div>
                    </div>
                    <!-- End Row -->

                </div>
                <!-- End Card Body -->

                <!-- Card Footer -->
                <div class="imm-assessment-form-list-main-footer">
                </div>
                <!-- End Card Footer -->
            </div>
            <!-- End Card -->
            @foreach($record->Components as $component)
            @if(!empty($component->Component) && !empty($record->Group))
            <?php
                $grp_comp = checkIfGroupConditional($record->Group->unique_id,$component->Component->unique_id);
                $is_comp_conditional = componentPreConditions('component',$component->Component->unique_id);
                $comp_display = "block";
               
               
                $comp_ques_id = '';
                if(!empty($is_comp_conditional)){
                    $comp_display = "none";
                    $comp_ques_id = "comp-ques-".$is_comp_conditional->question_id;
                }
            ?>
            @if(empty($grp_comp))
            <div class="h-100 imm-assessment-form-list-component-wrapper {{$comp_ques_id}} component-{{$component->Component->unique_id}}" data-max="{{ $component->Component->max_score }}" data-min="{{ $component->Component->min_score }}" style="display:{{ $comp_display }}">
                <div class=" h-100 imm-assessment-form-list-component">
                    <div class="imm-assessment-form-list-component-header">
                        <div class="d-flex" style="text-align:right">
                            <img class="me-2" src="./assets/img/checked.svg" alt="" style="width:18px">
                            <h4>{{$component->Component->component_title}}</h4>
                        </div>
                    </div>
                    <div class="imm-assessment-form-list-component-body">
                        <div class="row">
                            <div class="col-8">
                                @if($component->Component->description)
                                <p><?php echo $component->Component->description ?></p>
                                @endif
                            </div>
                            <div class="col-4">
                            </div>
                        </div>
                    </div>
                </div>
                <ul class="imm-assessment-form-list-sub-wrapper">
                @foreach($component->Component->Questions as $ques)
                <?php
                    $dependent_data = '';
                    if($ques->dependent_question != ''){
                        $dependent_data = 'data-dependent='.$ques->dependent_question;
                    }
                    $checkIfDependent = dependentQuestions($component->Component->unique_id,$ques->question_id);
                    
                    $option_selected = array();
                    $check_ques = checkGroupConditionalQues($record->Group->unique_id,$component->Component->unique_id,$ques->EligibilityQuestion->unique_id);
                    $block = 'block';
                    $is_pre_conditional = componentPreConditions('question',$ques->EligibilityQuestion->unique_id);
                    $preConditionalFunc = "";
                    $depcomclass='';
                    if(count($is_pre_conditional)>0){
                        $preConditionalFunc = ",preConditionalComp(this.value,".$ques->EligibilityQuestion->unique_id.")";  
                    }
                    
                    if($checkIfDependent->count() > 0){
                        $preConditionalFunc .=",dependentQuestion(this,".$ques->EligibilityQuestion->unique_id.",'".$ques->EligibilityQuestion->option_type."')";
                        $depcomclass='data-depcom='.$component->Component->unique_id."-".$ques->EligibilityQuestion->unique_id;
                    }
                    if($ques->EligibilityQuestion->language_prof_type == 0){
                        if($ques->EligibilityQuestion->linked_to_cv == 'yes'){
                            $block = 'none';
                            $cv_section = $ques->EligibilityQuestion->cv_section;
                            $elg_options = $ques->EligibilityQuestion->Options;
                            $option_selected = cvBasedOptions($cv_section,$elg_options,$ques->EligibilityQuestion,$component->Component->unique_id);
                            
                            if($option_selected['option_selected'] == ''){
                                $block = 'block';
                            }
                        }
                    }else{
                        $block="none";
                    }
                ?>
                    <li class="quesli qs-{{ $record->Group->unique_id }}-{{ $component->Component->unique_id }}-{{ $ques->EligibilityQuestion->unique_id }}" 
                        data-group="{{ $record->Group->unique_id }}" 
                        data-component="{{$component->Component->unique_id}}" 
                        data-question="{{$ques->EligibilityQuestion->unique_id}}"
                        style="display:{{($ques->dependent_question != '')?'none':'block' }}">
                        <div class="h-100 imm-assessment-form-list-question-wrapper">
                            <div class="h-100 imm-assessment-form-list-question">
                                <div class="imm-assessment-form-list-question-header"> {{$ques->EligibilityQuestion->question}}</div>
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
                                                                <option value="{{ $prof->unique_id }}">{{$prof->name}}</option>
                                                                @endforeach
                                                            </select>
                                                        </div>

                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <span class="lngpreselect text-danger"></span>
                                    @endif
                                    <span class="preselect text-danger"></span>
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
                                            data-quesid="{{ $ques->EligibilityQuestion->unique_id }}"
                                            {{$dependent_data}}
                                            {{$depcomclass}}
                                            data-element="select"
                                            onchange="conditionalQuestion(this,'select'),countTotal(this,{{ $component->Component->unique_id }},{{ $ques->EligibilityQuestion->unique_id }}){{$preConditionalFunc}}"
                                            name="question[{{ $record->Group->unique_id }}][{{ $component->Component->unique_id }}][{{$ques->EligibilityQuestion->unique_id}}]">
                                        @else
                                        <select {{ ($comp_display == "none")?'disabled':'' }} 
                                            class="select2 dropdown-field"
                                            data-quesid="{{ $ques->EligibilityQuestion->unique_id }}"
                                            data-element="select"
                                            {{$dependent_data}}
                                            {{$depcomclass}}
                                            onchange="{{$init_change}}countTotal(this,{{ $component->Component->unique_id }},{{ $ques->EligibilityQuestion->unique_id }}){{$preConditionalFunc}}"
                                            name="question[{{ $record->Group->unique_id }}][{{ $component->Component->unique_id }}][{{$ques->EligibilityQuestion->unique_id}}]">
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
                                                    {{$option->option_label}}
                                                    @if($ques->EligibilityQuestion->wage_type == 1)
                                                        ({{$option->wage_type}})
                                                    @endif
                                                     ({{$option->score}})
                                                </option>
                                                @endif
                                                @endif
                                                @else
                                                <option data-noneligible="{{ $option->non_eligible }}"
                                                    data-none-eligible-reason="{{ $option->non_eligible_reason }}"
                                                    data-score="{{ $option->score }}"
                                                    {{ (!empty($option_selected) && $option->option_value == $option_selected['option_selected'])?'selected':'' }}
                                                    data-option-id="{{$option->id}}" value="{{ $option->option_value }}">
                                                    {{$option->option_label}} 
                                                    @if($ques->EligibilityQuestion->wage_type == 1)
                                                        ({{$option->wage_type}})
                                                    @endif
                                                    ({{$option->score}})
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
                                                        data-score="{{ $option->score }}" 
                                                        data-noneligible="{{ $option->non_eligible }}"
                                                        data-none-eligible-reason="{{ $option->non_eligible_reason }}"
                                                        data-option-id="{{$option->id}}"
                                                        data-element="radio"
                                                        data-quesid="{{ $ques->EligibilityQuestion->unique_id }}"
                                                        id="customInlineRadio-{{$component->component_id}}-{{$option->id}}"
                                                        {{$depcomclass}}
                                                        {{$dependent_data}}
                                                        onchange="conditionalQuestion(this,'radio'),countTotal(this,{{ $component->Component->unique_id }},{{ $ques->EligibilityQuestion->unique_id }}){{$preConditionalFunc}}"
                                                        value="{{ $option->option_value }}" 
                                                        class="custom-control-input radio-field"
                                                        name="question[{{ $record->Group->unique_id }}][{{ $component->Component->unique_id }}][{{$ques->EligibilityQuestion->unique_id}}]">
                                                    @else
                                                    <input {{$checked}} {{ ($comp_display == "none")?'disabled':'' }}
                                                        data-score="{{ $option->score }}"
                                                        onchange="{{$init_change}}countTotal(this,{{ $component->Component->unique_id }},{{ $ques->EligibilityQuestion->unique_id }}){{$preConditionalFunc}}"
                                                        type="radio" 
                                                        data-noneligible="{{ $option->non_eligible }}"
                                                        data-none-eligible-reason="{{ $option->non_eligible_reason }}"
                                                        data-option-id="{{$option->id}}"
                                                        data-element="radio"
                                                        data-quesid="{{ $ques->EligibilityQuestion->unique_id }}"
                                                        id="customInlineRadio-{{$component->component_id}}-{{$option->id}}"
                                                        {{$depcomclass}}
                                                        {{$dependent_data}}
                                                        value="{{ $option->option_value }}" 
                                                        class="custom-control-input radio-field"
                                                        name="question[{{ $record->Group->unique_id }}][{{ $component->Component->unique_id }}][{{$ques->EligibilityQuestion->unique_id}}]">
                                                    @endif

                                                    <label class="custom-control-label"
                                                        for="customInlineRadio-{{$component->component_id}}-{{$option->id}}">{{$option->option_label}}
                                                        @if($ques->EligibilityQuestion->wage_type == 1)
                                                            ({{$option->wage_type}})
                                                        @endif
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

                        @if($ques->EligibilityQuestion-> option_type == 'radio')
                        var e = $(
                            ".qs-{{ $record->Group->unique_id }}-{{ $component->Component->unique_id }}-{{ $ques->EligibilityQuestion->unique_id }} input[type=radio]:checked"
                            );
                        conditionalQuestion(e, 'radio');
                        @endif

                        @if($ques->EligibilityQuestion->option_type == 'select')
                        var e = $(
                            ".qs-{{ $record->Group->unique_id }}-{{ $component->Component->unique_id }}-{{ $ques->EligibilityQuestion->unique_id }} select"
                            );
                        conditionalQuestion(e, 'select');
                        @endif
                    }, 1000);
                    </script>
                    @endif
                @endforeach
                </ul>
            </div>
            @endif
            @endif
            @endforeach    
        </li>
        @endforeach
    </ul>

    <div class="mt-3 text-center">
        <button type="submit" class="btn btn-info btn-sm w-100">Submit</button>
    </div>
</form>

<script>
@if($action == 'multiple')
initForm("{{$visa_service_id}}");
@endif
</script>