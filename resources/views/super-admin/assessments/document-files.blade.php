<div class="card-body p-0 mt-3">
    {{-- <div class="col-sm-auto mb-3 mt-3">
        <div role="group">
           @if($user_details->dropbox_auth != '')
           <a class="btn btn-outline-primary btn-sm"  onclick="showDropboxFiles()"  href="javascript:;"><i class="tio-google-drive mr-1"></i> Upload from Dropbox</a>
           @endif
           @if($user_details->google_drive_auth != '')
           <a class="btn btn-outline-primary btn-sm"  onclick="showGoogleFiles()" href="javascript:;"><i class="tio-google-drive mr-1"></i> Upload from Google Drive</a>
           @endif
           <a class="btn btn-primary btn-sm"  href="javascript:;" data-toggle="collapse" data-target="#collapseOne" aria-expanded="true" aria-controls="collapseOne"><i class="tio-upload-on-cloud mr-1"></i> Upload</a>
        </div>
     </div> --}}
      <div id="collapseOne" class="collapse" aria-labelledby="headingOne">
        <div class="card-body">
          <!-- Dropzone -->
            <div id="attachFilesLabel-{{ mt_rand(1000,9999) }}" class="js-dropzone dropzone-custom custom-file-boxed"
               data-hs-dropzone-options='{
                  "url": "<?php echo baseUrl('assessments/files/upload-documents') ?>?_token=<?php echo csrf_token() ?>&assessment_id=<?php echo $assessment->unique_id ?>&folder_id=<?php echo $folder->unique_id ?>",
                  "thumbnailWidth": 100,
                  "thumbnailHeight": 100
               }'
            >
               <div class="dz-message custom-file-boxed-label">
                  <img class="avatar avatar-xl avatar-4by3 mb-3" src="./assets/svg/illustrations/browse.svg" alt="Image Description">
                  <h5 class="mb-1">Drag and drop your file here</h5>
                  <p class="mb-2">or</p>
                  <span class="btn btn-sm btn-white">Browse files</span>
               </div>
            </div>
            <!-- End Dropzone -->
        </div>
      </div>
    <div class="table-responsive datatable-custom">
         <table id="datatable" class="table table-borderless table-thead-bordered card-table">
            <thead class="thead-light">
               <tr>
                  <th scope="col" class="table-column-pr-0">
                     <div class="custom-control custom-checkbox">
                        <input id="datatableCheckAll" type="checkbox" class="custom-control-input">
                        <label class="custom-control-label" for="datatableCheckAll"></label>
                     </div>
                  </th>
                  <th scope="col" class="table-column-pl-0">Document Name</th>
                  <th scope="col"></th>
               </tr>
            </thead>
            <tbody>
               @foreach($documents as $key => $doc)
               <tr>
                  <td class="table-column-pr-0">
                     <div class="custom-control custom-checkbox">
                        <input type="checkbox" class="custom-control-input row-checkbox" id="row-{{$key}}" value="{{ base64_encode($doc->id) }}">
                        <label class="custom-control-label" for="row-{{$key}}"></label>
                     </div>
                  </td>
                  <td class="table-column-pl-0">
                     <?php
                        $fileicon = fileIcon($doc->FileDetail->original_name);
                        $doc_url = $file_url."/".$doc->FileDetail->file_name;
                        $url = baseUrl('assessments/files/view-document/'.$doc->unique_id.'?url='.$doc_url.'&file_name='.$doc->FileDetail->file_name.'&folder_id='.$folder->unique_id."&assessment_id=".$assessment_id);
                     ?>
                     <a class="d-flex align-items-center" href="{{$url}}" target="_blank">
                        <?php
                           echo $fileicon;
                           $filesize = file_size($file_dir."/".$doc->FileDetail->file_name);
                        ?>
                        <div class="ml-3">
                           <span class="d-block h5 text-hover-primary mb-0">{{$doc->FileDetail->original_name}}</span>
                           <ul class="list-inline list-separator small file-specs">
                              <li class="list-inline-item">Added on {{dateFormat($doc->created_at)}}</li>
                              <li class="list-inline-item">{{$filesize}}</li>
                           </ul>
                        </div>
                     </a>
                  </td>
                  
                  <td>
                     <!-- Unfold -->
                     <div class="hs-unfold">
                        <a class="js-hs-action btn btn-sm btn-white" href="javascript:;"
                           data-hs-unfold-options='{
                           "target": "#action-{{$key}}",
                           "type": "css-animation"
                           }'>
                        <span class="d-none d-sm-inline-block mr-1">More</span>
                        <i class="tio-chevron-down"></i>
                        </a>
                        <div id="action-{{$key}}" class="hs-unfold-content dropdown-unfold dropdown-menu dropdown-menu-right" style="min-width: 13rem;">
                           <a class="dropdown-item" href="{{$doc_url}}" download>
                           <i class="tio-download-to dropdown-item-icon"></i>
                           Download
                           </a>
                           <a class="dropdown-item text-danger" href="javascript:;" onclick="confirmAction(this)" data-href="{{baseUrl('assessments/files/delete/'.base64_encode($doc->id))}}">
                           <i class="tio-delete-outlined dropdown-item-icon"></i>
                           Delete
                           </a>
                        </div>
                     </div>
                     <!-- End Unfold -->
                  </td>
               </tr>
               @endforeach
            </tbody>
         </table>

         @if(count($documents) <= 0)
         <div class="text-danger text-center p-2">
            No documents available
         </div>
         @endif
     </div>
</div>

<script>
    $(document).ready(function(){
      $('.js-hs-action').each(function () {
       var unfold = new HSUnfold($(this)).init();
      });
    
   });
    var is_error = false;
    $('.dropzone-custom').each(function () {
      Dropzone.autoDiscover = false;
      var dropzone = $.HSCore.components.HSDropzone.init('#' + $(this).attr('id'));
      dropzone.on("success", function(file,response) {
        if(response.status == false){
            is_error = true;
         }
      });
      dropzone.on("queuecomplete", function() {
         if(is_error == true){
            errorMessage("Error while upload file");
         }else{
            // location.reload();
            fetchDocuments('<?php echo $assessment->unique_id ?>','<?php echo $folder->unique_id ?>');
         }
      });
   });  
    function showGoogleFiles(){
      var parameter = {};
      parameter['assessment_id'] = "<?php echo $assessment->unique_id ?>";

      showPopup("<?php echo baseUrl('assessments/google-drive/folder/'.$folder->unique_id) ?>",'post',parameter);
   }
   function showDropboxFiles(){
      var parameter = {};
      parameter['assessment_id'] = "<?php echo $assessment->unique_id ?>";
      showPopup("<?php echo baseUrl('assessments/dropbox/folder/'.$folder->unique_id) ?>",'post',parameter);
   }
</script>