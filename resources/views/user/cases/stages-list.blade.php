@foreach($records as $key => $record)
<div class="card mb-3">
    <div class="card-header p-0">
        <div class="row">
            <div class="col-md-4">
                <h5 class="cards-title pt-3 pb-2">{{ ucwords($record['name']) }}</h5>
            </div>
            <div class="col-md-8">
                <div class="row">
                    <div class="col-md-2 offset-md-4">
                        <div class="float-right">
                            @php
                            $total_stages = count($record['sub_stages']);
                            $total_completed = count($record['completed_stages']);
                            if($total_completed > 0){
                            $percent = ($total_completed/$total_stages)*100;
                            }else{
                            $percent = 0;
                            }

                            @endphp
                            <div class="js-circle" data-hs-circles-options='{
                    "value": "{{$percent}}",
                    "maxValue": 100,
                    "duration": 2000,
                    "isViewportInit": true,
                    "colors": ["rgba(55, 125, 255, 0.1)", "#377dff"],
                    "radius": 15,
                    "width": 4,
                    "textFontSize": 16,
                    "additionalText": "",
                    "textClass": "circle-custom-text",
                    "textColor": "#377dff"
                  }'>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="card-body p-">
        <p class="card-text">{{ $record['short_description'] }}</p>
        @if(count($record['sub_stages']) > 0)
        <div class="substagelists">
            <table class="table table-bordered noborder">
                <thead>
                    <tr>
                        <th colspan="4" class="bg-light">Stage Tasks</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($record['sub_stages'] as $key=>$substage)
                    <tr>
                        <td>
                            <i class="tio tio-circle"></i> {{$substage['name']}} &nbsp;
                        </td>
                        <td>
                            @if($substage['stage_type'] == "fill-form")
                            Fill Form
                            @elseif($substage['stage_type'] == 'case-task')
                            Case Task
                            @elseif($substage['stage_type'] == 'case-document')
                            Case Document
                            @elseif($substage->stage_type == 'case-task')
                            Case Task
                            @endif
                        </td>
                        <td class="text-center">
                            @if($substage['status'] == '1')
                            <span class="badge badge-success">Completed</span>
                            @else
                            <span class="badge badge-danger">Pending</span>
                            @endif
                        </td>
                        <td>
                            <a data-toggle="tooltip" data-html="true" title="Click to View"
                                class="btn btn-sm btn-dark p-2 js-nav-tooltip-link"
                                href="<?php echo baseUrl('cases/sub-stages/view/'.$case_id.'/'.$professional.'/'.$substage['unique_id']); ?>"><i
                                    class="tio-globe"></i></a>

                        </td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
        @endif
    </div>
</div>
    @endforeach

    <script type="text/javascript">
    $(document).ready(function() {
        $('.js-nav-tooltip-link').tooltip({
            boundary: 'window'
        })
        $('.js-hs-action').each(function() {
            var unfold = new HSUnfold($(this)).init();
        });
    })
    </script>