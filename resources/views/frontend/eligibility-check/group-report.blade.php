<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.5.3/dist/css/bootstrap.min.css">
    <style>
    .page-break {
        page-break-after: always;
    }
    .card-header{
        height:54px;
    }
    .card-header h2{
        font-size:20px;
    }
    
    @page { margin: 0px; }
    body { margin: 0px; }
   
    body{
        font-family:"verdana";
    }
    </style>
</head>

<body class="container mt-5" style="font-family:verdana">
        <h2>{{$report->VisaService->name}}</h2>
        @foreach($questions as $key => $ques)
            <div class="card" style="margin-top:20px">
                <div class="card-header" style="min-height:65px;">
                    <div class="float-left">
                        <h3>{{$ques['group_title']}}</h3>
                    </div>
                    <div class="float-right">
                        <b>Max Score:</b> {{$ques['max_score']}}
                    </div>
                    <div class="clearfix"></div>
                </div>
                <div class="card-body">
                    <div class="table-responsive" style="margin-top:65px;clear:both;padding:0px;">
                        <table class="table table-bordered no-bordered">
                            <thead>
                                <tr>
                                    <th width="70%">Question</th>
                                    <th>Option Selected</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($ques['questions'] as $question)
                                    <tr>
                                        <td>
                                            <div><b>{{$question['question']}}</b></div>
                                            <p><?php echo $question['additional_notes'] ?></p>
                                        </td>
                                        <td>{{$question['selected_value']}}</td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
            @if($key < (count($questions) - 1))
            <div class="page-break"></div>
            @endif
        @endforeach
        <div style="text-align:center;color:red">
            <h3>Your Score: {{$score}}</h3>
        </div>
        <?php
            if($report->match_pattern != ''){
                $match_pattern = json_decode($report->match_pattern,true);
        ?>
                <div class="mt-2">
                    <h3>Your are Eligible for below Services</h3>
                    <ul class="elg-list">
                        @for($i=0;$i < count($match_pattern);$i++)
                            <?php
                                $visa_service = visaService($match_pattern[$i]);
                                if(!empty($visa_service)){
                            ?>
                            <li><i class="tio-chevron-right"></i> {{$visa_service->name}} </li>
                            <?php } ?>
                        @endfor
                    </ul>
                </div>
        <?php } ?>

        <?php if(count($cutoff_points) > 0){ ?>
            <div class="mt-2">
                <h3>Cutoff Points are as below</h3>
                @foreach($cutoff_points as $point)
                <div class="card mb-3">
                    <div class="card-body">
                        <div class="table-responsive">
                            <table class="table table-bordered">
                                <thead>
                                    <tr>
                                        <th colspan="2"><h3>{{$point->name}}</h3></th>
                                    </tr>
                                    <tr>
                                        <th>Cutoff Date</th>
                                        <th>Points</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach($point->CutoffPoints as $cutoff)
                                        <tr>
                                            <td>{{$cutoff->cutoff_date}}</td>
                                            <td>{{$cutoff->cutoff_point}}</td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
                @endforeach
            </div>
        <?php } ?>
</body>

</html>