@foreach($user_documents as $key => $doc)
@if(!empty($doc->FileDetail))
<tr>
    <td class="table-column-pr-0">
        <div class="custom-control custom-checkbox">
        <input type="checkbox" class="custom-control-input row-checkbox" data-fileid="{{$doc->unique_id}}" id="row-{{$key}}" value="{{ base64_encode($doc->id) }}">
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
        <a class="js-hs-action js-hs-unfold-invoker btn btn-sm btn-white" href="javascript:;"
            data-hs-unfold-options='{
            "target": "#action-{{$key}}",
            "type": "css-animation"
            }'>
        <span class="d-none d-sm-inline-block mr-1">More</span>
        <i class="tio-chevron-down"></i>
        </a>
        <div id="action-{{$key}}" class="hs-unfold-content dropdown-unfold dropdown-menu dropdown-menu-right" style="min-width: 13rem;">
            
            <!-- <a class="dropdown-item" href="#">
            <i class="tio-share dropdown-item-icon"></i>
            Share file
            </a> -->
            <a class="dropdown-item" href="javascript:;" onclick="showPopup('<?php echo baseUrl('documents/files/file-move-to/'.$doc->unique_id) ?>')">
            <i class="tio-folder-add dropdown-item-icon"></i>
            Move to
            </a>
            <a class="dropdown-item" href="{{$doc_url}}" download>
            <i class="tio-download-to dropdown-item-icon"></i>
            Download
            </a>
            <div class="dropdown-divider"></div>
            <!-- <a class="dropdown-item" href="#">
            <i class="tio-chat-outlined dropdown-item-icon"></i>
            Report
            </a> -->
            <a class="dropdown-item text-danger" href="javascript:;" onclick="confirmAction(this)" data-href="{{baseUrl('documents/files/delete/'.base64_encode($doc->id))}}">
            <i class="tio-delete-outlined dropdown-item-icon"></i>
            Delete
            </a>
        </div>
        </div>
        <!-- End Unfold -->
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


