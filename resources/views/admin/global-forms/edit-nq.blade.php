<!doctype html>
<html lang="en">

<head>
    <!-- Required meta tags -->
    <title>{{companyName()}}</title>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <base href="{{ url('/') }}/assets/vendor/php-form-builder/drag-n-drop-form-builder/" />
    <link rel="stylesheet" href="../documentation/assets/stylesheets/bootstrap.min.css" />
</head>

<body>
    <div class="container">
        <div class="text-center mt-3">
            <a href="{{ baseUrl('global-forms') }}" class="btn btn-primary">Back to Form List</a>
        </div>
    </div>  
<?php 
$builder = file_get_contents(asset("assets/vendor/php-form-builder/drag-n-drop-form-builder/index.html"));
echo $builder;
?>
<button type="button" id="load-form" style="display:none" class="btn btn-primary">Load Form</button>
<div id="save-form-modal" class="modal fade" tabindex="-1" role="dialog" aria-labelledby="load-json-from-disk-btn" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    Save the Form 
                </div>
                <div class="modal-body">
                    <div class="form-group js-form-message">
                        <label>Form Title</label>
                        <input type="text" class="form-control" value="{{ $record->form_title }}" data-msg="Please enter a title." name="form_title" id="form_title">
                    </div>
                    <textarea id="form_json" style="display:none" name="form_json"><?php echo $record->form_json ?></textarea>
                    <div id="response_msg" class="mt-2"></div>
                    
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-warning" data-bs-dismiss="modal">Cancel</button>
                    <button onclick="saveForm()" id="saveBtn" type="button" class="btn btn-primary">Save</button>
                </div>
            </div>
        </div>
    </div>
<script src="{{asset('assets/vendor/jquery/dist/jquery.min.js')}}"></script>
<script>
$(document).ready(function(){
  setTimeout(function(){
    $("#load-form").click();
  },1500);
  
})
function saveForm(){
    // var formData = new FormData($("#form")[0]);
    var dataJson = $("#form_json").val();
    var form_title = $("#form_title").val();
    $("#response_msg").html('');
    var html = '';
    if(dataJson == ''){
        html += "Please add the form fields<br>";
    }
    if(form_title == ''){
        html += "Form Title is required<Br>";
    }
    if(html != ''){
        $("#response_msg").html('<div class="alert alert-danger">'+html+'</div>');
         return false;
    }
    var url  = "{{ baseUrl('global-forms/update/'.$record->unique_id) }}";
    
    $.ajax({
      url:url,
      type:"post",
      data:{
        _token:"{{ csrf_token() }}",
        form_title:form_title,
        form_json:dataJson,
      },
      dataType:"json",
      beforeSend:function(){
        $("#saveBtn").attr("disabled","disabled");
        $("#saveBtn").html("Processing...");
      },
      success:function(response){
        $("#saveBtn").removeAttr("disabled");
        $("#saveBtn").html("Save");
        if(response.status == true){
            window.location.href = response.redirect_back;
        }else{
            $("#response_msg").html('<div class="alert alert-danger">Some validation issue, try again</div>');
        }
      },
      error:function(){
        $("#saveBtn").removeAttr("disabled");
        $("#saveBtn").html("Save");
        $("#response_msg").html('<div class="alert alert-danger">Some internal issue, try again</div>');
      }
    });
}
</script>
</body>
</html>
