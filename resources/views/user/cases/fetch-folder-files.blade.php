<div class="files-list">
    <div class="row">
        <div class="col-md-12">
            <div class="datatable-custom">
                <table id="datatable" class="table table-borderless table-thead-bordered card-table">
                    <thead class="thead-light">
                    <tr>
                        <th scope="col" class="table-column-pr-0">
                            <div class="custom-control custom-checkbox">
                                <input onchange="checkAll(this)" type="checkbox" class="custom-control-input">
                                <label class="custom-control-label" for="datatableCheckAll"></label>
                            </div>
                        </th>
                        <th scope="col" class="table-column-pl-0">Document Name</th>
                      
                        <!-- <th scope="col"></th> -->
                    </tr>
                    </thead>
                    <tbody>
                    @foreach($case_documents as $key => $doc)
                    <tr>
                        <td class="table-column-pr-0">
                            <div class="custom-control custom-checkbox">
                                <input type="checkbox" class="custom-control-input row-checkbox" id="row-{{$key}}" value="{{ $doc['unique_id'] }}">
                                <label class="custom-control-label" for="row-{{$key}}"></label>
                            </div>
                        </td>
                        <td class="table-column-pl-0">
                            <?php 
                                $doc_url = $file_url."/".$doc['file_detail']['file_name']; 
                                $url = baseUrl('cases/view-document/'.$case_id.'/'.$doc['unique_id'].'?url='.$doc_url.'&file_name='.$doc['file_detail']['file_name'].'&p='.$subdomain.'&doc_type='.$doc_type.'&folder_id='.$doc_id);
                            ?>
                            <a class="d-flex align-items-center" href="{{ $url }}">
                                <?php 
                                $fileicon = fileIcon($doc['file_detail']['original_name']);
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
                        <!-- <td><a class="badge badge-soft-primary p-2" href="#">Marketing team</a></td> -->
                        
                        
                    </tr>
                    @endforeach
                    </tbody>
                </table>

                @if(count($case_documents) <= 0)
                <div class="text-danger text-center p-2">
                    No documents available
                </div>
                @endif
            </div>
        </div>
    </div>
</div>

<link rel="stylesheet" href="assets/vendor/mCustomScrollbar/jquery.mCustomScrollbar.css" />
<script src="assets/vendor/mCustomScrollbar/jquery.mCustomScrollbar.min.js"></script>
<script src="assets/vendor/dropzone/dist/min/dropzone.min.js"></script>
<script type="text/javascript">

   $(document).ready(function(){

      $(".row-checkbox").change(function(){
         if($(".row-checkbox:checked").length > 0){
            $("#datatableCounterInfo").show();
         }else{
            $("#datatableCounterInfo").hide();
         }
         $("#datatableCounter").html($(".row-checkbox:checked").length);
      });
   });
   function checkAll(e){
      if($(e).is(":checked")){
         $(".row-checkbox").prop("checked",true);
      }else{
         $(".row-checkbox").prop("checked",false);
      }
   }
</script>