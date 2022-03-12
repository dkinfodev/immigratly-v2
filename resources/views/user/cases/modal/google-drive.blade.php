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
      <form method="post" id="popup-form" class="js-validate" action="{{ baseUrl('cases/google-drive/upload-from-gdrive') }}">  
        @csrf
        <input type="hidden" name="folder_id" value="{{$folder_id}}" />
        <input type="hidden" id="doc_type" name="doc_type" value="{{$doc_type}}" />
        <input type="hidden" id="subdomain" name="subdomain" value="{{$subdomain}}" />
        <input type="hidden" id="case_id" name="case_id" value="{{$case_id}}" />
        <nav aria-label="breadcrumb">
          <ol class="breadcrumb directory-nav">
            <li class="breadcrumb-item root-directory"><a href="javascript:;">Root</a></li>
          </ol>
        </nav>
        <div class="row" id="main-folders">
          @foreach($drive_folders as $key => $folder)
            <div class="col-md-2 mb-3">
                @if($folder['mimetype'] == 'application/vnd.google-apps.folder')
                  <div class="card folder-block h-100" onclick="fetch_google_drive('{{$folder['id']}}','{{$folder['name']}}')" data-type="folder" data-id="{{$folder['id']}}" data-name="{{$folder['name']}}">
                    <div class="card-body text-center">
                      <div class="app-icon">
                        <i class="tio-folder-add text-warning"></i>
                      </div>
                      <h3 class="mb-1">
                        <span class="text-dark">{{$folder['name']}}</span>
                      </h3>
                    </div>
                    <!-- End Body -->
                  </div>
                @else
                  <div class="card folder-block h-100" data-type="file" data-id="{{$folder['id']}}" data-name="{{$folder['name']}}">
                    <div class="card-body text-center">
                      <div class="custom-control custom-checkbox">
                        <input type="checkbox" class="custom-control-input row-checkbox" value="{{ base64_encode($folder['id']) }}" id="row-{{$key}}">
                        <label class="custom-control-label" for="row-{{$key}}"></label>
                      </div>
                      <div class="app-icon">
                        <i class="tio-document-text"></i>
                      </div>
                      <h3 class="mb-1">
                        <span class="text-dark">{{$folder['name']}}</span>
                      </h3>
                    </div>
                    <!-- End Body -->
                  </div>
                @endif
            </div>
          @endforeach
        </div>
        <div id="gdrive-files"></div>
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
      url:"{{ baseUrl('cases/google-drive/files-list') }}",
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