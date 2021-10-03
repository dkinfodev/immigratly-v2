@foreach($records as $key => $record)
<tr>

  <td>
    {{$record['invoice_id']}}
  </td>
  <td>
    {{currencyFormat($record['invoice']['amount'])}}
  </td>
  <td class="font-weight-bold">
    @if($record['invoice']['payment_status'] == 'paid')
      <span class="legend-indicator bg-success"></span> Paid <small class="text-danger">(on {{dateFormat($record['invoice']['paid_date'],'M d, Y H:i:s A')}})</small>
    @else
      <span class="legend-indicator bg-warning"></span> Pending
    @endif
  </td>
  <td>
    {{dateFormat($record['created_at'],"M d,Y h:i:s A")}}
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

        <a class="dropdown-item" href="{{baseUrl('cases/'.$subdomain.'/invoices/view/'.$record['unique_id'])}}">
         <i class="tio-dollar dropdown-item-icon"></i>
         View Invoice
        </a>
        <div class="dropdown-divider"></div>
        
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