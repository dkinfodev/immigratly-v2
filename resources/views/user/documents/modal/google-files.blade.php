
@if(count($drive_folders) > 0)
<div class="custom-control custom-checkbox mb-3 float-right">
  <input type="checkbox" id="customCheck11" class="custom-control-input checkall">
  <label class="custom-control-label" for="customCheck11">Check All</label>
</div>
<div class="clearfix"></div>
@endif
<div class="row">
@foreach($drive_folders as $key => $folder)
  <div class="col-md-2 mb-3">
      @if($folder['mimetype'] == 'application/vnd.google-apps.folder')
        <div class="card folder-block h-100" onclick="fetch_google_drive('{{$folder['id']}}','{{$folder['name']}}')" data-type="folder" data-id="{{$folder['id']}}" data-name="{{$folder['name']}}">
          <div class="card-body text-center">
            <div class="app-icon">
              <i class="tio-folder-add"></i>
            </div>
            <h3 class="mb-1">
              <span class="text-dark">{{$folder['name']}}</span>
            </h3>
          </div>
          <!-- End Body -->
        </div>
      @else
        <div class="card folder-block h-100" data-type="file" data-id="{{$folder['id']}}" data-name="{{$folder['name']}}">
          <div class="card-body text-center gdrive-file">
            <input type="checkbox" class="chk-file" style="display:none" name="files[]" value="{{$folder['id']}}" id="row-{{$key}}">
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

<script type="text/javascript">
$(document).ready(function(){
  $(".checkall").change(function(){
      if($(this).is(":checked")){
        $(".gdrive-file").addClass("active-card");
        $(".gdrive-file .chk-file").prop("checked",true);
      }else{
        $(".gdrive-file").removeClass("active-card");
        $(".gdrive-file .chk-file").prop("checked",false);
      }
  })
  $(".gdrive-file").click(function(){
    if($(this).hasClass("active-card")){
      $(this).removeClass("active-card");
      $(this).find('.chk-file').prop("checked",false);
    }else{
      $(this).addClass("active-card");
      $(this).find('.chk-file').prop("checked",true);
    }
  })
})
</script>