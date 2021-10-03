<div class="card-body p-0 mt-3">
    <div class="col-sm-auto mb-3 mt-3">
      
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
                        <input type="checkbox" class="custom-control-input row-checkbox" id="row-{{$key}}" value="{{ base64_encode($doc['id']) }}">
                        <label class="custom-control-label" for="row-{{$key}}"></label>
                     </div>
                  </td>
                  <td class="table-column-pl-0">
                     <?php
                        $fileicon = fileIcon($doc['file_detail']['original_name']);
                        $doc_url = $file_url."/".$doc['file_detail']['file_name'];
                        $url = baseUrl('assessments/files/view-document/'.$doc['unique_id'].'?url='.$doc_url.'&file_name='.$doc['file_detail']['file_name'].'&folder_id='.$folder['unique_id']);
                     ?>
                     <a class="d-flex align-items-center" href="{{$url}}" target="_blank">
                        <?php
                           echo $fileicon;
                           $filesize = file_size($file_dir."/".$doc['file_detail']['file_name']);
                        ?>
                        <div class="ml-3">
                           <span class="d-block h5 text-hover-primary mb-0">{{$doc['file_detail']['original_name']}}</span>
                           <ul class="list-inline list-separator small file-specs">
                              <li class="list-inline-item">Added on {{dateFormat($doc['created_at'])}}</li>
                              <li class="list-inline-item">{{$filesize}}</li>
                           </ul>
                        </div>
                     </a>
                  </td>
                  
                  <td>
                     <!-- Unfold -->
                     <a href="{{$doc_url}}" download>
                        <i class="tio-download-to dropdown-item-icon"></i>
                        Download
                        </a>
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
    
</script>