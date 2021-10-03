<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.5.3/dist/css/bootstrap.min.css">
    <style>
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
    <div>
        <div class="table-responsive">
            <table class="table table-bordered no-bordered">
                <tr>
                    <th colspan="2">
                        <h3>Assessment Details</h3>
                    </th>
                </tr>
                <tr>
                    <th>Assessment Title</th>
                    <td>{{ $record['assessment_title'] }}</td>
                </tr>
                <tr>
                    <th>Visa Service</th>
                    <td>{{ $record['visa_service']['name'] }}</td>
                </tr>
                <tr>
                    <th>Case Type</th>
                    <td>{{ $record['case_type'] }}</td>
                </tr>
                @if($record['additional_comment'] != '')
                <tr>
                    <th>Case Summary</th>
                    <td>{{ $record['additional_comment'] }}</td>
                </tr>
                @endif
                <tr>
                    <th>Date Generated</th>
                    <td>{{ dateFormat($record['created_at']) }}</td>
                </tr>
                <tr>
                    <th>Professional</th>
                    <?php 
                    $company_data = professionalDetail($record['professional']);
                    ?>
                    <td>{{ $company_data->company_name }}</td>
                </tr>
            </table>
        </div>
        <div class="card" style="padding:0px">
            
            <div class="card-body" style="padding:0px">
                <div style="margin-bottom:10px">
                    <h3>Case Report</h3>
                </div>
                <div class="form-group js-form-message">
                    <label class="font-weight-bold">Case Review</label>
                    <div class="editor-text">
                    @if(!empty($report))
                        <?php echo $report['case_review'] ?>
                    @endif
                    </div>
                </div>
                <div class="form-group js-form-message">
                    <label class="font-weight-bold">Strength of Case</label>
                    <div class="editor-text">
                    @if(!empty($report))
                        <?php echo $report['case_review'] ?>
                    @endif
                    </div>
                </div>
                <div class="form-group js-form-message">
                    <label class="font-weight-bold">Weakness of Case</label>
                    <div class="editor-text">
                    @if(!empty($report))
                        <?php echo $report['case_review'] ?>
                    @endif
                    </div>
                </div>
                <div class="form-group js-form-message">
                    <label class="font-weight-bold">Case Quality</label>
                    <div class="editor-text">{{ (!empty($report))?$report['case_quality']:'' }}</div>
                </div>
                <div class="form-group js-form-message">
                    <label class="font-weight-bold">Case Type</label>
                    <div class="editor-text">{{ (!empty($report))?$report['case_type']:'' }}</div>
                </div>
            </div>
        </div>
    </div>
</body>

</html>