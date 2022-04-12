@extends('layouts.master')

@section('breadcrumb')
<!-- Content -->
<ol class="breadcrumb breadcrumb-no-gutter">
  <li class="breadcrumb-item"><a class="breadcrumb-link" href="{{ baseUrl('/') }}">Dashboard</a></li>
  <li class="breadcrumb-item active" aria-current="page">{{$pageTitle}}</li>
</ol>
<!-- End Content -->
@endsection

@section('content')

<!-- Card -->
<div class="card mb-3 mb-lg-5">
    <!-- Header -->
    <div class="card-header pt-3 pb-3">
        <ul class="nav nav-tabs page-header-tabs mb-0" id="projectsTab" role="tablist">
            <li class="nav-item">
                <a class="nav-link {{isset($active_nav) && $active_nav == 'cases'?'active':'' }}"
                    href="{{baseUrl('cases')}}">Approved</a>
            </li>
            <li class="nav-item">
                <a class="nav-link {{isset($active_nav) && $active_nav == 'pending-approval'?'active':'' }}"
                    href="{{baseUrl('cases/pending')}}">Pending Approval  <span class="text-danger">({{ $pendingApproval }})</span>
                </a>
            </li>
        </ul>
    </div>
    <!-- End Header -->

    <!-- Body -->
    <div class="card-body">
        <!-- Table -->
        <div class="datatable-custom">
            <table id="datatable"
                class="table table-borderless table-theard-bordered table-nowrap table-align-middle"
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
                        <th scope="col">Professional</th>
                        <th scope="col">Visa Service</th>
                        <th scope="col">Approval Status</th>
                        <th scope="col">Assigned</th>
                        <th scope="col"><i class="tio-chat-outlined"></i></td>
                        <th></th>
                    </tr>
                </thead>

                <tbody>
            <?php
            foreach($professionals as $professional){

              $cases = $professional->Cases($professional->professional,$professional->user_id);

              if(isset($cases['status']) && $cases['status'] == "success"){
                //pre($cases);
              foreach($cases['data'] as $key => $record){
               
            ?>
                    @if($record['approve_status'] == "1")
                    @if(!empty($record['MainService']))
                    <tr>
                        <!--<td class="table-column-pr-0">-->
                        <!--  <div class="custom-control custom-checkbox">-->
                        <!--    <input type="checkbox" class="custom-control-input row-checkbox" value="{{ base64_encode($record['id']) }}" id="row-{{$key}}">-->
                        <!--    <label class="custom-control-label" for="row-{{$key}}"></label>-->
                        <!--  </div>-->
                        <!--</td>-->
                        <td>
                            <a class="d-flex align-items-center"
                                href="{{baseUrl('cases/documents/'.$professional->professional.'/'.$record['unique_id'])}}">
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
                                    <span class="d-block font-size-sm text-body">Created on
                                        {{ dateFormat($record['created_at']) }}</span>
                                    <ul class="list-inline list-separator small file-specs">
                                        <li class="list-inline-item">
                                            <i class="tio-attachment-diagonal"></i> {{count($record['documents'])}}
                                        </li>
                                        <li class="list-inline-item"> <i class="tio-comment-text-outlined"></i>
                                            {{count($record['chats'])}}</li>
                                    </ul>
                                </div>
                            </a>
                        </td>
                        <td>
                            @if(!empty($professional_info['personal']))
                            <?php
                                $profess = $professional_info['personal'];
                            ?>
                            <a href="{{ baseUrl('professional/'.$professional->professional) }}"
                                class="text-primary h4">{{$profess->first_name." ".$profess->last_name}}</a>
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
                            @if($record['approve_status'] == "0")
                            <span class="badge badge-soft-warning p-2">Awaiting Approve</span>
                            @endif
                            @if($record['approve_status'] == "1")
                            <span class="badge badge-soft-info p-2">Approved</span>
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
                                <a class="avatar js-nav-tooltip-link" href="javascript:;" data-toggle="tooltip"
                                    data-placement="top"
                                    title="{{ $member['member']['first_name']." ".$member['member']['last_name'] }}">
                                    <img class="avatar-img"
                                        src="{{ professionalProfile($member['member']['unique_id'],'t',$professional->professional) }}"
                                        alt="Image Description">
                                </a>

                                <?php } ?>
                                @endforeach
                                @if($more_file > 0)
                                <span class="avatar avatar-light js-nav-tooltip-link avatar-circle"
                                    data-toggle="tooltip" data-placement="top" title="" data-original-title="">
                                    <span class="avatar-initials">{{ $more_file }}+</span>
                                </span>
                                @endif
                            </div>
                            <!-- End Avatar Group -->
                        </td>
                        <td width="10%">
                            <div class="hs-unfold">
                                <a href="{{ baseUrl('cases/chats/'.$professional->professional.'/'.$record['unique_id']) }}"
                                    class="js-hs-unfold-invoker text-body">
                                    <i class="tio-chat-outlined"></i>
                                    <?php echo $record['unread_chat']['unread_chat']; ?>
                                </a>
                            </div>
                        </td>
                        <td>
                            @php 
                                $index = mt_rand(111,999);
                            @endphp
                            <div class="hs-unfold">
                                <a class="js-hs-action btn btn-sm btn-white" href="javascript:;" data-hs-unfold-options='{
                                    "target": "#action-{{$index}}",
                                    "type": "css-animation"
                                    }'>
                                    More <i class="tio-chevron-down ml-1"></i>
                                </a>
                                <div id="action-{{$index}}"
                                    class="hs-unfold-content dropdown-unfold dropdown-menu dropdown-menu-right">
                                    <a class="dropdown-item"
                                        href="{{baseUrl('cases/view/'.$professional->professional.'/'.$record['unique_id'])}}">
                                        <i class="tio-adjust dropdown-item-icon"></i>
                                        View Case
                                    </a>
                                    <a class="dropdown-item"
                                        href="{{baseUrl('cases/documents/'.$professional->professional.'/'.$record['unique_id'])}}">
                                        <i class="tio-pages-outlined dropdown-item-icon"></i>
                                        Case Documents
                                    </a>
                                    <a class="dropdown-item"
                                        href="{{baseUrl('cases/'.$professional->professional.'/invoices/list/'.$record['unique_id'])}}">
                                        <i class="tio-dollar dropdown-item-icon"></i>
                                        Invoices
                                    </a>
                                    <a class="dropdown-item"
                                        href="{{baseUrl('cases/'.$professional->professional.'/dependants/list/'.$record['unique_id'])}}">
                                        <i class="tio-dollar dropdown-item-icon"></i>
                                        Users
                                    </a>
                                </div>
                            </div>
                        </td>
                    </tr>
                    @endif

                    @endif
                    <?php } 
              }
            }
            ?>
                </tbody>
            </table>

        </div>
        <!-- End Table -->
    </div>
    <!-- End Body -->
</div>
<!-- End Card -->

<!-- End Row -->

@endsection

@section('javascript')
<!-- JS Implementing Plugins -->
<script src="assets/vendor/hs-navbar-vertical-aside/hs-navbar-vertical-aside.min.js"></script>
<script src="assets/vendor/hs-nav-scroller/dist/hs-nav-scroller.min.js"></script>
<script src="assets/vendor/hs-go-to/dist/hs-go-to.min.js"></script>
<script src="assets/vendor/list.js/dist/list.min.js"></script>
<script src="assets/vendor/prism/prism.js"></script>
<script src="assets/vendor/hs-step-form/dist/hs-step-form.min.js"></script>
<script src="assets/vendor/jquery-validation/dist/jquery.validate.min.js"></script>
<script src="assets/vendor/datatables/media/js/jquery.dataTables.min.js"></script>
<!-- JS Front -->
<script type="text/javascript">
// initEditor("description"); 
$('.js-nav-tooltip-link').tooltip({
    boundary: 'window'
});
$(document).on('ready', function() {

    $('.js-hs-action').each(function() {
        var unfold = new HSUnfold($(this)).init();
    });
    // initialization of datatables
    // var datatable = $.HSCore.components.HSDatatables.init($('#datatable'));
});
</script>

@endsection