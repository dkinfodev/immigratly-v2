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
        
        <div class="form-group js-form-message">
          <h>Form Title:<b> {{$record['form_title']}}</b></h3>
        </div>
        <div class="table-responsive">
            <table class="table table-bordered">
              @foreach($form_json as $form)
              <tr>
                <th>{{$form['label']}}</th>
                <td>{{$form['value']}}</td>
              </tr>
              @endforeach
            </table>
        </div>
        
</body>

</html>