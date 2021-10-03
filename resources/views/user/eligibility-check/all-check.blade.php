@extends('layouts.master')

@section('content')
<style>
.sortable {
    list-style: none;
    margin: 0px;
    padding: 0px;
}

.sortable li {
    margin: 12px;
    border-radius: 7px;
}
</style>
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
                                href="{{ baseUrl('/visa-services') }}">Visa Services</a></li>
                        <li class="breadcrumb-item active" aria-current="page">{{$pageTitle}}</li>
                    </ol>
                </nav>

                <h1 class="page-title">{{$pageTitle}}</h1>
            </div>

            <div class="col-sm-auto">

                <a class="btn btn-primary btn-sm"
                    href="{{ baseUrl('/eligibility-check') }}">
                    Back
                </a>
            </div>
        </div>
        <!-- End Row -->
    </div>
    <div id="eligibility-forms">

    </div>
</div>
<!-- End Content -->
@endsection

@section('javascript')
<script>
loadData();
var total_records;
var last_page;
var current_page;
function loadData(page=1){
    $.ajax({
        type: "GET",
        url: BASEURL + '/eligibility-check/eligibility-form?page='+page,
        data:{
            next_page:page
        },
        dataType:'json',
        beforeSend:function(){
            showLoader();
        },
        success: function (data ) {
            hideLoader();
            if(data.status == true){
                $("#eligibility-forms").append(data.contents);
                initSelect();
                total_records = data.total_records;
                current_page = data.current_page;
                last_page = data.last_page;
            }else{
                errorMessage(data.message);
                redirect(data.redirect_url);
            }
            
        },
        error:function(){
            internalError();
        }
    });
}

function initForm(id){
    $("#form-"+id).submit(function(e){
      e.preventDefault();
      var formData = $("#form-"+id).serialize();
      var url  = $("#form-"+id).attr('action');
      $.ajax({
        url:url,
        type:"post",
        data:formData,
        dataType:"json",
        beforeSend:function(){
          showLoader();
          $(".response-"+id).html('');
        },
        success:function(response){
          hideLoader();
          if(response.status == true){
            var html ="<div class='text-center text-danger p-2 bg-light'><h2>Your Eligibility Score: "+response.score+"</h2>";
            $(".response-"+id).html(html);
            $("#form-"+id+" .submit-form").remove();
            var next_page = current_page+1;
            if(next_page <= last_page){
                loadData(next_page);
            }
          }else{
            $(".response-"+id).html(response.message);
          }
        },
        error:function(){
            internalError();
        }
      });
    });
}
function conditionalQuestion(question_id, e, ele) {
    var option_value = '';
    var form_id = $(e).parents("form").attr("data-id");
    var value = $(e).val();
    if (ele == 'select') {
        option_value = $(e).find("option[value=" + value + "]").attr("data-option-id");
    }
    if (ele == 'radio') {
        option_value = $(e).attr("data-option-id");
    }
    $.ajax({
        type: "POST",
        url: BASEURL + '/eligibility-check/fetch-conditional',
        data: {
            _token: csrf_token,
            question_id: question_id,
            option_value: option_value
        },
        dataType: 'json',
        beforeSend: function() {
            // showLoader();
            $("#form-"+form_id+" .conditional-" + question_id).remove();
        },
        success: function(response) {
            hideLoader();
            if (response.status == true) {
                $("#form-"+form_id+" li[data-question=" + question_id + "]").append(response.contents);
                initSelect();
            }
        },
        error: function() {
            internalError();
        }
    });
}
</script>
@endsection