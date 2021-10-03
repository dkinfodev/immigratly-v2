@foreach($records as $key => $record)
<tr>
  <td class="table-column-pr-0">
    <div class="custom-control custom-checkbox">
      <input type="checkbox" class="custom-control-input row-checkbox" value="{{ base64_encode($record->id) }}" id="row-{{$key}}">
      <label class="custom-control-label" for="row-{{$key}}"></label>
    </div>
  </td>
   <td class="table-column-pl-0">
      <a class="d-flex align-items-center" href="javascript:;">
        <div class="avatar avatar-soft-primary mt-4 avatar-circle">
          <span class="avatar-initials">{{userInitial($record)}}</span>
        </div>
         <!-- <img class="avatar" src="./assets/svg/brands/guideline.svg" alt="Image Description"> -->
         <div class="ml-3">
            <span class="d-block h5 text-hover-primary mb-0">{{$record->first_name." ".$record->last_name}}</span>
            <span class="d-block font-size-sm text-body">Created on {{ dateFormat($record->created_at) }}</span>
            <ul class="list-inline list-separator small file-specs">
               <li class="list-inline-item"> 
                  <i class="tio-attachment-diagonal"></i> 10
               </li>
               <li class="list-inline-item"> <i class="tio-comment-text-outlined"></i> 2</li>
            </ul>
         </div>
      </a>
   </td>
   <td>
      <div class="d-flex">
         <div class="mr-1"><img src="./assets/svg/components/star.svg" alt="Review rating" width="14"></div>
         <div class="mr-1"><img src="./assets/svg/components/star.svg" alt="Review rating" width="14"></div>
         <div class="mr-1"><img src="./assets/svg/components/star.svg" alt="Review rating" width="14"></div>
         <div class="mr-1"><img src="./assets/svg/components/star.svg" alt="Review rating" width="14"></div>
         <div class="mr-1"><img src="./assets/svg/components/star-half.svg" alt="Review rating" width="14"></div>
      </div>
   </td>
   <td>
    @if(!empty($record->Service($record->VisaService->service_id)))
    <a class="badge badge-soft-primary p-2" href="javascript:;">{{$record->Service($record->VisaService->service_id)->name}}</a>
    @else
    <a href="javascript:;" class="badge badge-soft-danger p-2">Service Removed</a>
    @endif
   </td>
   <td>
      <div class="avatar-group avatar-group-xs avatar-circle">
         <span class="avatar" data-toggle="tooltip" data-placement="top" title="Ella Lauda">
         <img class="avatar-img" src="./assets/img/160x160/img9.jpg" alt="Image Description">
         </span>
         <span class="avatar" data-toggle="tooltip" data-placement="top" title="David Harrison">
         <img class="avatar-img" src="./assets/img/160x160/img3.jpg" alt="Image Description">
         </span>
         <span class="avatar avatar-soft-dark" data-toggle="tooltip" data-placement="top" title="Antony Taylor">
         <span class="avatar-initials">A</span>
         </span>
         <span class="avatar avatar-soft-info" data-toggle="tooltip" data-placement="top" title="Sara Iwens">
         <span class="avatar-initials">S</span>
         </span>
         <span class="avatar" data-toggle="tooltip" data-placement="top" title="Finch Hoot">
         <img class="avatar-img" src="./assets/img/160x160/img5.jpg" alt="Image Description">
         </span>
         <span class="avatar avatar-light avatar-circle" data-toggle="tooltip" data-placement="top" title="Sam Kart, Amanda Harvey and 1 more">
         <span class="avatar-initials">+3</span>
         </span>
      </div>
   </td>
   @if(role_permission('leads','mark-as-client'))
   <td>
      <button onclick="showPopup('<?php echo baseUrl('leads/mark-as-client/'.base64_encode($record->id)) ?>')" type="button" class="btn btn-primary btn-xs"><i class="tio-user-switch"></i> Make Client</button>
   </td>
   @endif
   <td>
      <div class="hs-unfold">
      <a class="js-hs-action btn btn-sm btn-white" href="javascript:;"
         data-hs-unfold-options='{
           "target": "#action-{{$key}}",
           "type": "css-animation"
         }'>
              More <i class="tio-chevron-down ml-1"></i>
      </a>

      <div id="action-{{$key}}" class="hs-unfold-content dropdown-unfold dropdown-menu dropdown-menu-sm dropdown-menu-right">
        @if(role_permission('leads','edit-lead'))
        <a class="dropdown-item" href="{{baseUrl('leads/edit/'.base64_encode($record->id))}}">
          <i class="tio-edit dropdown-item-icon"></i>
          Edit
        </a>
        @endif
        @if(role_permission('leads','recommend-as-client'))
        <a class="dropdown-item" href="javascript:;" onclick="showPopup('<?php echo baseUrl('leads/recommend-as-client/'.base64_encode($record->id)) ?>')">
          <i class="tio-bookmark dropdown-item-icon"></i>
          Recommend as Client
        </a>
        @endif
        @if(role_permission('leads','delete-lead'))
        <div class="dropdown-divider"></div>
        <a class="dropdown-item text-danger" href="javascript:;" onclick="confirmAction(this)" data-href="{{baseUrl('leads/delete/'.base64_encode($record->id))}}">
          <i class="tio-delete-outlined dropdown-item-icon"></i>
          Delete
        </a> 
        @endif
      </div>
    </div>
   </td>
</tr>
@endforeach
<script type="text/javascript">
$(document).ready(function(){
  $('.js-hs-action').each(function () {
    var unfold = new HSUnfold($(this)).init();
  });
  // $(".row-checkbox").change(function(){
  //   if($(".row-checkbox:checked").length > 0){
  //     $("#datatableCounterInfo").show();
  //   }else{
  //     $("#datatableCounterInfo").show();
  //   }
  //   $("#datatableCounter").html($(".row-checkbox:checked").length);
  // });
})
</script>