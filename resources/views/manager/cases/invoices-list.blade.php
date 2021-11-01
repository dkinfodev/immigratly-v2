@foreach($records as $key => $record)
<tr>
  <td class="table-column-pr-0">
    <div class="custom-control custom-checkbox">
      <input type="checkbox" class="custom-control-input row-checkbox" value="{{ base64_encode($record->Invoice->id) }}" id="row-{{$key}}">
      <label class="custom-control-label" for="row-{{$key}}"></label>
    </div>
  </td>
  <td>
    {{$record->invoice_id}}
  </td>
  <td>
    {{currencyFormat($record->Invoice->amount)}}
  </td>
  <td class="font-weight-bold">
    @if($record->Invoice->payment_status == 'paid')
      <span class="legend-indicator bg-success"></span> Paid <small class="text-danger">(on {{dateFormat($record->Invoice->paid_date,'M d, Y H:i:s A')}})</small>
    @else
      <span class="legend-indicator bg-warning"></span> Pending
    @endif
  </td>
  <td>
    {{dateFormat($record->created_at,"M d,Y h:i:s A")}}
  </td>
  <td>
      <div class="hs-unfold">
      <a class="js-hs-action btn btn-sm btn-white" href="javascript:;"
         data-hs-unfold-options='{
           "target": "#action-{{$key}}",
           "type": "css-animation"
         }'>More  <i class="tio-chevron-down ml-1"></i>
      </a>
      <div id="action-{{$key}}" class="hs-unfold-content dropdown-unfold dropdown-menu dropdown-menu-right">
        <a class="dropdown-item" href="{{baseUrl('cases/invoices/edit/'.base64_encode($record->id))}}">
         <i class="tio-edit dropdown-item-icon"></i>
         Edit
        </a>
        <a class="dropdown-item" href="{{baseUrl('cases/invoices/view/'.base64_encode($record->id))}}">
         <i class="tio-dollar dropdown-item-icon"></i>
         View Invoice
        </a>
        <div class="dropdown-divider"></div>
        <a class="dropdown-item text-danger" href="javascript:;" onclick="confirmAction(this)" data-href="{{baseUrl('cases/invoices/delete/'.base64_encode($record->id))}}">
         <i class="tio-delete-outlined dropdown-item-icon"></i>
         Delete
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