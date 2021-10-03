@extends('layouts.master')
@section('style')
<style type="text/css">
.payment-option li {
    width: 100%;
}
</style>
@endsection
@section('content')
<!-- Content -->
<div class="content container-fluid">
    <!-- Page Header -->
    <div class="page-header">
        <div class="row align-items-end">
            <div class="col-sm mb-2 mb-sm-0">
                <nav aria-label="breadcrumb">
                    <ol class="breadcrumb breadcrumb-no-gutter">
                        <li class="breadcrumb-item"><a class="breadcrumb-link" href="{{ baseUrl('/') }}">Dashboard</a>
                        </li>
                        <li class="breadcrumb-item"><a class="breadcrumb-link"
                                href="{{ baseUrl('/assessments') }}">Assessments</a></li>
                        <li class="breadcrumb-item active" aria-current="page">{{$pageTitle}}</li>
                    </ol>
                </nav>
                <h1 class="page-title">{{$pageTitle}}</h1>
            </div>

            <div class="col-sm-auto">
             
                
                <a class="btn btn-primary" href="{{baseUrl('assessments')}}">
                    <i class="tio mr-1"></i> Back
                </a>
            </div>
        </div>
        <!-- End Row -->
    </div>  
    <div class="card">
        <div class="card-header">
            <h2> Assessment Details</h2>
        </div>
        <div class="card-body">
            <!-- Step Form -->
            <table class="table table-bordered no-bordered">
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
            </table>

        </div>
        <!-- End Card -->
    </div>
    <div class="card mt-3" id="amount_to_pay">
        <div class="card-header">
            <h2>Case Report</h2>
        </div>
        <div class="card-body">
            <form id="form" class="js-validate" action="{{ baseUrl('assessments/report/'.$record['unique_id']) }}" method="post">
                @csrf
                <div class="form-group js-form-message">
                    <label class="font-weight-bold">Case Review</label>
                    <textarea name="case_review" data-msg="Please enter description." id="case_review" class="form-control editor">
                    @if(!empty($report))
                        <?php echo $report['case_review'] ?>
                    @endif
                    </textarea>
                </div>
                <div class="form-group js-form-message">
                    <label class="font-weight-bold">Strength of Case</label>
                    <textarea name="strength_of_case" data-msg="Please enter description." id="strength_of_case" class="form-control editor">
                    @if(!empty($report))
                        <?php echo $report['case_review'] ?>
                    @endif
                    </textarea>
                </div>
                <div class="form-group js-form-message">
                    <label class="font-weight-bold">Weakness of Case</label>
                    <textarea name="weakness_of_case" data-msg="Please enter description." id="weakness_of_case" class="form-control editor">
                    @if(!empty($report))
                        <?php echo $report['case_review'] ?>
                    @endif
                    </textarea>
                </div>
                <div class="form-group js-form-message">
                    <label class="font-weight-bold">Case Quality</label>
                    <input name="case_quality" id="case_quality" class="form-control" value="{{ (!empty($report))?$report['case_quality']:'' }}" placeholder="Case Quality" />
                </div>
                <div class="form-group js-form-message">
                    <label class="font-weight-bold">Case Type</label>
                    <input name="case_type" id="case_type" class="form-control" value="{{ (!empty($report))?$report['case_type']:'' }}" placeholder="Case Type" />
                </div>
                <div class="form-response mb-2 text-danger"></div>
                <div class="form-group">
                    <button type="submit" id="submitbtn" class="btn add-btn btn-primary">Save</button>
                </div>
            </form>
        </div>
    </div>

@endsection

@section('javascript')

<!-- JS Implementing Plugins -->
<script src="assets/vendor/jquery-validation/dist/jquery.validate.min.js"></script>
<!-- JS Front -->

<script type="text/javascript">
initEditor("case_review",'basic'); 
initEditor("strength_of_case",'basic'); 
initEditor("weakness_of_case",'basic'); 
$(document).ready(function(){
    $("#form").submit(function(e){
        e.preventDefault();
        var url  = $("#form").attr('action');
        var formData = $("#form").serialize();
        $.ajax({
            url:url,
            type:"post",
            data:formData,
            dataType:"json",
            beforeSend:function(){
                showLoader();
                $(".form-response").html('');
            },
            success:function(response){
                hideLoader();
                
                if(response.status == true){
                    successMessage(response.message);
                }else{
                    validation(response.message);
                }
            },
            error:function(){
                internalError();
            }
        });
    }); 
});
</script>
@endsection