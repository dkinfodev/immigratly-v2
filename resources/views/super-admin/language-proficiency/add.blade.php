@extends('layouts.master')

@section('content')
<style>
.input-group-add-field-delete {
    right: 103px !important;
}
</style>
<!-- Content -->
<div class="content container-fluid">
    <!-- Page Header -->
    <div class="page-header">
        <div class="row align-items-end">
            <div class="col-sm mb-2 mb-sm-0">
                <nav aria-label="breadcrumb">
                    <ol class="breadcrumb breadcrumb-no-gutter">
                        <li class="breadcrumb-item"><a class="breadcrumb-link" href="{{ baseUrl('/') }}">Dashboard</a>
                        </li>
                        <li class="breadcrumb-item"><a class="breadcrumb-link"
                                href="{{ baseUrl('/language-proficiency') }}">Language Proficiency</a></li>
                        <li class="breadcrumb-item active" aria-current="page">Add</li>
                    </ol>
                </nav>
                <h1 class="page-title">{{$pageTitle}}</h1>
            </div>

            <div class="col-sm-auto">
                <a class="btn btn-primary" href="{{baseUrl('language-proficiency')}}">
                    <i class="tio mr-1"></i> Back
                </a>
            </div>
        </div>
        <!-- End Row -->
    </div>
    <!-- End Page Header -->

    <!-- Card -->
    <div class="card">

        <div class="card-body">
            <form id="languages-form" class="js-validate" action="{{ baseUrl('/language-proficiency/save') }}"
                method="post">

                @csrf
                <!-- Input Group -->
                <div class="js-form-message form-group row">
                    <label class="col-sm-2 col-form-label">Language Proficiency</label>
                    <div class="col-sm-10">
                        <input type="text" name="name" id="name" placeholder="Enter Language Proficiency" class="form-control">
                    </div>
                </div>
                <div class="js-form-message form-group row">
                    <label class="col-sm-2 col-form-label">Official Language</label>
                    <div class="col-sm-10">
                        <select name="official_language">
                          <option value="">Select Language</option>
                          @foreach($official_languages as $language)
                          <option value="{{$language->unique_id}}">{{$language->name}}</option>
                          @endforeach
                        </select>
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-8">
                        <div class="js-add-field" data-hs-add-field-options='{
                              "template": "#addOptionsTemplate",
                              "container": "#addOptionsContainer",
                              "defaultCreated": 1
                            }'>
                            <!-- Title -->
                            <div class="bg-light border-bottom p-2 mb-3">
                                <div class="row">
                                    <div class="col-sm-2">
                                        <h6 class="card-title text-cap">CLB Level</h6>
                                    </div>
                                    <div class="col-sm-2">
                                        <h6 class="card-title text-cap">Reading</h6>
                                    </div>
                                    <div class="col-sm-2">
                                        <h6 class="card-title text-cap">Writing</h6>
                                    </div>
                                    <div class="col-sm-2">
                                        <h6 class="card-title text-cap">Listening</h6>
                                    </div>

                                    <div class="col-sm-2">
                                        <h6 class="card-title text-cap">Speaking</h6>
                                    </div>
                                </div>
                            </div>
                            <div class="js-form-message form-group">
                                <!-- Container For Input Field -->
                                <div id="addOptionsContainer"></div>

                                <a href="javascript:;"
                                    class="js-create-field form-link btn btn-sm btn-no-focus btn-ghost-primary">
                                    <i class="tio-add"></i> Add item
                                </a>

                                <!-- Add Phone Input Field -->
                                <div id="addOptionsTemplate" class="item-row" style="display: none;">
                                    <!-- Content -->
                                    <div class="input-group-add-field">
                                        <?php
                                          $index = randomNumber(4);
                                        ?>
                                        <div class="row">
                                            <div class="col-md-2 js-form-message">
                                                <input type="number" class="form-control mb-3 clb_level" required
                                                    placeholder="CLB Level" aria-label="CLB Level">
                                            </div>
                                            <div class="col-md-2 js-form-message">
                                                <input type="number" class="form-control mb-3 reading" required
                                                    placeholder="Reading" aria-label="Readimg">
                                            </div>
                                            <div class="col-md-2 js-form-message">
                                                <input type="number" class="form-control mb-3 writing" required
                                                    placeholder="Writing" aria-label="Writing">
                                            </div>
                                            <div class="col-md-2 js-form-message">
                                                <input type="number" class="form-control mb-3 listening" required
                                                    placeholder="Listening" aria-label="Listening">
                                            </div>
                                            <div class="col-md-2 js-form-message">
                                                <input type="number" class="form-control mb-3 speaking" required
                                                    placeholder="Speaking" aria-label="Speaking">
                                            </div>
                                        </div>
                                        <!-- End Row -->

                                        <a class="js-delete-field input-group-add-field-delete" href="javascript:;"
                                            data-toggle="tooltip" data-placement="top" title="Remove item">
                                            <i class="tio-clear"></i>
                                        </a>
                                    </div>
                                    <!-- End Content -->
                                </div>
                                <!-- End Add Phone Input Field -->
                            </div>
                            <!-- End Input Group -->
                        </div>
                        <div class="clb_error p-2 mb-2 text-danger"></div>
                    </div>
                    <div class="clearfix"></div>
                </div>
                    <!-- End Input Group -->
                  <div class="form-group">
                      <button class="btn add-btn btn-primary">Add</button>
                  </div>
                </div><!-- End Card body-->
        </div>
        <!-- End Card -->
    </div>
    <!-- End Content -->
    @endsection

    @section('javascript')
    <script src="assets/vendor/hs-add-field/dist/hs-add-field.min.js"></script>
    <script type="text/javascript">
    $(document).ready(function() {
        $('.js-add-field').each(function() {
            new HSAddField($(this), {
                addedField: function() {
                    var index = randomNumber();
                        $("#addOptionsContainer > .item-row:last").find(".clb_level").attr(
                            "name", "clb_level[" + index + "][clb_level]");
                        $("#addOptionsContainer > .item-row:last").find(".clb_level").attr(
                            "required", "true");

                        $("#addOptionsContainer > .item-row:last").find(".reading").attr(
                            "name", "clb_level[" + index + "][reading]");
                        $("#addOptionsContainer > .item-row:last").find(".reading").attr(
                            "required", "true");
                        
                        $("#addOptionsContainer > .item-row:last").find(".writing").attr(
                            "name", "clb_level[" + index + "][writing]");
                        $("#addOptionsContainer > .item-row:last").find(".writing").attr(
                            "required", "true");

                        $("#addOptionsContainer > .item-row:last").find(".listening").attr(
                            "name", "clb_level[" + index + "][listening]");
                        $("#addOptionsContainer > .item-row:last").find(".listening").attr(
                            "required", "true");

                        $("#addOptionsContainer > .item-row:last").find(".speaking").attr(
                            "name", "clb_level[" + index + "][speaking]");
                        $("#addOptionsContainer > .item-row:last").find(".speaking").attr(
                            "required", "true");

                    $('[data-toggle="tooltip"]').tooltip();

                },
                deletedField: function() {
                    $('.tooltip').hide();
                }
            }).init();
        });
        $(".add-btn").click(function(e) {
            e.preventDefault();
            // $(".add-btn").attr("disabled", "disabled");
            // $(".add-btn").find('.fa-spin').remove();
            // $(".add-btn").prepend("<i class='fa fa-spin fa-spinner'></i>");

            var name = $("#name").val();
            var formData = $("#languages-form").serialize();
            $.ajax({
                url: "{{ baseUrl('language-proficiency/save') }}",
                type: "post",
                data: formData,
                dataType: "json",
                beforeSend: function() {
                  showLoader();
                  $(".clb_error").html('');
                },
                success: function(response) {
                    hideLoader();
                    if (response.status == true) {
                        successMessage(response.message);
                        window.location.href = response.redirect_back;
                    } else {
                      if(response.error_type == 'clb_error'){
                       $(".clb_error").html(response.message);
                      }
                      if(response.error_type == 'validation'){
                       validation(response.message);
                      }
                    }
                },
                error: function() {
                  hideLoader();
                }
            });
        });
    });
    </script>

    @endsection