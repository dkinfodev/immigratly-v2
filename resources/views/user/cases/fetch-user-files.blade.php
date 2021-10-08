<style>
    .movebtn{
        display:none;
    }
</style>
<div class="files-list">
    <div class="row">
        <div class="col-md-12">
            <div class="datatable-custom">
                <div class="text-right mb-3">
                    <button type="button" class="btn btn-outline-primary btn-sm movebtn" onclick="showPopup('<?php echo baseUrl('cases/documents/move-to-professional/'.$case_id.'/'.$folder_id.'/'.$subdomain) ?>')"><i class="tio-file"></i> Move Files</button>
                </div>
                <table id="datatable" class="table table-borderless table-align-middle table-thead-bordered card-table">
                    <thead class="thead-light">
                        <tr>
                            <th scope="col" class="table-column-pr-0">
                                <div class="custom-control custom-checkbox">
                                    <input id="datatableCheckAll" onchange="checkAll(this)" type="checkbox" class="custom-control-input">
                                    <label class="custom-control-label" for="datatableCheckAll"></label>
                                </div>
                            </th>
                            <th scope="col" class="table-column-pl-0">Document Name</th>

                            <th scope="col"></th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($user_documents as $key => $doc)
                        @if(!empty($doc->FileDetail))
                        <tr>
                            <td class="table-column-pr-0">
                                <div class="custom-control custom-checkbox">
                                    <input type="checkbox" class="custom-control-input row-checkbox"
                                        data-fileid="{{$doc->unique_id}}" id="row-{{$key}}"
                                        value="{{ base64_encode($doc->id) }}">
                                    <label class="custom-control-label" for="row-{{$key}}"></label>
                                </div>
                            </td>
                            <td class="table-column-pl-0">
                                <?php
                                $fileicon = fileIcon($doc->FileDetail->original_name);
                                $doc_url = $file_url."/".$doc->FileDetail->file_name;
                                $url = baseUrl('documents/files/view-document/'.$doc->unique_id.'?url='.$doc_url.'&file_name='.$doc->FileDetail->file_name.'&folder_id='.$document->unique_id);
                                ?>
                                                        <a class="d-flex align-items-center" href="{{$url}}">
                                                            <?php 
                                    
                                    echo $fileicon;
                                    $filesize = file_size($file_dir."/".$doc->FileDetail->file_name);
                                ?>
                                    <div class="ml-3">
                                        <span
                                            class="d-block h5 text-hover-primary mb-0">{{$doc->FileDetail->original_name}}</span>
                                        <ul class="list-inline list-separator small file-specs">
                                            <li class="list-inline-item">Added on {{dateFormat($doc->created_at)}}</li>
                                            <li class="list-inline-item">{{$filesize}}</li>
                                        </ul>
                                    </div>
                                </a>
                            </td>

                            <td>
                               
                            </td>
                        </tr>
                        @endif
                        @endforeach

                        @if(count($user_documents) <= 0) 
                        <tr>
                            <td colspan="3">
                                <div class="text-danger text-center p-2">
                                    No documents available
                                </div>
                            </td>
                        </tr>
                        @endif
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>

<link rel="stylesheet" href="assets/vendor/mCustomScrollbar/jquery.mCustomScrollbar.css" />
<script src="assets/vendor/mCustomScrollbar/jquery.mCustomScrollbar.min.js"></script>
<script src="assets/vendor/dropzone/dist/min/dropzone.min.js"></script>
<script type="text/javascript">
var case_id;
var document_id;
var is_error = false;
$(document).ready(function() {
    $('.js-nav-tooltip-link').tooltip({
        boundary: 'window'
    })
    $('.js-hs-action').each(function() {
        var unfold = new HSUnfold($(this)).init();
    });
    $(".row-checkbox").change(function() {
        if ($(".row-checkbox:checked").length > 0) {
            $(".movebtn").show();
        } else {
            $(".movebtn").hide();
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
    if($(".row-checkbox:checked").length > 0){
        $(".movebtn").show();
    }else{
        $(".movebtn").hide();
    }
}
</script>