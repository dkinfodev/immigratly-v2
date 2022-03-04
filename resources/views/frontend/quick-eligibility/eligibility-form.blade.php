 <!-- Card -->
 <div class="card mb-3">
        <!-- Table -->
        <div class="card-header">
            <h2>{{$visa_service->name}}</h2>
        </div>
        <div class="table-responsive datatable-custom">
            <form data-id="{{$visa_service_id}}" id="form-{{$visa_service_id}}" action="{{ baseUrl('/quick-eligibility/check/'.$visa_service_id) }}">
                @csrf
                <ul class="sortable mt-2 mb-2">
                    @foreach($question_sequence as $record)
                    <li class="ui-state-default" data-question="{{$record->Question->unique_id}}">

                        <div class="font-weight-bold"><i class="tio-arrow-large-forward"></i>
                            {{$record->Question->question}}</div>
                        @if($record->Question->additional_notes != '')
                        <div class="mt-2"><?php echo $record->Question->additional_notes ?></div>
                        @endif
                        <div class="question-options mt-2">
                            @if($record->Question->option_type == 'dropdown')
                            @if(!empty($record->Question->ComponentQuestions) ||
                            !empty($record->Question->ConditionalQuestions))
                            <select class="select2"
                                onchange="conditionalQuestion('{{ $record->Question->unique_id }}',this,'select')"
                                name="question[{{$record->Question->unique_id}}]">
                                @else
                                <select class="select2" name="question[{{$record->Question->unique_id}}]">
                                    @endif
                                    <option value="">Select Option</option>
                                    @foreach($record->Question->Options as $option)
                                    <option data-option-id="{{$option->id}}" value="{{ $option->option_value }}">
                                        {{$option->option_label}} ({{$option->score}})</option>
                                    @endforeach
                                </select>
                                @endif
                                @if($record->Question->option_type == 'radio')
                                <!-- Form Check -->
                                @foreach($record->Question->Options as $option)
                                <div class="form-check form-check-inline">
                                    <div class="custom-control custom-radio">
                                        @if(!empty($record->Question->ComponentQuestions) ||
                                        !empty($record->Question->ConditionalQuestions))
                                        <input type="radio" data-option-id="{{$option->id}}"
                                            id="customInlineRadio-{{$option->id}}"
                                            onchange="conditionalQuestion('{{ $record->Question->unique_id }}',this,'radio')"
                                            value="{{ $option->option_value }}" class="custom-control-input"
                                            name="question[{{$record->Question->unique_id}}]">
                                        @else
                                        <input type="radio" data-option-id="{{$option->id}}"
                                            id="customInlineRadio-{{$option->id}}" value="{{ $option->option_value }}"
                                            class="custom-control-input"
                                            name="question[{{$record->Question->unique_id}}]">
                                        @endif
                                        <label class="custom-control-label"
                                            for="customInlineRadio-{{$option->id}}">{{$option->option_label}} ({{$option->score}})</label>
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
                <div class="response-{{$visa_service_id}} p-2 text-danger"></div>
                <div class="form-group text-center">
                  <button type="submit" class="btn btn-primary submit-form">Save</button>
                </div>
            </form>
        </div>
        <!-- End Table -->

    </div>
    <!-- End Card -->

<script>
initForm("{{ $visa_service_id }}");
</script>