<style type="text/css">
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
@if(count($drive_folders) > 0)
<div class="custom-control custom-checkbox mb-3 float-right">
  <input type="checkbox" id="customCheck11" class="custom-control-input checkall">
  <label class="custom-control-label" for="customCheck11">Check All</label>
</div>
<div class="clearfix"></div>
@endif
<div class="row" id="main-folders">
  @foreach($drive_folders as $key => $folder)
    <div class="col-md-3 mb-3">
        @if($folder['is_dir'] == 1)
          <div class="card folder-block dropbox-folder h-100" onclick="fetch_dropbox_file('{{$folder['path']}}','{{$folder['name']}}')" data-type="folder" data-id="{{$folder['id']}}" data-name="{{$folder['name']}}">
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
          <div class="card folder-block dropbox-file h-100" data-type="file" data-id="{{$folder['id']}}" data-name="{{$folder['name']}}">
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

<script type="text/javascript">
$(document).ready(function(){
  $(".checkall").change(function(){
      if($(this).is(":checked")){
        $(".dropbox-file").addClass("active-card");
        $(".dropbox-file .chk-file").prop("checked",true);
      }else{
        $(".dropbox-file").removeClass("active-card");
        $(".dropbox-file .chk-file").prop("checked",false);
      }
  })
  $(".dropbox-file").click(function(){
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