@extends('layouts.master')
@section("style")
<style>
   .all_services li {
   padding: 16px;
   border-bottom: 1px solid #ddd;
   }
   .sub_services li {
   border-bottom: none;
   }
</style>
@endsection
@section('content')
<!-- Content -->
<!-- Content -->
<div class="content container-fluid">
   <!-- Page Header -->
   <div class="page-header">
      <div class="row align-items-end mb-3">
         <div class="col-sm mb-2 mb-sm-0">
            <nav aria-label="breadcrumb">
               <ol class="breadcrumb breadcrumb-no-gutter">
                  <li class="breadcrumb-item"><a class="breadcrumb-link" href="{{ baseUrl('/') }}">Dashboard</a></li>
                  <li class="breadcrumb-item"><a class="breadcrumb-link" href="{{ baseUrl('/cases') }}">Cases</a></li>
                  <li class="breadcrumb-item active" aria-current="page">{{$pageTitle}}</li>
               </ol>
            </nav>
            <h1 class="page-header-title">{{$pageTitle}}</h1>
            <div clas="d-block">
               @if(!empty($service->Service($service->service_id)))
                <h4 class="text-primary p-2">{{$service->Service($service->service_id)->name}}</h4>
               @else
                <h4 class="text-primary p-2">Service not found</h4>
               @endif
            </div>
         </div>
         <div class="col-sm-auto">
            <div class="btn-group" role="group">
               <a class="btn btn-primary" href="{{ baseUrl('cases/case-documents/upload-documents/'.base64_encode($record->id)) }}"><i class="tio-upload-on-cloud mr-1"></i> Upload</a>
            </div>
         </div>
      </div>
      <!-- End Row -->
      <!-- Nav -->
      <!-- Nav -->
      <div class="js-nav-scroller hs-nav-scroller-horizontal">
         <span class="hs-nav-scroller-arrow-prev" style="display: none;">
         <a class="hs-nav-scroller-arrow-link" href="javascript:;">
         <i class="tio-chevron-left"></i>
         </a>
         </span>
         <span class="hs-nav-scroller-arrow-next" style="display: none;">
         <a class="hs-nav-scroller-arrow-link" href="javascript:;">
         <i class="tio-chevron-right"></i>
         </a>
         </span>
      </div>
      <!-- End Nav -->
   </div>
   <!-- End Page Header -->
   <!-- Card -->
   <div class="card">
      <!-- Header -->
      <div class="card-header">
         <div class="row justify-content-between align-items-center flex-grow-1">
            <div class="col-12 col-md">
               <form>
                  <!-- Search -->
                  <div class="input-group input-group-merge input-group-borderless">
                     <div class="input-group-prepend">
                        <div class="input-group-text">
                           <i class="tio-search"></i>
                        </div>
                     </div>
                     <input id="datatableSearch" type="search" class="form-control" placeholder="Search users" aria-label="Search users">
                  </div>
                  <!-- End Search -->
               </form>
            </div>
            <div class="col-auto">
               <div class="d-flex align-items-center">
                  <!-- Datatable Info -->
                  <div id="datatableCounterInfo" class="mr-2" style="display: none;">
                     <div class="d-flex align-items-center">
                        <span class="font-size-sm mr-3">
                        <span id="datatableCounter">0</span>
                        Selected
                        </span>
                        <a class="btn btn-sm btn-outline-danger" href="javascript:;">
                        <i class="tio-delete-outlined"></i> Delete
                        </a>
                     </div>
                  </div>
                  <!-- End Datatable Info -->
                  <!-- Filter Collapse Trigger -->
                  <a class="btn btn-white dropdown-toggle" data-toggle="collapse" href="#filterSearchCollapse" role="button" aria-expanded="false" aria-controls="filterSearchCollapse">
                  <i class="tio-filter-outlined mr-1"></i> Filters
                  </a>
                  <!-- End Filter Collapse Trigger -->
               </div>
            </div>
         </div>
      </div>
      <!-- End Header -->
      <!-- Filter Search Collapse -->
      <div class="collapse" id="filterSearchCollapse">
         <div class="card-body">
            <form>
               <div class="row">
                  <div class="col-sm-12 col-lg-4">
                     <!-- Form Group -->
                     <div class="form-group">
                        <label for="teamsFilterLabel" class="input-label">Teams</label>
                        <div class="input-group input-group-merge">
                           <div class="input-group-prepend">
                              <div class="input-group-text">
                                 <i class="tio-group-senior"></i>
                              </div>
                           </div>
                           <input class="js-tagify tagify-form-control form-control" id="teamsFilterLabel" placeholder="Name, role, department" aria-label="Name, role, department">
                        </div>
                     </div>
                     <!-- End Form Group -->
                  </div>
                  <div class="col-sm-12 col-md-6 col-lg-4">
                     <!-- Form Group -->
                     <div class="form-group">
                        <label for="tagsFilterLabel" class="input-label">Tags</label>
                        <!-- Select -->
                        <select class="js-select2-custom" id="tagsFilterLabel" multiple
                           data-hs-select2-options='{
                           "customClass": "form-control",
                           "placeholder": "Enter top tags"
                           }'>
                           <option value="tagsFilter1" selected>Marketing team</option>
                           <option value="tagsFilter2" selected>Blockchain</option>
                           <option value="tagsFilter3">Customer service</option>
                           <option value="tagsFilter4">Online payment</option>
                           <option value="tagsFilter5">Finance</option>
                           <option value="tagsFilter6">Organizers</option>
                           <option value="tagsFilter7">Software</option>
                        </select>
                        <!-- End Select -->
                     </div>
                     <!-- End Form Group -->
                  </div>
                  <div class="col-sm-12 col-md-6 col-lg-4">
                     <!-- Form Group -->
                     <div class="form-group">
                        <label for="ratingFilterLabel" class="input-label">Rating</label>
                        <!-- Select -->
                        <select class="js-select2-custom" id="ratingFilterLabel" multiple
                           data-hs-select2-options='{
                           "minimumResultsForSearch": "Infinity",
                           "singleMultiple": true,
                           "placeholder": "<span class=\"d-flex align-items-center\"><i class=\"tio-star-outlined mr-2\"></i> Select rating</span>"
                           }'>
                           <option label="empty"></option>
                           <option value="rating1" data-option-template='<div class="d-flex">
                              <div class="mr-1"><img src="./assets/svg/components/star.svg" alt="Review rating" width="12"></div>
                              <div class="mr-1"><img src="./assets/svg/components/star-muted.svg" alt="Review rating" width="12"></div>
                              <div class="mr-1"><img src="./assets/svg/components/star-muted.svg" alt="Review rating" width="12"></div>
                              <div class="mr-1"><img src="./assets/svg/components/star-muted.svg" alt="Review rating" width="12"></div>
                              <div class="mr-1"><img src="./assets/svg/components/star-muted.svg" alt="Review rating" width="12"></div>
                              <span class="ml-2">1 star</span>
                              </div>'>1 star</option>
                           <option value="rating2" data-option-template='<div class="d-flex">
                              <div class="mr-1"><img src="./assets/svg/components/star.svg" alt="Review rating" width="12"></div>
                              <div class="mr-1"><img src="./assets/svg/components/star.svg" alt="Review rating" width="12"></div>
                              <div class="mr-1"><img src="./assets/svg/components/star-muted.svg" alt="Review rating" width="12"></div>
                              <div class="mr-1"><img src="./assets/svg/components/star-muted.svg" alt="Review rating" width="12"></div>
                              <div class="mr-1"><img src="./assets/svg/components/star-muted.svg" alt="Review rating" width="12"></div>
                              <span class="ml-2">2 star</span>
                              </div>'>2 star</option>
                           <option value="rating3" selected data-option-template='<div class="d-flex">
                              <div class="mr-1"><img src="./assets/svg/components/star.svg" alt="Review rating" width="12"></div>
                              <div class="mr-1"><img src="./assets/svg/components/star.svg" alt="Review rating" width="12"></div>
                              <div class="mr-1"><img src="./assets/svg/components/star.svg" alt="Review rating" width="12"></div>
                              <div class="mr-1"><img src="./assets/svg/components/star-muted.svg" alt="Review rating" width="12"></div>
                              <div class="mr-1"><img src="./assets/svg/components/star-muted.svg" alt="Review rating" width="12"></div>
                              <span class="ml-2">3 star</span>
                              </div>'>3 star</option>
                           <option value="rating4" selected data-option-template='<div class="d-flex">
                              <div class="mr-1"><img src="./assets/svg/components/star.svg" alt="Review rating" width="12"></div>
                              <div class="mr-1"><img src="./assets/svg/components/star.svg" alt="Review rating" width="12"></div>
                              <div class="mr-1"><img src="./assets/svg/components/star.svg" alt="Review rating" width="12"></div>
                              <div class="mr-1"><img src="./assets/svg/components/star.svg" alt="Review rating" width="12"></div>
                              <div class="mr-1"><img src="./assets/svg/components/star-muted.svg" alt="Review rating" width="12"></div>
                              <span class="ml-2">4 star</span>
                              </div>'>4 star</option>
                           <option value="rating5" selected data-option-template='<div class="d-flex">
                              <div class="mr-1"><img src="./assets/svg/components/star.svg" alt="Review rating" width="12"></div>
                              <div class="mr-1"><img src="./assets/svg/components/star.svg" alt="Review rating" width="12"></div>
                              <div class="mr-1"><img src="./assets/svg/components/star.svg" alt="Review rating" width="12"></div>
                              <div class="mr-1"><img src="./assets/svg/components/star.svg" alt="Review rating" width="12"></div>
                              <div class="mr-1"><img src="./assets/svg/components/star.svg" alt="Review rating" width="12"></div>
                              <span class="ml-2">5 star</span>
                              </div>'>5 star</option>
                        </select>
                        <!-- End Select -->
                     </div>
                     <!-- End Form Group -->
                  </div>
               </div>
               <!-- End Row -->
               <div class="d-flex justify-content-end">
                  <button type="button" class="btn btn-white mr-2">Cancel</button>
                  <button type="button" class="btn btn-primary">Apply</button>
               </div>
            </form>
         </div>
      </div>
      <!-- End Filter Search Collapse -->
      <!-- Table -->
      <div class="table-responsive datatable-custom">
         <table id="datatable" class="table table-borderless table-thead-bordered card-table"
            data-hs-datatables-options='{
            "autoWidth": false,
            "columnDefs": [{
            "targets": [0, 6],
            "orderable": false
            }],
            "columns": [
            null,
            null,
            { "width": "35%" },
            null,
            null,
            null,
            null
            ],
            "order": [],
            "info": {
            "totalQty": "#datatableWithPaginationInfoTotalQty"
            },
            "search": "#datatableSearch",
            "entries": "#datatableEntries",
            "isResponsive": false,
            "isShowPaging": false,
            "pagination": "datatablePagination"
            }'>
            <thead class="thead-light">
               <tr>
                  <th scope="col" class="table-column-pr-0">
                     <div class="custom-control custom-checkbox">
                        <input id="datatableCheckAll" type="checkbox" class="custom-control-input">
                        <label class="custom-control-label" for="datatableCheckAll"></label>
                     </div>
                  </th>
                  <th scope="col" class="table-column-pl-0">Document Name</th>
                  <th scope="col">Folder</th>
                  <th scope="col"><i class="tio-chat-outlined"></i></th>
                  <th scope="col">Members</th>
                  <th scope="col"></th>
               </tr>
            </thead>
            <tbody>
               <tr>
                  <td class="table-column-pr-0">
                     <div class="custom-control custom-checkbox">
                        <input type="checkbox" class="custom-control-input" id="teamDataCheck1">
                        <label class="custom-control-label" for="teamDataCheck1"></label>
                     </div>
                  </td>
                  <td class="table-column-pl-0">
                     <a class="d-flex align-items-center" href="project.html">
                        <img class="avatar avatar-xs avatar-4by3" src="./assets/svg/brands/google-docs.svg" alt="Image Description">
                        <div class="ml-3">
                           <span class="d-block h5 text-hover-primary mb-0">Passport.jpg</span>
                           <ul class="list-inline list-separator small file-specs">
                              <li class="list-inline-item">Updated 50 min ago</li>
                              <li class="list-inline-item">25kb</li>
                           </ul>
                        </div>
                     </a>
                  </td>
                  <td><a class="badge badge-soft-primary p-2" href="#">Marketing team</a></td>
                  <td>
                     <!-- Toggle -->
                     <div class="hs-unfold">
                        <a class="js-hs-unfold-invoker text-body" href="javascript:;"
                           data-hs-unfold-options='{
                           "target": "#activitySidebar",
                           "type": "css-animation",
                           "animationIn": "fadeInRight",
                           "animationOut": "fadeOutRight",
                           "hasOverlay": true,
                           "smartPositionOff": true
                           }'>
                        <i class="tio-chat-outlined"></i> 21
                        </a>
                     </div>
                     <!-- End Toggle -->
                     <!-- Sidebar -->
                     <div id="activitySidebar" class="hs-unfold-content sidebar sidebar-bordered sidebar-box-shadow">
                        <div class="card card-lg sidebar-card sidebar-scrollbar">
                           <div class="card-header">
                              <h4 class="card-header-title">Sidebar title</h4>
                              <!-- Toggle Button -->
                              <a class="js-hs-unfold-invoker btn btn-icon btn-xs btn-ghost-dark ml-2" href="javascript:;"
                                 data-hs-unfold-options='{
                                 "target": "#activitySidebar",
                                 "type": "css-animation",
                                 "animationIn": "fadeInRight",
                                 "animationOut": "fadeOutRight",
                                 "hasOverlay": true,
                                 "smartPositionOff": true
                                 }'>
                              <i class="tio-clear tio-lg"></i>
                              </a>
                              <!-- End Toggle Button -->
                           </div>
                           <!-- Body -->
                           <div class="card-body sidebar-body">
                              Sidebar body...
                           </div>
                           <!-- End Body -->
                        </div>
                     </div>
                     <!-- End Sidebar -->    
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
                  <td>
                     <!-- Unfold -->
                     <div class="hs-unfold">
                        <a class="js-hs-unfold-invoker btn btn-sm btn-white" href="javascript:;"
                           data-hs-unfold-options='{
                           "target": "#filesListDropdown6",
                           "type": "css-animation"
                           }'>
                        <span class="d-none d-sm-inline-block mr-1">More</span>
                        <i class="tio-chevron-down"></i>
                        </a>
                        <div id="filesListDropdown6" class="hs-unfold-content dropdown-unfold dropdown-menu dropdown-menu-right" style="min-width: 13rem;">
                           <span class="dropdown-header">Settings</span>
                           <a class="dropdown-item" href="#">
                           <i class="tio-share dropdown-item-icon"></i>
                           Share file
                           </a>
                           <a class="dropdown-item" href="#">
                           <i class="tio-folder-add dropdown-item-icon"></i>
                           Move to
                           </a>
                           <a class="dropdown-item" href="#">
                           <i class="tio-star-outlined dropdown-item-icon"></i>
                           Add to stared
                           </a>
                           <a class="dropdown-item" href="#">
                           <i class="tio-edit dropdown-item-icon"></i>
                           Rename
                           </a>
                           <a class="dropdown-item" href="#">
                           <i class="tio-download-to dropdown-item-icon"></i>
                           Download
                           </a>
                           <div class="dropdown-divider"></div>
                           <a class="dropdown-item" href="#">
                           <i class="tio-chat-outlined dropdown-item-icon"></i>
                           Report
                           </a>
                           <a class="dropdown-item" href="#">
                           <i class="tio-delete-outlined dropdown-item-icon"></i>
                           Delete
                           </a>
                        </div>
                     </div>
                     <!-- End Unfold -->
                  </td>
               </tr>
               <tr>
                  <td class="table-column-pr-0">
                     <div class="custom-control custom-checkbox">
                        <input type="checkbox" class="custom-control-input" id="teamDataCheck2">
                        <label class="custom-control-label" for="teamDataCheck2"></label>
                     </div>
                  </td>
                  <td class="table-column-pl-0">
                     <a class="d-flex align-items-center" href="project.html">
                        <img class="avatar avatar-xs avatar-4by3" src="./assets/svg/brands/google-docs.svg" alt="Image Description">
                        <div class="ml-3">
                           <span class="d-block h5 text-hover-primary mb-0">12th-marksheet.jpg</span>
                           <ul class="list-inline list-separator small file-specs">
                              <li class="list-inline-item">Updated 50 min ago</li>
                              <li class="list-inline-item">25kb</li>
                           </ul>
                        </div>
                     </a>
                  </td>
                  <td><a class="badge badge-soft-dark p-2" href="#">Blockchain</a></td>
                  <td>
                     <!-- Toggle -->
                     <div class="hs-unfold">
                        <a class="js-hs-unfold-invoker text-body message-unread" href="javascript:;"
                           data-hs-unfold-options='{
                           "target": "#activitySidebar",
                           "type": "css-animation",
                           "animationIn": "fadeInRight",
                           "animationOut": "fadeOutRight",
                           "hasOverlay": true,
                           "smartPositionOff": true
                           }'>
                        <i class="tio-chat-outlined"></i> 9
                        </a>
                     </div>
                     <!-- End Toggle -->
                     <!-- Sidebar -->
                     <div id="activitySidebar" class="hs-unfold-content sidebar sidebar-bordered sidebar-box-shadow">
                        <div class="card card-lg sidebar-card sidebar-scrollbar">
                           <div class="card-header">
                              <h4 class="card-header-title">Sidebar title</h4>
                              <!-- Toggle Button -->
                              <a class="js-hs-unfold-invoker btn btn-icon btn-xs btn-ghost-dark ml-2" href="javascript:;"
                                 data-hs-unfold-options='{
                                 "target": "#activitySidebar",
                                 "type": "css-animation",
                                 "animationIn": "fadeInRight",
                                 "animationOut": "fadeOutRight",
                                 "hasOverlay": true,
                                 "smartPositionOff": true
                                 }'>
                              <i class="tio-clear tio-lg"></i>
                              </a>
                              <!-- End Toggle Button -->
                           </div>
                           <!-- Body -->
                           <div class="card-body sidebar-body">
                              Sidebar body...
                           </div>
                           <!-- End Body -->
                        </div>
                     </div>
                     <!-- End Sidebar -->    
                  </td>
                  <td>
                     <div class="avatar-group avatar-group-xs avatar-circle">
                        <span class="avatar" data-toggle="tooltip" data-placement="top" title="Sam Kart">
                        <img class="avatar-img" src="./assets/img/160x160/img4.jpg" alt="Image Description">
                        </span>
                        <span class="avatar avatar-soft-danger" data-toggle="tooltip" data-placement="top" title="Teresa Eyker">
                        <span class="avatar-initials">T</span>
                        </span>
                        <span class="avatar" data-toggle="tooltip" data-placement="top" title="Amanda Harvey">
                        <img class="avatar-img" src="./assets/img/160x160/img10.jpg" alt="Image Description">
                        </span>
                        <span class="avatar" data-toggle="tooltip" data-placement="top" title="David Harrison">
                        <img class="avatar-img" src="./assets/img/160x160/img3.jpg" alt="Image Description">
                        </span>
                        <span class="avatar avatar-soft-warning" data-toggle="tooltip" data-placement="top" title="Olivier L.">
                        <span class="avatar-initials">O</span>
                        </span>
                        <span class="avatar avatar-light avatar-circle" data-toggle="tooltip" data-placement="top" title="Brian Halligan, Rachel Doe and 7 more">
                        <span class="avatar-initials">+9</span>
                        </span>
                     </div>
                  </td>
                  <td>
                     <!-- Unfold -->
                     <div class="hs-unfold">
                        <a class="js-hs-unfold-invoker btn btn-sm btn-white" href="javascript:;"
                           data-hs-unfold-options='{
                           "target": "#filesListDropdown1",
                           "type": "css-animation"
                           }'>
                        <span class="d-none d-sm-inline-block mr-1">More</span>
                        <i class="tio-chevron-down"></i>
                        </a>
                        <div id="filesListDropdown1" class="hs-unfold-content dropdown-unfold dropdown-menu dropdown-menu-right" style="min-width: 13rem;">
                           <span class="dropdown-header">Settings</span>
                           <a class="dropdown-item" href="#">
                           <i class="tio-share dropdown-item-icon"></i>
                           Share file
                           </a>
                           <a class="dropdown-item" href="#">
                           <i class="tio-folder-add dropdown-item-icon"></i>
                           Move to
                           </a>
                           <a class="dropdown-item" href="#">
                           <i class="tio-star-outlined dropdown-item-icon"></i>
                           Add to stared
                           </a>
                           <a class="dropdown-item" href="#">
                           <i class="tio-edit dropdown-item-icon"></i>
                           Rename
                           </a>
                           <a class="dropdown-item" href="#">
                           <i class="tio-download-to dropdown-item-icon"></i>
                           Download
                           </a>
                           <div class="dropdown-divider"></div>
                           <a class="dropdown-item" href="#">
                           <i class="tio-chat-outlined dropdown-item-icon"></i>
                           Report
                           </a>
                           <a class="dropdown-item" href="#">
                           <i class="tio-delete-outlined dropdown-item-icon"></i>
                           Delete
                           </a>
                        </div>
                     </div>
                     <!-- End Unfold -->
                  </td>
               </tr>
               <tr>
                  <td class="table-column-pr-0">
                     <div class="custom-control custom-checkbox">
                        <input type="checkbox" class="custom-control-input" id="teamDataCheck3">
                        <label class="custom-control-label" for="teamDataCheck3"></label>
                     </div>
                  </td>
                  <td class="table-column-pl-0">
                     <a class="d-flex align-items-center" href="project.html">
                        <img class="avatar avatar-xs avatar-4by3" src="./assets/svg/brands/google-sheets.svg" alt="Image Description">
                        <div class="ml-3">
                           <span class="d-block h5 text-hover-primary mb-0">Cloud computing web service</span>
                           <ul class="list-inline list-separator small file-specs">
                              <li class="list-inline-item">Updated 50 min ago</li>
                              <li class="list-inline-item">25kb</li>
                           </ul>
                        </div>
                     </a>
                  </td>
                  <td><a class="badge badge-soft-info p-2" href="#">Marketing team</a></td>
                  <td>
                     <!-- Toggle -->
                     <div class="hs-unfold">
                        <a class="js-hs-unfold-invoker text-body" href="javascript:;"
                           data-hs-unfold-options='{
                           "target": "#activitySidebar",
                           "type": "css-animation",
                           "animationIn": "fadeInRight",
                           "animationOut": "fadeOutRight",
                           "hasOverlay": true,
                           "smartPositionOff": true
                           }'>
                        -
                        </a>
                     </div>
                     <!-- End Toggle -->
                     <!-- Sidebar -->
                     <div id="activitySidebar" class="hs-unfold-content sidebar sidebar-bordered sidebar-box-shadow">
                        <div class="card card-lg sidebar-card sidebar-scrollbar">
                           <div class="card-header">
                              <h4 class="card-header-title">Sidebar title</h4>
                              <!-- Toggle Button -->
                              <a class="js-hs-unfold-invoker btn btn-icon btn-xs btn-ghost-dark ml-2" href="javascript:;"
                                 data-hs-unfold-options='{
                                 "target": "#activitySidebar",
                                 "type": "css-animation",
                                 "animationIn": "fadeInRight",
                                 "animationOut": "fadeOutRight",
                                 "hasOverlay": true,
                                 "smartPositionOff": true
                                 }'>
                              <i class="tio-clear tio-lg"></i>
                              </a>
                              <!-- End Toggle Button -->
                           </div>
                           <!-- Body -->
                           <div class="card-body sidebar-body">
                              Sidebar body...
                           </div>
                           <!-- End Body -->
                        </div>
                     </div>
                     <!-- End Sidebar -->    
                  </td>
                  <td>
                     <div class="avatar-group avatar-group-xs avatar-circle">
                        <span class="avatar" data-toggle="tooltip" data-placement="top" title="Costa Quinn">
                        <img class="avatar-img" src="./assets/img/160x160/img6.jpg" alt="Image Description">
                        </span>
                        <span class="avatar" data-toggle="tooltip" data-placement="top" title="Clarice Boone">
                        <img class="avatar-img" src="./assets/img/160x160/img7.jpg" alt="Image Description">
                        </span>
                        <span class="avatar avatar-soft-dark" data-toggle="tooltip" data-placement="top" title="Zack Ins">
                        <span class="avatar-initials">Z</span>
                        </span>
                     </div>
                  </td>
                  <td>
                     <!-- Unfold -->
                     <div class="hs-unfold">
                        <a class="js-hs-unfold-invoker btn btn-sm btn-white" href="javascript:;"
                           data-hs-unfold-options='{
                           "target": "#filesListDropdown2",
                           "type": "css-animation"
                           }'>
                        <span class="d-none d-sm-inline-block mr-1">More</span>
                        <i class="tio-chevron-down"></i>
                        </a>
                        <div id="filesListDropdown2" class="hs-unfold-content dropdown-unfold dropdown-menu dropdown-menu-right" style="min-width: 13rem;">
                           <span class="dropdown-header">Settings</span>
                           <a class="dropdown-item" href="#">
                           <i class="tio-share dropdown-item-icon"></i>
                           Share file
                           </a>
                           <a class="dropdown-item" href="#">
                           <i class="tio-folder-add dropdown-item-icon"></i>
                           Move to
                           </a>
                           <a class="dropdown-item" href="#">
                           <i class="tio-star-outlined dropdown-item-icon"></i>
                           Add to stared
                           </a>
                           <a class="dropdown-item" href="#">
                           <i class="tio-edit dropdown-item-icon"></i>
                           Rename
                           </a>
                           <a class="dropdown-item" href="#">
                           <i class="tio-download-to dropdown-item-icon"></i>
                           Download
                           </a>
                           <div class="dropdown-divider"></div>
                           <a class="dropdown-item" href="#">
                           <i class="tio-chat-outlined dropdown-item-icon"></i>
                           Report
                           </a>
                           <a class="dropdown-item" href="#">
                           <i class="tio-delete-outlined dropdown-item-icon"></i>
                           Delete
                           </a>
                        </div>
                     </div>
                     <!-- End Unfold -->
                  </td>
               </tr>
               <tr>
                  <td class="table-column-pr-0">
                     <div class="custom-control custom-checkbox">
                        <input type="checkbox" class="custom-control-input" id="teamDataCheck4">
                        <label class="custom-control-label" for="teamDataCheck4"></label>
                     </div>
                  </td>
                  <td class="table-column-pl-0">
                     <a class="d-flex align-items-center" href="project.html">
                        <img class="avatar avatar-xs avatar-4by3" src="./assets/svg/brands/google-slides.svg" alt="Image Description">
                        <div class="ml-3">
                           <span class="d-block h5 text-hover-primary mb-0">Cloud computing web service</span>
                           <ul class="list-inline list-separator small file-specs">
                              <li class="list-inline-item">Updated 50 min ago</li>
                              <li class="list-inline-item">25kb</li>
                           </ul>
                        </div>
                     </a>
                  </td>
                  <td><a class="badge badge-soft-danger p-2" href="#">Customer service</a></td>
                  <td>
                     <!-- Toggle -->
                     <div class="hs-unfold">
                        <a class="js-hs-unfold-invoker text-body message-unread" href="javascript:;"
                           data-hs-unfold-options='{
                           "target": "#activitySidebar",
                           "type": "css-animation",
                           "animationIn": "fadeInRight",
                           "animationOut": "fadeOutRight",
                           "hasOverlay": true,
                           "smartPositionOff": true
                           }'>
                        <i class="tio-chat-outlined"></i> 19
                        </a>
                     </div>
                     <!-- End Toggle -->
                     <!-- Sidebar -->
                     <div id="activitySidebar" class="hs-unfold-content sidebar sidebar-bordered sidebar-box-shadow">
                        <div class="card card-lg sidebar-card sidebar-scrollbar">
                           <div class="card-header">
                              <h4 class="card-header-title">Sidebar title</h4>
                              <!-- Toggle Button -->
                              <a class="js-hs-unfold-invoker btn btn-icon btn-xs btn-ghost-dark ml-2" href="javascript:;"
                                 data-hs-unfold-options='{
                                 "target": "#activitySidebar",
                                 "type": "css-animation",
                                 "animationIn": "fadeInRight",
                                 "animationOut": "fadeOutRight",
                                 "hasOverlay": true,
                                 "smartPositionOff": true
                                 }'>
                              <i class="tio-clear tio-lg"></i>
                              </a>
                              <!-- End Toggle Button -->
                           </div>
                           <!-- Body -->
                           <div class="card-body sidebar-body">
                              Sidebar body...
                           </div>
                           <!-- End Body -->
                        </div>
                     </div>
                     <!-- End Sidebar -->    
                  </td>
                  <td>
                     <div class="avatar-group avatar-group-xs avatar-circle">
                        <span class="avatar" data-toggle="tooltip" data-placement="top" title="Costa Quinn">
                        <img class="avatar-img" src="./assets/img/160x160/img6.jpg" alt="Image Description">
                        </span>
                        <span class="avatar" data-toggle="tooltip" data-placement="top" title="Clarice Boone">
                        <img class="avatar-img" src="./assets/img/160x160/img7.jpg" alt="Image Description">
                        </span>
                        <span class="avatar avatar-soft-dark" data-toggle="tooltip" data-placement="top" title="Adam Keep">
                        <span class="avatar-initials">A</span>
                        </span>
                     </div>
                  </td>
                  <td>
                     <!-- Unfold -->
                     <div class="hs-unfold">
                        <a class="js-hs-unfold-invoker btn btn-sm btn-white" href="javascript:;"
                           data-hs-unfold-options='{
                           "target": "#filesListDropdown3",
                           "type": "css-animation"
                           }'>
                        <span class="d-none d-sm-inline-block mr-1">More</span>
                        <i class="tio-chevron-down"></i>
                        </a>
                        <div id="filesListDropdown3" class="hs-unfold-content dropdown-unfold dropdown-menu dropdown-menu-right" style="min-width: 13rem;">
                           <span class="dropdown-header">Settings</span>
                           <a class="dropdown-item" href="#">
                           <i class="tio-share dropdown-item-icon"></i>
                           Share file
                           </a>
                           <a class="dropdown-item" href="#">
                           <i class="tio-folder-add dropdown-item-icon"></i>
                           Move to
                           </a>
                           <a class="dropdown-item" href="#">
                           <i class="tio-star-outlined dropdown-item-icon"></i>
                           Add to stared
                           </a>
                           <a class="dropdown-item" href="#">
                           <i class="tio-edit dropdown-item-icon"></i>
                           Rename
                           </a>
                           <a class="dropdown-item" href="#">
                           <i class="tio-download-to dropdown-item-icon"></i>
                           Download
                           </a>
                           <div class="dropdown-divider"></div>
                           <a class="dropdown-item" href="#">
                           <i class="tio-chat-outlined dropdown-item-icon"></i>
                           Report
                           </a>
                           <a class="dropdown-item" href="#">
                           <i class="tio-delete-outlined dropdown-item-icon"></i>
                           Delete
                           </a>
                        </div>
                     </div>
                     <!-- End Unfold -->
                  </td>
               </tr>
               <tr>
                  <td class="table-column-pr-0">
                     <div class="custom-control custom-checkbox">
                        <input type="checkbox" class="custom-control-input" id="teamDataCheck5">
                        <label class="custom-control-label" for="teamDataCheck5"></label>
                     </div>
                  </td>
                  <td class="table-column-pl-0">
                     <a class="d-flex align-items-center" href="project.html">
                        <img class="avatar avatar-xs avatar-4by3" src="./assets/svg/brands/pdf.svg" alt="Image Description">
                        <div class="ml-3">
                           <span class="d-block h5 text-hover-primary mb-0">Cloud computing web service</span>
                           <ul class="list-inline list-separator small file-specs">
                              <li class="list-inline-item">Updated 50 min ago</li>
                              <li class="list-inline-item">25kb</li>
                           </ul>
                        </div>
                     </a>
                  </td>
                  <td><a class="badge badge-soft-primary p-2" href="#">Online payment</a></td>
                  <td>
                     <!-- Toggle -->
                     <div class="hs-unfold">
                        <a class="js-hs-unfold-invoker text-body" href="javascript:;"
                           data-hs-unfold-options='{
                           "target": "#activitySidebar",
                           "type": "css-animation",
                           "animationIn": "fadeInRight",
                           "animationOut": "fadeOutRight",
                           "hasOverlay": true,
                           "smartPositionOff": true
                           }'>
                        <i class="tio-chat-outlined"></i> 21
                        </a>
                     </div>
                     <!-- End Toggle -->
                     <!-- Sidebar -->
                     <div id="activitySidebar" class="hs-unfold-content sidebar sidebar-bordered sidebar-box-shadow">
                        <div class="card card-lg sidebar-card sidebar-scrollbar">
                           <div class="card-header">
                              <h4 class="card-header-title">Sidebar title</h4>
                              <!-- Toggle Button -->
                              <a class="js-hs-unfold-invoker btn btn-icon btn-xs btn-ghost-dark ml-2" href="javascript:;"
                                 data-hs-unfold-options='{
                                 "target": "#activitySidebar",
                                 "type": "css-animation",
                                 "animationIn": "fadeInRight",
                                 "animationOut": "fadeOutRight",
                                 "hasOverlay": true,
                                 "smartPositionOff": true
                                 }'>
                              <i class="tio-clear tio-lg"></i>
                              </a>
                              <!-- End Toggle Button -->
                           </div>
                           <!-- Body -->
                           <div class="card-body sidebar-body">
                              Sidebar body...
                           </div>
                           <!-- End Body -->
                        </div>
                     </div>
                     <!-- End Sidebar -->    
                  </td>
                  <td>
                     <div class="avatar-group avatar-group-xs avatar-circle">
                        <span class="avatar" data-toggle="tooltip" data-placement="top" title="Finch Hoot">
                        <img class="avatar-img" src="./assets/img/160x160/img5.jpg" alt="Image Description">
                        </span>
                        <span class="avatar avatar-soft-dark" data-toggle="tooltip" data-placement="top" title="Bob Bardly">
                        <span class="avatar-initials">B</span>
                        </span>
                        <span class="avatar" data-toggle="tooltip" data-placement="top" title="Linda Bates">
                        <img class="avatar-img" src="./assets/img/160x160/img8.jpg" alt="Image Description">
                        </span>
                        <span class="avatar" data-toggle="tooltip" data-placement="top" title="Ella Lauda">
                        <img class="avatar-img" src="./assets/img/160x160/img9.jpg" alt="Image Description">
                        </span>
                     </div>
                  </td>
                  <td>
                     <!-- Unfold -->
                     <div class="hs-unfold">
                        <a class="js-hs-unfold-invoker btn btn-sm btn-white" href="javascript:;"
                           data-hs-unfold-options='{
                           "target": "#filesListDropdown4",
                           "type": "css-animation"
                           }'>
                        <span class="d-none d-sm-inline-block mr-1">More</span>
                        <i class="tio-chevron-down"></i>
                        </a>
                        <div id="filesListDropdown4" class="hs-unfold-content dropdown-unfold dropdown-menu dropdown-menu-right" style="min-width: 13rem;">
                           <span class="dropdown-header">Settings</span>
                           <a class="dropdown-item" href="#">
                           <i class="tio-share dropdown-item-icon"></i>
                           Share file
                           </a>
                           <a class="dropdown-item" href="#">
                           <i class="tio-folder-add dropdown-item-icon"></i>
                           Move to
                           </a>
                           <a class="dropdown-item" href="#">
                           <i class="tio-star-outlined dropdown-item-icon"></i>
                           Add to stared
                           </a>
                           <a class="dropdown-item" href="#">
                           <i class="tio-edit dropdown-item-icon"></i>
                           Rename
                           </a>
                           <a class="dropdown-item" href="#">
                           <i class="tio-download-to dropdown-item-icon"></i>
                           Download
                           </a>
                           <div class="dropdown-divider"></div>
                           <a class="dropdown-item" href="#">
                           <i class="tio-chat-outlined dropdown-item-icon"></i>
                           Report
                           </a>
                           <a class="dropdown-item" href="#">
                           <i class="tio-delete-outlined dropdown-item-icon"></i>
                           Delete
                           </a>
                        </div>
                     </div>
                     <!-- End Unfold -->
                  </td>
               </tr>
               <tr>
                  <td class="table-column-pr-0">
                     <div class="custom-control custom-checkbox">
                        <input type="checkbox" class="custom-control-input" id="teamDataCheck6">
                        <label class="custom-control-label" for="teamDataCheck6"></label>
                     </div>
                  </td>
                  <td class="table-column-pl-0">
                     <a class="d-flex align-items-center" href="project.html">
                        <img class="avatar avatar-xs avatar-4by3" src="./assets/svg/brands/google-docs.svg" alt="Image Description">
                        <div class="ml-3">
                           <span class="d-block h5 text-hover-primary mb-0">Cloud computing web service</span>
                           <ul class="list-inline list-separator small file-specs">
                              <li class="list-inline-item">Updated 50 min ago</li>
                              <li class="list-inline-item">25kb</li>
                           </ul>
                        </div>
                     </a>
                  </td>
                  <td><a class="badge badge-soft-info p-2" href="#">Finance</a></td>
                  <td>
                     <!-- Toggle -->
                     <div class="hs-unfold">
                        <a class="js-hs-unfold-invoker text-body" href="javascript:;"
                           data-hs-unfold-options='{
                           "target": "#activitySidebar",
                           "type": "css-animation",
                           "animationIn": "fadeInRight",
                           "animationOut": "fadeOutRight",
                           "hasOverlay": true,
                           "smartPositionOff": true
                           }'>
                        <i class="tio-chat-outlined"></i> 21
                        </a>
                     </div>
                     <!-- End Toggle -->
                     <!-- Sidebar -->
                     <div id="activitySidebar" class="hs-unfold-content sidebar sidebar-bordered sidebar-box-shadow">
                        <div class="card card-lg sidebar-card sidebar-scrollbar">
                           <div class="card-header">
                              <h4 class="card-header-title">Sidebar title</h4>
                              <!-- Toggle Button -->
                              <a class="js-hs-unfold-invoker btn btn-icon btn-xs btn-ghost-dark ml-2" href="javascript:;"
                                 data-hs-unfold-options='{
                                 "target": "#activitySidebar",
                                 "type": "css-animation",
                                 "animationIn": "fadeInRight",
                                 "animationOut": "fadeOutRight",
                                 "hasOverlay": true,
                                 "smartPositionOff": true
                                 }'>
                              <i class="tio-clear tio-lg"></i>
                              </a>
                              <!-- End Toggle Button -->
                           </div>
                           <!-- Body -->
                           <div class="card-body sidebar-body">
                              Sidebar body...
                           </div>
                           <!-- End Body -->
                        </div>
                     </div>
                     <!-- End Sidebar -->    
                  </td>
                  <td>
                     <div class="avatar-group avatar-group-xs avatar-circle">
                        <span class="avatar" data-toggle="tooltip" data-placement="top" title="Finch Hoot">
                        <img class="avatar-img" src="./assets/img/160x160/img5.jpg" alt="Image Description">
                        </span>
                        <span class="avatar avatar-soft-dark" data-toggle="tooltip" data-placement="top" title="Bob Bardly">
                        <span class="avatar-initials">B</span>
                        </span>
                        <span class="avatar" data-toggle="tooltip" data-placement="top" title="Linda Bates">
                        <img class="avatar-img" src="./assets/img/160x160/img8.jpg" alt="Image Description">
                        </span>
                        <span class="avatar" data-toggle="tooltip" data-placement="top" title="Ella Lauda">
                        <img class="avatar-img" src="./assets/img/160x160/img9.jpg" alt="Image Description">
                        </span>
                     </div>
                  </td>
                  <td>
                     <!-- Unfold -->
                     <div class="hs-unfold">
                        <a class="js-hs-unfold-invoker btn btn-sm btn-white" href="javascript:;"
                           data-hs-unfold-options='{
                           "target": "#filesListDropdown5",
                           "type": "css-animation"
                           }'>
                        <span class="d-none d-sm-inline-block mr-1">More</span>
                        <i class="tio-chevron-down"></i>
                        </a>
                        <div id="filesListDropdown5" class="hs-unfold-content dropdown-unfold dropdown-menu dropdown-menu-right" style="min-width: 13rem;">
                           <span class="dropdown-header">Settings</span>
                           <a class="dropdown-item" href="#">
                           <i class="tio-share dropdown-item-icon"></i>
                           Share file
                           </a>
                           <a class="dropdown-item" href="#">
                           <i class="tio-folder-add dropdown-item-icon"></i>
                           Move to
                           </a>
                           <a class="dropdown-item" href="#">
                           <i class="tio-star-outlined dropdown-item-icon"></i>
                           Add to stared
                           </a>
                           <a class="dropdown-item" href="#">
                           <i class="tio-edit dropdown-item-icon"></i>
                           Rename
                           </a>
                           <a class="dropdown-item" href="#">
                           <i class="tio-download-to dropdown-item-icon"></i>
                           Download
                           </a>
                           <div class="dropdown-divider"></div>
                           <a class="dropdown-item" href="#">
                           <i class="tio-chat-outlined dropdown-item-icon"></i>
                           Report
                           </a>
                           <a class="dropdown-item" href="#">
                           <i class="tio-delete-outlined dropdown-item-icon"></i>
                           Delete
                           </a>
                        </div>
                     </div>
                     <!-- End Unfold -->
                  </td>
               </tr>
            </tbody>
         </table>
      </div>
      <!-- End Table -->
      <!-- Footer -->
      <div class="card-footer">
         <!-- Pagination -->
         <div class="row justify-content-center justify-content-sm-between align-items-sm-center">
            <div class="col-sm mb-2 mb-sm-0">
               <div class="d-flex justify-content-center justify-content-sm-start align-items-center">
                  <span class="mr-2">Showing:</span>
                  <!-- Select -->
                  <select id="datatableEntries" class="js-select2-custom"
                     data-hs-select2-options='{
                     "minimumResultsForSearch": "Infinity",
                     "customClass": "custom-select custom-select-sm custom-select-borderless",
                     "dropdownAutoWidth": true,
                     "width": true
                     }'>
                     <option value="4">4</option>
                     <option value="6">6</option>
                     <option value="8" selected>8</option>
                     <option value="12">12</option>
                  </select>
                  <!-- End Select -->
                  <span class="text-secondary mr-2">of</span>
                  <!-- Pagination Quantity -->
                  <span id="datatableWithPaginationInfoTotalQty"></span>
               </div>
            </div>
            <div class="col-sm-auto">
               <div class="d-flex justify-content-center justify-content-sm-end">
                  <!-- Pagination -->
                  <nav id="datatablePagination" aria-label="Activity pagination"></nav>
               </div>
            </div>
         </div>
         <!-- End Pagination -->
      </div>
      <!-- End Footer -->
   </div>
   <!-- End Card -->
</div>
<!-- End Content -->
<!-- End Content -->
@endsection
@section('javascript')
<script type="text/javascript">
   $(document).ready(function(){
     $('.js-hs-action').each(function () {
       var unfold = new HSUnfold($(this)).init();
     });
   })
</script>
@endsection