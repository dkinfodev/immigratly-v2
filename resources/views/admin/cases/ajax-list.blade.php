@foreach($records as $key => $record)
<tr>
  <td scope="col" class="table-column-pr-0 table-column-pl-0 pr-0 ">
    <div class="custom-control custom-checkbox">
      <input type="checkbox" class="custom-control-input row-checkbox" value="{{ base64_encode($record->id) }}" id="row-{{$key}}">
      <label class="custom-control-label" for="row-{{$key}}"></label>
    </div>
  </td>
  <td scope="col" class="table-column-pl-0">
    <a class="d-flex align-items-center" href="{{baseUrl('cases/view/'.base64_encode($record->id))}}">
      @if(!empty($record->Client($record->client_id)))
      <?php
      $client = $record->Client($record->client_id);
      ?>
      <div class="avatar avatar-soft-primary avatar-circle">
        <span class="avatar-initials">{{userInitial($client)}}</span>
      </div>
      @else
      <div class="avatar avatar-soft-primary avatar-circle">
        <span class="avatar-initials">UN</span>
      </div>
      @endif
      <!-- <img class="avatar" src="assets/svg/brands/capsule.svg" alt="Image Description"> -->
      <div class="ml-1">
        <span class="h5 text-hover-primary mb-0">{{ $record->case_title }}</span>
       
        <span class="d-block font-size-sm text-body">Created on {{ dateFormat($record->created_at) }}</span>
        <ul class="list-inline list-separator small file-specs">
            <li class="list-inline-item"> 
              <i class="tio-attachment-diagonal"></i> {{count($record->Documents)}}
            </li>
            <li class="list-inline-item"> <i class="tio-comment-text-outlined"></i>  {{count($record->Chats)}}</li>
            @if($record->added_by == 'client')
            <li class="list-inline-item"> <span class="badge badge-warning">Posted By Client</span></li>
            @endif
        </ul>

        @if(!empty(!empty($record->VisaService) && $record->Service($record->VisaService->service_id)))
        <span class="badge badge-soft-info p-2">{{$record->Service($record->VisaService->service_id)->name}}</span>
        @else
        <span class="badge badge-soft-danger p-2">Service not found</span>
        @endif

      </div>
    </a>
  </td>
  <td scope="col" class="table-column-pl-0">
    @if(!empty($record->Client($record->client_id)))
    <?php
    $client = $record->Client($record->client_id);
    ?>
    <span class="text-primary h4">{{$client->first_name." ".$client->last_name}}</span>
    @else
    <span class="text-danger h4">Client not found</span>
    @endif
    <br>
    @if($record->approve_status == "0")
    <span class="badge badge-soft-warning">Awaiting Approve</span>
    @if($record->added_by == 'client')
    <label class="toggle-switch mx-2" for="$record['unique_id']">
      <input type="checkbox" data-id="{{ $record['unique_id'] }}" onchange="caseApprovalStatus('<?php echo $record->unique_id; ?>','<?php echo $record->client_id; ?>')" class="js-toggle-switch toggle-switch-input" id="$record['unique_id']" >
      <span class="toggle-switch-label">
        <span class="toggle-switch-indicator"></span>
      </span>
    </label>  
    <br>
    @endif
    @endif
    @if($record->approve_status == "1")
    <span class="badge badge-soft-info">Approved</span>
    @endif
    
  </td>
  <!-- <td>
    @if(!empty(!empty($record->VisaService) && $record->Service($record->VisaService->service_id)))
    <span class="badge badge-soft-info p-2">{{$record->Service($record->VisaService->service_id)->name}}</span>
    @else
    <span class="badge badge-soft-danger p-2">Service not found</span>
    @endif
  </td> -->
  <!-- <td>
    @if($record->approve_status == "0")
    <span class="badge badge-soft-warning p-2">Awaiting Approve</span>
    @endif
    @if($record->approve_status == "1")
    <span class="badge badge-soft-info p-2">Approved</span>
    @endif
  </td> -->
   <td scope="col" class="table-column-pl-0 table-column-pr-0">
     {{$record->case_type}}
   {{--<div class="avatar-group avatar-group-xs avatar-circle">
      <?php 
        $more_file = 0;
      ?>
      @foreach($record->AssingedMember as $key2 => $member)
        <?php 
        if($key2 > 1){
          $more_file++;
        }else{
        ?>  
        <a class="avatar js-nav-tooltip-link" href="javascript:;" data-toggle="tooltip" data-placement="top" title="{{ $member->Member->first_name." ".$member->Member->last_name }}">
          <img class="avatar-img" src="{{ professionalProfile($member->Member->unique_id,'t') }}" alt="Image Description">
        </a>
        <?php } ?>
      @endforeach
      @if($more_file > 0)
        <span class="avatar avatar-light js-nav-tooltip-link avatar-circle" data-toggle="tooltip" data-placement="top" title="" data-original-title="{{ $member->first_name." ".$member->last_name }}">
          <span class="avatar-initials">{{ $more_file }}+</span>
        </span>
      @endif
    </div> --}}
  </td>
  <!-- <td width="10%">
   <div class="hs-unfold">
      <a href="{{ baseUrl('cases/chats/'.$record->unique_id) }}" class="js-hs-unfold-invoker text-body">
      <?php
      $chat_read = $record->UnreadChat($record->unique_id,\Auth::user()->role,\Auth::user()->unique_id,'count');
       
      ?>
      @if($chat_read['total_chat'] == 0 || $chat_read['unread_chat'] == $chat_read['total_chat'])
          <i class="tio-chat-outlined"></i> {{$chat_read['unread_chat']}}
      @else
          <span class="text-danger"><i class="tio-chat-outlined"></i>  {{$chat_read['unread_chat']}}</span>
      @endif
      </a>
   </div>
 </td> -->
  <td scope="col" class="table-column-pl-0 table-column-pr-0">
    <div class="hs-unfold">
        <a class="js-hs-action btn btn-sm btn-white" href="javascript:;"
          data-hs-unfold-options='{
            "target": "#action-{{$key}}",
            "type": "css-animation"
          }'>More  <i class="tio-chevron-down ml-1"></i>
        </a>
        <div id="action-{{$key}}" class="hs-unfold-content dropdown-unfold dropdown-menu dropdown-menu-right">

          @if($record->case_type == 'group')
          <a class="dropdown-item" href="{{baseUrl('cases/edit-group-case/'.base64_encode($record->id))}}">
          @else
          <a class="dropdown-item" href="{{baseUrl('cases/edit/'.base64_encode($record->id))}}">
          @endif
          <i class="tio-edit dropdown-item-icon"></i>
          Edit
          </a>
          <a class="dropdown-item" href="{{baseUrl('cases/view/'.base64_encode($record->id))}}">
          <i class="tio-globe dropdown-item-icon"></i>
          View
          </a>
          <a class="dropdown-item" href="{{baseUrl('cases/case-documents/documents/'.base64_encode($record->id))}}">
          <i class="tio-pages-outlined dropdown-item-icon"></i>
          Case Documents
          </a>
          <a class="dropdown-item" href="{{baseUrl('cases/invoices/list/'.base64_encode($record->id))}}">
          <i class="tio-dollar dropdown-item-icon"></i>
          Invoices
          </a>
          <a class="dropdown-item" href="{{baseUrl('cases/tasks/list/'.base64_encode($record->id))}}">
          <i class="tio-pages dropdown-item-icon"></i>
          Case Tasks
          </a>
          <a class="dropdown-item" href="{{baseUrl('cases/stages/list/'.base64_encode($record->id))}}">
          <i class="tio-pages dropdown-item-icon"></i>
          Case Stages
          </a>
          <div class="dropdown-divider"></div>
          <a class="dropdown-item text-danger" href="javascript:;" onclick="confirmAction(this)" data-href="{{baseUrl('cases/delete/'.base64_encode($record->id))}}">
          <i class="tio-delete-outlined dropdown-item-icon"></i>
          Delete
          </a>

          <a href="{{ baseUrl('cases/chats/'.$record->unique_id) }}" class="dropdown-item">
          <?php
          $chat_read = $record->UnreadChat($record->unique_id,\Auth::user()->role,\Auth::user()->unique_id,'count');
           
          ?>
          @if($chat_read['total_chat'] == 0 || $chat_read['unread_chat'] == $chat_read['total_chat'])
              <i class="tio-chat-outlined dropdown-item-icon"></i> {{$chat_read['unread_chat']}}
          @else
              <span class="text-danger"><i class="tio-chat-outlined dropdown-item-icon"></i>  {{$chat_read['unread_chat']}}</span> 

          @endif
          Chats
          </a>

        </div>
    </div>
   </td>
</tr>
@endforeach
<script type="text/javascript">
$(document).ready(function(){
  $('.js-nav-tooltip-link').tooltip({ boundary: 'window' })
  $('.js-hs-action').each(function () {
    var unfold = new HSUnfold($(this)).init();
  });
})

</script>