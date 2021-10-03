    
    <!-- Table --> 
    <div class="table-responsive datatable-custom">
        @if(count($question_sequence) > 0)
        <form data-id="{{$visa_service_id}}" id="form-{{$visa_service_id}}" action="{{ url('/check-eligibility/g/'.$visa_service_id) }}" class="mt-3">
            @csrf
            <input type="hidden" name="eligible_type" value="group" />

                @if($action == 'multiple')
                <div class="card-header mb-3 h3 pl-3">{{$visa_service->name}}</div>
                @endif
                <ul class="sortable-ul mt-2 mb-2">
                @foreach($question_sequence as $record)
                <li class="ui-state-default mt-0" data-question="{{$record->Group->unique_id}}">

                    <div class="font-weight-bold text-danger pl-3"><i class="tio-arrow-large-forward"></i>
                        {{$record->Group->group_title}}</div>
                        @if($record->Group->description != '')
                        <p>
                        {{$record->Group->description}}
                        </p>
                        @endif
                        @foreach($record->Components as $component)
                            <?php
                            $grp_comp = checkIfGroupConditional($record->Group->unique_id,$component->Component->unique_id);
                            ?>
                            @if(empty($grp_comp))
                            <div class="component-blocks mt-3 bg-light p-3">
                                <div class="font-weight-bold text-warning">
                                    <i class="tio-chevron-right"></i> {{$component->Component->component_title}}
                                </div>
                                <ul class="sortable-ul mt-2 mb-2">
                                    @foreach($component->Component->Questions as $ques)
                                    <?php
                                        $option_selected = array();
                                        $check_ques = checkGroupConditionalQues($record->Group->unique_id,$component->Component->unique_id,$ques->EligibilityQuestion->unique_id);
                                        $block = 'block';
                                        ?>

                                        @if(\Auth::check())    
                                        <?php
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
                                        @endif
                                    <li class="ui-state-default quesli qs-{{ $record->Group->unique_id }}-{{ $component->Component->unique_id }}-{{ $ques->EligibilityQuestion->unique_id }}" data-group="{{ $record->Group->unique_id }}" data-component="{{$component->Component->unique_id}}" data-question="{{$ques->EligibilityQuestion->unique_id}}">

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
                                                <select  class="select2" onchange="conditionalQuestion(this,'select')" name="question[{{ $record->Group->unique_id }}][{{ $component->Component->unique_id }}][{{$ques->EligibilityQuestion->unique_id}}]" required>
                                            @else
                                                <select class="select2" name="question[{{ $record->Group->unique_id }}][{{ $component->Component->unique_id }}][{{$ques->EligibilityQuestion->unique_id}}]" required>
                                            @endif
                                                    <option value="">Select Option</option>
                                                    @foreach($ques->EligibilityQuestion->Options as $option)
                                                    <option {{ (!empty($option_selected) && $option->id == $option_selected['option_selected'])?'selected':'' }} data-option-id="{{$option->id}}" value="{{ $option->option_value }}">
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
                                                    <input {{ (!empty($option_selected) && $option->id == $option_selected['option_selected'])?'checked':'' }} type="radio" data-option-id="{{$option->id}}"
                                                        id="customInlineRadio-{{$component->component_id}}-{{$option->id}}"
                                                        onchange="conditionalQuestion(this,'radio')"
                                                        value="{{ $option->option_value }}" class="custom-control-input"
                                                        name="question[{{ $record->Group->unique_id }}][{{ $component->Component->unique_id }}][{{$ques->EligibilityQuestion->unique_id}}]"  required>
                                                    @else
                                                    <input {{ (!empty($option_selected) && $option->id == $option_selected['option_selected'])?'checked':'' }} type="radio" data-option-id="{{$option->id}}"
                                                        id="customInlineRadio-{{$component->component_id}}-{{$option->id}}" value="{{ $option->option_value }}"
                                                        class="custom-control-input"
                                                        name="question[{{ $record->Group->unique_id }}][{{ $component->Component->unique_id }}][{{$ques->EligibilityQuestion->unique_id}}]"  required>
                                                    @endif
                                                        
                                                        <label class="custom-control-label"
                                                            for="customInlineRadio-{{$component->component_id}}-{{$option->id}}">{{$option->option_label}} ({{$option->score}})</label>
                                                    </div>
                                                </div>
                                                <!-- End Form Check -->
                                                @endforeach

                                                @endif
                                                <!-- End Form Check -->
                                        </div>
                                    </li>
                                    @if(\Auth::check())    
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
                                    @endif
                                    @endforeach
                                </ul>
                            </div>
                            @endif
                        @endforeach
                    
                </li>
                @endforeach
            </ul>
            <div class="response-{{ $visa_service_id }} p-2 text-danger"></div>
            <div class="form-group text-center">
                <button type="submit" class="btn btn-primary submit-form">Save</button>
            </div>
        </form>
        @else
        <div class="text-danger text-center">Data not available</div>
        @endif
    </div>
<script>
@if($action == 'multiple')

@endif
</script>