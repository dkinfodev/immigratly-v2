<style>
.invalid-feedback {
    position: absolute;
    bottom: -20px;
}
.folder-block .app-icon {
    font-size: 50px;
}
.folder-block {
    background-color: #EEE;
    cursor: pointer;
    transition: 0.6s;
}
.folder-block:hover,.active-card {
    background-color: #ddd;
    transition: 0.6s;
}
</style>

<div class="modal-dialog" role="document">
  <div class="modal-content">
    <div class="modal-header">
        <div class="imm-modal-slanted-div angled lower-start">
          <div class="row">
            <div class="col-10">
              <h3 class="modal-title" id="exampleModalLongTitle">{{$pageTitle}}</h3>
            </div>
           <div class="col-2" style="text-align:right"> 
              <button type="button" class="btn-close" data-dismiss="modal" aria-label="Close"></button>
            </div>
          </div>
        </div>
    </div>

    <div class="modal-body imm-education-modal-body">
      <form method="post" id="popup-form"  action="{{ baseUrl('/notes/add-reminder-note') }}">  
          @csrf
          <!-- Form Group -->
          <div class="row form-group">
            <label class="col-sm-3 col-form-label input-label">Reminder Date</label>

            <div class="col-sm-9 js-form-message">
              <input autocomplete="off" type="text" class="form-control reminder_date @error('reminder_date') is-invalid @enderror" name="reminder_date" id="reminder_date" placeholder="Enter Reminder Date" aria-label="Enter Reminder Date" value="">
              @error('reminder_date')
              <span class="invalid-feedback" role="alert">
                <strong>{{ $message }}</strong>
              </span>
              @enderror
            </div>
          </div>
          <!-- End Form Group -->

          <!-- Form Group -->
          <div class="row form-group">
            <label class="col-sm-3 col-form-label input-label">Message</label>

            <div class="col-sm-9 js-form-message">
              <textarea class="form-control @error('message') is-invalid @enderror" name="message" placeholder="Enter your message..." aria-label="Percentage" value=""></textarea>
              @error('percentage')
              <span class="invalid-feedback" role="alert">
                <strong>{{ $message }}</strong>
              </span>
              @enderror
            </div>
          </div>
          <!-- End Form Group -->
        </form>
    </div>
    <div class="modal-footer">
      <button type="button" class="btn btn-white" data-dismiss="modal">Close</button>
      <button form="popup-form" type="submit" class="btn btn-primary">Save</button>
    </div>

  </div>
</div>



<script type="text/javascript">
$(document).ready(function(){
  $(".gdrive-file").click(function(){
    if($(this).hasClass("active-card")){
      $(this).removeClass("active-card");
      $(this).find('.chk-file').prop("checked",false);
    }else{
      $(this).addClass("active-card");
      $(this).find('.chk-file').prop("checked",true);
    }
  })
    $("#popup-form").submit(function(e){
        e.preventDefault();
        var formData = $("#popup-form").serialize();
        var url  = $("#popup-form").attr('action');
        $.ajax({
            url:url,
            type:"post",
            data:formData,
            dataType:"json",
            beforeSend:function(){
              showLoader();
            },
            success:function(response){
              hideLoader();
              if(response.status == true){
                successMessage(response.message);
                closeModal();
                location.reload();
              }else{
                errorMessage(response.message);
              }
            },
            error:function(){
              internalError();
            }
        });
    });
    $(".gdrive-folder").click(function(){
        var folder_id = $(this).attr("data-id");
        var folder_name = $(this).attr("data-name");
        fetch_google_drive(folder_id,folder_name);
    });

    $(".root-directory").click(function(){
        $("#main-folders").fadeIn();
        $("#gdrive-files").html('');
        $(".goto").remove();
    });
});

function fetch_google_drive(folder_id='',folder_name=''){
  $.ajax({
      url:"{{ baseUrl('documents/google-drive/files-list') }}",
      type:"post",
      data:{
        _token:"{{ csrf_token() }}",
        folder_id:folder_id,
        folder_name:folder_name,
      },
      dataType:"json",
      beforeSend:function(){
        showLoader();
      },
      success:function(response){
        hideLoader();
        if(response.status == true){
          $("#main-folders").fadeOut();
          $(".goto").removeClass('active');
          var flag = 1;
          $(".goto").each(function(){
              if($(this).attr('data-id') == folder_id){
                flag = 0;
                $(this).addClass('active');
              }
          });
          if(flag == 1){
            var html = '<li data-id="'+folder_id+'" onclick="fetch_google_drive(&apos;'+folder_id+'&apos;,&apos;'+folder_name+'&apos;)" class="breadcrumb-item goto active"><a href="javascript:;">'+folder_name+'</a></li>';
            $(".directory-nav").append(html);
          }
          var remove_li = false;
          $(".goto").each(function(){
            if(remove_li == true){
              $(this).remove();
            }
            if($(this).hasClass("active")){
              remove_li = true;
            }
          })
          $("#gdrive-files").html(response.contents);
        }else{
          warningMessage("Some issue while fetching files");
        }
      },
      error:function(){
        internalError();
      }
  });
}
</script>