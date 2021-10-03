<div class="row gx-2 gx-lg-3">
    <div class="col-sm-6 col-lg-3 mb-3 mb-lg-5">
      <!-- Card -->
      <div class="card h-100">
        <div class="card-body">
          <h6 class="card-subtitle mb-2">Total Leads</h6>

          <div class="row align-items-center gx-2">
            <div class="col">
              <span class="js-counter display-4 text-dark">{{ $total_leads }}</span>
              <!-- <span class="text-body font-size-sm ml-1">from 22</span> -->
            </div>

            <div class="col-auto">
              <span class="badge badge-soft-success p-1">
                <!-- <i class="fa fa-eye"></i> -->
              </span>
            </div>
          </div>
          <!-- End Row -->
        </div>
      </div>
      <!-- End Card -->
    </div>

    <div class="col-sm-6 col-lg-3 mb-3 mb-lg-5">
      <!-- Card -->
      <div class="card h-100">
        <div class="card-body">
          <h6 class="card-subtitle mb-2">New Leads</h6>

          <div class="row align-items-center gx-2">
            <div class="col">
              <span class="js-counter display-4 text-dark">{{ $new_leads }}</span>
              <span class="text-body font-size-sm ml-1">from {{ $total_leads }}</span>
            </div>

            <div class="col-auto">
              <a href="{{ baseUrl('leads') }}" class="badge badge-soft-success p-1">
                <i class="fa fa-eye"></i> View
              </a>
            </div>
          </div>
          <!-- End Row -->
        </div>
      </div>
      <!-- End Card -->
    </div>

    <div class="col-sm-4 col-lg-3 mb-3 mb-lg-5">
      <!-- Card -->
      <div class="card h-100">
        <div class="card-body">
          <h6 class="card-subtitle mb-2">Leads as Client</h6>

          <div class="row align-items-center gx-2">
            <div class="col">
              <span class="js-counter display-4 text-dark">{{ $lead_as_client }}</span>
              
              <span class="text-body font-size-sm ml-1">from {{ $total_leads }}</span>
            </div>

            <div class="col-auto">
              <a href="{{ baseUrl('leads/assigned') }}" class="badge badge-soft-danger p-1">
                <i class="fa fa-eye"></i> View
              </a>
            </div>
          </div>
          <!-- End Row -->
        </div>
      </div>
      <!-- End Card -->
    </div>

    <div class="col-sm-6 col-lg-3 mb-3 mb-lg-5">
      <!-- Card -->
      <div class="card h-100">
        <div class="card-body">
          <h6 class="card-subtitle mb-2">Recommended as Client</h6>

          <div class="row align-items-center gx-2">
            <div class="col">
              <span class="js-counter display-4 text-dark">{{ $recommend_as_client }}</span>
              <span class="text-body font-size-sm ml-1">from {{ $total_leads }}</span>
            </div>

            <div class="col-auto">
              <a href="{{ baseUrl('leads/recommended') }}" class="badge badge-soft-warning p-1">
                <i class="fa fa-eye"></i> View
              </a>
            </div>
          </div>
          <!-- End Row -->
        </div>
      </div>
      <!-- End Card -->
    </div>
  </div>
