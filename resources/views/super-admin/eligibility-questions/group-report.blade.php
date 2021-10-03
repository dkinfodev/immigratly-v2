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

        @foreach($questions as $key => $ques)
            <div class="card" style="margin-bottom:10px">
                <div class="card-header" style="min-height:65px;">
                    <div class="float-left">
                        <h3>{{$ques['group_title']}}</h3>
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
</body>

</html>