@extends('frontend.layouts.master')
<!-- Hero Section -->
@section('style')


@endsection

@section('content')
<!-- Search Section -->
<div class="bg-dark">
    <div class="bg-img-hero-center"
        style="background-image: url({{asset('assets/frontend/svg/components/abstract-shapes-19.svg')}});padding-top: 94px;">
        <div class="container space-1">
            <div class="w-lg-100 mx-lg-auto">
                <!-- Input -->
                <h1 class="text-lh-sm text-white">Professionals</h1>
                <!-- End Input -->
            </div>
        </div>
    </div>
</div>
<div class="container space-bottom-2">
    <div class="w-lg-100 mx-lg-auto">
        <!-- Breadcrumbs -->
        <!-- Breadcrumbs -->
        <nav aria-label="breadcrumb">
            <ol class="breadcrumb breadcrumb-no-gutter font-size-1 space-1">
                <li class="breadcrumb-item"><a href="{{url('/')}}">Home</a></li>
                <li class="breadcrumb-item active">Professionals</li>
            </ol>
        </nav>
        <!-- End Breadcrumbs -->



        <div class="card card-bordered custom-content-card p-5 mb-5">

            <h3 class="text-uppercase text-muted">Immigration Lawyers, Consultants, Advisers and Migration Agents (15450
                results)</h3>

            <p>Find immigration professionals based on the destination country or their business location.</p>

            <div class="search-bar">

                <form id="search-form" class="form-inline" method="post">
                    @csrf
                    <input type="search" name="search_by_keyword" id="datatableSearch" class="search-input"
                        placeholder="Search keyword: Professional Name or Company Name" style="">

                    <button class="btn btnsearch" id="btnsearch" type="button">Search</button>

                    <div class="form-group mt-4 p-3">
                        <label>Filters</label>
                    </div>

                    <div class="form-group mt-4">
                        <select onchange="loadData()" class="form-control form-control-sm" name="country" id="country">
                            <option value="">Countries</option>
                            <option value="all">All</option>
                            @foreach($countries as $key=>$country)
                            <option value="{{$country->id}}">{{$country->name}}</option>
                            @endforeach
                        </select>

                    </div>


                    <div class="form-group ml-1 mt-4">
                        <select onchange="loadData()" class="form-control form-control-sm" name="state" id="state">
                            <option value="">States</option>
                        </select>
                    </div>


                    <div class="form-group ml-1 mt-4">
                        <select onchange="loadData()" class="form-control form-control-sm" name="visa_service" id="visa_service">
                            <option value="">Visa Service</option>
                            <option value="all">All</option>
                            @foreach($visa_services as $visa_service)
                            <option value="{{$visa_service->unique_id}}">{{$visa_service->name}}</option>
                            @endforeach
                        </select>
                    </div>


                    <div class="form-group ml-1 mt-4">
                        <select onchange="loadData()" class="form-control form-control-sm" name="languages" id="languages">
                            <option value="">Language</option>
                            <option value="all">All</option>
                            @foreach($languages as $language)
                            <option value="{{$language->id}}">{{$language->name}}</option>
                            @endforeach
                        </select>
                    </div>


                    <div class="form-group ml-1 mt-4">
                        <div class="dropdown">
                            <button class="btn btn-sm btn-secondary dropdown-toggle" type="button" id="dropdownCountry"
                                data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                Review
                            </button>
                            <div class="dropdown-menu" aria-labelledby="dropdownCountry">
                                <a class="dropdown-item" href="#">Action</a>
                                <a class="dropdown-item" href="#">Another action</a>
                                <a class="dropdown-item" href="#">Something else here</a>
                            </div>
                        </div>
                    </div>

                    <div class="text-right">
                        <div class="form-group ml-1 mt-4 ">
                            <button class="btn btn-sm btn-white" type="button" id="btnreset" name="reset">
                                Reset
                            </button>
                        </div>
                    </div>
                </form>

            </div>

        </div>


        <div class="table-responsive datatable-custom">
          <table id="dataLists" class="table table-borderless datatable course-table"
                data-hs-datatables-options='{
                          "order": [],
                          "isResponsive": true,
                          "paging": false,
                          "searching":false,
                          "isShowPaging": true,
                          "pagination": "dataListsPagination"
                        }'>
                <tbody>
                </tbody>
          </table>  

        </div>


      

    </div>


</div>
@endsection

@section("javascript")
<!-- <script src="assets/vendor/hs-file-attach/dist/hs-file-attach.min.js"></script> -->
<script src="assets/vendor/datatables/media/js/jquery.dataTables.min.js"></script>
<script type="text/javascript">
$(document).ready(function() {
    $("#btnreset").click(function(){
        // alert("test");
        $("#search-form select").each(function(){
            $(this).val('');
            
        });
        initSelect("#search-form");
        loadData();
    })
    $("#country").change(function(){
        if($(this).val() != ''){
            stateList($(this).val());
        }
    })

    $('.datatable').each(function () {
        var id = $(this).attr("id");
        var datatable = $.HSCore.components.HSDatatables.init($('#'+id));
        // $("#"+id).DataTable();
    });
    $("#btnsearch").click(function() {
        //alert("hell");
        loadData();
    });

    $(".next").click(function() {
        if (!$(this).hasClass('disabled')) {
            changePage('next');
        }
    });
    $(".previous").click(function() {
        if (!$(this).hasClass('disabled')) {
            changePage('prev');
        }
    });
    $("#datatableSearch").keyup(function() {
        var value = $(this).val();
        if (value == '') {
            loadData();
        }
        if (value.length > 3) {
            loadData();
        }
    });

    loadData();

});

function loadData() {
    var formdata = $("#search-form").serialize();
    $.ajax({
        type: "POST",
        url: SITEURL + '/professionals-list',
        data: formdata,
        dataType: 'json',
        beforeSend: function() {
            showLoader();
        },
        success: function(data) {
            hideLoader();
            $("#dataLists tbody").html(data.contents);

        },
    });
}

function changePage(action) {
    var page = parseInt($("#pageno").val());
    if (action == 'prev') {
        page--;
    }
    if (action == 'next') {
        page++;
    }
    if (!isNaN(page)) {
        loadData(page);
    } else {
        errorMessage("Invalid Page Number");
    }

}
function stateList(country_id){
    var id = "state";
    $.ajax({
         url:"{{ url('states') }}",
         data:{
            country_id:country_id
         },
         dataType:"json",
         beforeSend:function(){
         $("#"+id).html('');
         },
         success:function(response){
         if(response.status == true){
            $("#"+id).html(response.options);
         } 
      },
      error:function(){
         
      }
    });
}
</script>

@endsection