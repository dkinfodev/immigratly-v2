<style type="text/css">
.folder-block .app-icon {
    font-size: 50px;
}
.folder-block {
    background-color: #EEE;
    cursor: pointer;
    transition: 0.6s;
}
.folder-block:hover, .active-card {
    background-color: #ddd;
    transition: 0.6s;
    border: 1px solid #377dff !important;
    border-radius: 10px;
}
</style>
<div class="modal-dialog modal-xl" role="document">
  <div class="modal-content">
    <div class="modal-header">
      <h5 class="modal-title" id="staticBackdropLabel">{{$pageTitle}}</h5>
      <button type="button" class="btn btn-xs btn-icon btn-ghost-secondary" data-dismiss="modal" aria-label="Close">
        <i class="tio-clear tio-lg"></i>
      </button>
    </div>
    <div class="modal-body">
      <form method="post" id="popup-form" class="js-validate" action="{{ baseUrl('/assessments/dropbox/upload-from-dropbox') }}">  
        @csrf
        <input type="hidden" name="folder_id" value="{{$folder_id}}" />
        <input type="hidden" id="assessment_id" name="assessment_id" value="{{$assessment_id}}" />
        <nav aria-label="breadcrumb">
          <ol class="breadcrumb directory-nav">
            <li class="breadcrumb-item root-directory"><a href="javascript:;">Root</a></li>
          </ol>
        </nav>
        <div class="row" id="main-folders">
          @foreach($drive_folders as $key => $folder)
            <div class="col-md-3 mb-3">
                @if($folder['is_dir'] == 1)
                  <div class="card folder-block dropbox-folder h-100" onclick="fetch_dropbox_file('{{$folder['path']}}','{{$folder['name']}}')" data-type="folder" data-path="{{$folder['path']}}" data-id="{{$folder['id']}}" data-name="{{$folder['name']}}">
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
                  <div class="card folder-block dropbox-file h-100" data-type="file" data-id="{{$folder['id']}}" data-name="{{$folder['name']}}" data-link="{{$folder['download_link']}}">
                    <div class="card-body text-center dropbox-file">
                      <input type="checkbox" class="chk-file" style="display:none" name="files[]" value="{{$folder['path']}}:::{{$folder['name']}}" id="row-{{$key}}">
                      <div class="clearfix"></div>
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
        <div id="dropbox-files"></div>
      </form>
    </div>
    <div class="modal-footer">
      <button type="button" class="btn btn-white" data-dismiss="modal">Close</button>
      <button form="popup-form" class="btn btn-primary">Upload Files</button>
    </div>
  </div>
</div>

<script type="text/javascript">
$(document).ready(function(){
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
                fetchDocuments('<?php echo $assessment_id ?>','<?php echo $folder_id ?>');
              }else{
                errorMessage(response.message);
              }
            },
            error:function(){
              internalError();
            }
        });
    });
    $(".dropbox-folder").click(function(){
        var folder_id = $(this).attr("data-path");
        var folder_name = $(this).attr("data-name");
        fetch_dropbox_file(folder_id,folder_name);
    });

    $(".root-directory").click(function(){
        $("#main-folders").fadeIn();
        $("#dropbox-files").html('');
        $(".goto").remove();
    });
    $(".dropbox-file").click(function(){
      if($(this).hasClass("active-card")){
        $(this).removeClass("active-card");
        $(this).find('.chk-file').prop("checked",false);
      }else{
        $(this).addClass("active-card");
        $(this).find('.chk-file').prop("checked",true);
      }
    })
});

function fetch_dropbox_file(folder_id='',folder_name=''){
  $.ajax({
      url:"{{ baseUrl('assessments/dropbox/files-list') }}",
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
          $("#dropbox-files").html(response.contents);
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