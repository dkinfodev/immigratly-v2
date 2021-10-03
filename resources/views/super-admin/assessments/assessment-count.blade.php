<div class="row gx-2 gx-lg-3">
    <div class="col-sm-4 col-lg-4 mb-3 mb-lg-5">
      <!-- Card -->
      <div class="card h-100">
        <div class="card-body">
          <h6 class="card-subtitle mb-2">Total Assessments</h6>

          <div class="row align-items-center gx-2">
            <div class="col">
              <span class="js-counter display-4 text-dark">{{ $total_assessments }}</span>
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

    <div class="col-sm-4 col-lg-4 mb-3 mb-lg-5">
      <!-- Card -->
      <div class="card h-100">
        <div class="card-body">
          <h6 class="card-subtitle mb-2">New Assessments</h6>

          <div class="row align-items-center gx-2">
            <div class="col">
              <span class="js-counter display-4 text-dark">{{ $new_count }}</span>
              <span class="text-body font-size-sm ml-1">from {{ $total_assessments }}</span>
            </div>

            <div class="col-auto">
              <a href="{{ baseUrl('assessments') }}" class="badge badge-soft-success p-1">
                <i class="fa fa-eye"></i> View
              </a>
            </div>
          </div>
          <!-- End Row -->
        </div>
      </div>
      <!-- End Card -->
    </div>

    <div class="col-sm-4 col-lg-4 mb-3 mb-lg-5">
      <!-- Card -->
      <div class="card h-100">
        <div class="card-body">
          <h6 class="card-subtitle mb-2">Assigned to Professional</h6>

          <div class="row align-items-center gx-2">
            <div class="col">
              <span class="js-counter display-4 text-dark">{{ $assigned_count }}</span>
              
              <span class="text-body font-size-sm ml-1">from {{ $total_assessments }}</span>
            </div>

            <div class="col-auto">
              <a href="{{ baseUrl('assessments/assigned') }}" class="badge badge-soft-danger p-1">
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
