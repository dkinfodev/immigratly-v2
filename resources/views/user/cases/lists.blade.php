@extends('layouts.master')
@section('pageheader')
<!-- Content -->
<div class="">
    <div class="content container" style="height: 25rem;">
        <!-- Page Header -->
        <div class="page-header page-header-light page-header-reset">
            <div class="row align-items-center">
                <div class="col">
                    <h1 class="page-header-title">{{$pageTitle}}</h1>
                </div>
            </div>
            <!-- End Row -->
        </div>
        <!-- End Page Header -->
    </div>
</div>
<!-- End Content -->
@endsection
@section('content')

  <!-- Card -->
  <div class="row gx-2 gx-lg-3">
    <div class="col-md-12">
      <!-- Table -->
      <div class="datatable-custom">
        <table id="datatable" class="table table-borderless table-thead-bordered table-nowrap table-align-middle card-table"
              data-hs-datatables-options='{
                "order": [],
                "isResponsive": false,
                "isShowPaging": false,
                "pagination": "datatablePagination"
              }'>
          <thead class="thead-light">
            <tr>
              <!--<th scope="col" class="table-column-pr-0">-->
              <!--  <div class="custom-control custom-checkbox">-->
              <!--    <input id="datatableCheckAll" type="checkbox" class="custom-control-input">-->
              <!--    <label class="custom-control-label" for="datatableCheckAll"></label>-->
              <!--  </div>-->
              <!--</th>-->
              <th scope="col" class="">Case Title</th>
              <th>Professional</th>
              <th scope="col" >Visa Service</th>
              <th scope="col" >Assigned</th>
              <th scope="col"><i class="tio-chat-outlined"></i></td>
              <th></th>
            </tr>
          </thead>

          <tbody>
            <?php
            foreach($professionals as $professional){
              $cases = $professional->Cases($professional->professional,$professional->user_id);
              
              if(isset($cases['status']) && $cases['status'] == "success"){
              foreach($cases['data'] as $key => $record){
            ?>
            @if(!empty($record['MainService']))
            <tr>
              <!--<td class="table-column-pr-0">-->
              <!--  <div class="custom-control custom-checkbox">-->
              <!--    <input type="checkbox" class="custom-control-input row-checkbox" value="{{ base64_encode($record['id']) }}" id="row-{{$key}}">-->
              <!--    <label class="custom-control-label" for="row-{{$key}}"></label>-->
              <!--  </div>-->
              <!--</td>-->
              <td >
                <a class="d-flex align-items-center" href="{{baseUrl('cases/documents/'.$professional->professional.'/'.$record['unique_id'])}}">
                  <?php
                    $professional_info = $professional->Professional($professional->professional);
                  ?>
                  @if(!empty($professional_info['personal']))
                  
                  <div class="avatar avatar-soft-primary mt-4 avatar-circle">
                    <span class="avatar-initials">{{userInitial($professional_info['personal'])}}</span>
                  </div>
                  @else
                  <div class="avatar avatar-soft-primary mt-4 avatar-circle">
                    <span class="avatar-initials">UN</span>
                  </div>
                  @endif
                  <!-- <img class="avatar" src="assets/svg/brands/capsule.svg" alt="Image Description"> -->
                  <div class="ml-3">
                    <span class="d-block h5 text-hover-primary mb-0">{{ $record['case_title'] }}</span>
                    <span class="d-block font-size-sm text-body">Created on {{ dateFormat($record['created_at']) }}</span>
                    <ul class="list-inline list-separator small file-specs">
                        <li class="list-inline-item"> 
                          <i class="tio-attachment-diagonal"></i> {{count($record['documents'])}}
                        </li>
                        <li class="list-inline-item"> <i class="tio-comment-text-outlined"></i>  {{count($record['chats'])}}</li>
                    </ul>
                  </div>
                </a>
              </td>
              <td>
                @if(!empty($professional_info['personal']))
                <?php
                $profess = $professional_info['personal'];
                ?>
                <a href="{{ baseUrl('professional/'.$professional->professional) }}" class="text-primary h4">{{$profess->first_name." ".$profess->last_name}}</a>
                @else
                <span class="text-danger h4">Professional not found</span>
                @endif
              </td>
              <td>
                @if(!empty($record['MainService']))
                <span class="badge badge-soft-info p-2">{{$record['MainService']['name']}}</span>
                @else
                <span class="badge badge-soft-info p-2">Service not found</span>
                @endif
              </td>

              
              <td>
                <!-- Avatar Group -->
                <div class="avatar-group avatar-group-xs avatar-circle">
                  <?php 
                    $more_file = 0;
                  ?>
                  @foreach($record['assinged_member'] as $key => $member)
                    <?php 
                    if($key > 1){
                      $more_file++;
                    }else{
                    ?>  
                    <a class="avatar js-nav-tooltip-link" href="javascript:;" data-toggle="tooltip" data-placement="top" title="{{ $member['member']['first_name']." ".$member['member']['last_name'] }}">
                      <img class="avatar-img" src="{{ professionalProfile($member['member']['unique_id'],'t',$professional->professional) }}" alt="Image Description">
                    </a>

                    <?php } ?>
                  @endforeach
                  @if($more_file > 0)
                    <span class="avatar avatar-light js-nav-tooltip-link avatar-circle" data-toggle="tooltip" data-placement="top" title="" data-original-title="">
                      <span class="avatar-initials">{{ $more_file }}+</span>
                    </span>
                  @endif
                </div>
                <!-- End Avatar Group -->
              </td>
              <td width="10%">
                <div class="hs-unfold">
                    <a href="{{ baseUrl('cases/chats/'.$professional->professional.'/'.$record['unique_id']) }}" class="js-hs-unfold-invoker text-body">
                    <i class="tio-chat-outlined"></i> 
                    <?php echo $record['unread_chat']['unread_chat']; ?>
                    </a>
                </div>
              </td>
              <td>
                <div class="hs-unfold">
                  <a class="js-hs-action btn btn-sm btn-white" href="javascript:;"
                    data-hs-unfold-options='{
                      "target": "#action-{{$key}}",
                      "type": "css-animation"
                    }'>
                          More <i class="tio-chevron-down ml-1"></i>
                  </a>
                  <div id="action-{{$key}}" class="hs-unfold-content dropdown-unfold dropdown-menu dropdown-menu-right">
                    <a class="dropdown-item" href="{{baseUrl('cases/view/'.$professional->professional.'/'.$record['unique_id'])}}">
                    <i class="tio-adjust dropdown-item-icon"></i>
                    View Case
                    </a>
                    <a class="dropdown-item" href="{{baseUrl('cases/documents/'.$professional->professional.'/'.$record['unique_id'])}}">
                    <i class="tio-pages-outlined dropdown-item-icon"></i>
                    Case Documents
                    </a>
                    <a class="dropdown-item" href="{{baseUrl('cases/'.$professional->professional.'/invoices/list/'.$record['unique_id'])}}">
                    <i class="tio-dollar dropdown-item-icon"></i>
                    Invoices
                    </a>
                  </div>
                </div>
              </td>
            </tr>
            @endif
            <?php } 
              }
            }
            ?>
          </tbody>
        </table>
      </div>
      <!-- End Table -->

      <!-- Footer -->
      <div class="card-footer">
        <!-- Pagination -->
        <div class="d-flex justify-content-center justify-content-sm-end">
          <nav id="datatablePagination" aria-label="Activity pagination"></nav>
        </div>
        <!-- End Pagination -->
      </div>
      <!-- End Footer -->
    </div>
  </div>
<!-- End Card -->
</div>
<!-- End Content -->
@endsection

@section('javascript')
<script src="assets/vendor/datatables/media/js/jquery.dataTables.min.js"></script>
<script>
  $('.js-nav-tooltip-link').tooltip({ boundary: 'window' });
  $(document).on('ready', function () {
    
    $('.js-hs-action').each(function () {
      var unfold = new HSUnfold($(this)).init();
    });
    // initialization of datatables
    // var datatable = $.HSCore.components.HSDatatables.init($('#datatable'));
  });
</script>
@endsection