@extends('layouts.master')

@section('breadcrumb')
<!-- Content -->
<ol class="breadcrumb breadcrumb-no-gutter">
  <li class="breadcrumb-item"><a class="breadcrumb-link" href="{{ baseUrl('/') }}">Dashboard</a></li>
   <li class="breadcrumb-item"><a class="breadcrumb-link" href="{{ baseUrl('/language-proficiency') }}">Language Proficiency</a></li>
  <li class="breadcrumb-item active" aria-current="page">{{$pageTitle}} </li>

</ol>
<!-- End Content -->
@endsection


@section('header-right')
    <a class="btn btn-primary" href="{{baseUrl('language-proficiency/')}}">
          <i class="tio mr-1"></i> Back 
        </a>
@endsection



@section('content')
<style>
.input-group-add-field-delete {
    right: 103px !important;
}
</style>
<!-- Content -->
<div class="language_proficiency">
  
  <!-- Card -->
  <div class="card">

    <div class="card-body">
      <form id="languages-form" class="js-validate" action="{{ baseUrl('/language-proficiency/update/'.base64_encode($record->id)) }}" method="post">

        @csrf
        <!-- Input Group -->
        <div class="js-form-message form-group row">
          <label class="col-sm-2 col-form-label">Language Proficiency</label>
          <div class="col-sm-10">
            <input type="text" name="name" id="name" placeholder="Enter Language Proficiency" class="form-control" value="{{$record->name}}">
          </div>
        </div>
        <div class="js-form-message form-group row">
            <label class="col-sm-2 col-form-label">Official Language</label>
            <div class="col-sm-10">
                <select name="official_language">
                  <option value="">Select Language</option>
                  @foreach($official_languages as $language)
                  <option {{($language->unique_id == $record->official_language)?'selected':''}} value="{{$language->unique_id}}">{{$language->name}}</option>
                  @endforeach
                </select>
            </div>
        </div>
        <div class="row">
            <div class="col-md-8">
                <div class="js-add-field" data-hs-add-field-options='{
                      "template": "#addOptionsTemplate",
                      "container": "#addOptionsContainer",
                      "limit":15,
                      "defaultCreated": 0
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
                        <div id="addOptionsContainer">
                            @foreach($record->ScoreCharts as $level)
                              <div class="ui-state-default item-row">
                                <div class="input-group-add-field">
                                    <?php
                                      $index = randomNumber(4);
                                    ?>
                                    <div class="row">
                                        <div class="col-md-2 js-form-message">
                                            <input type="hidden" class="form-control mb-3 sort_order" name="clb_level[{{$index}}][sort_order]" value="{{ $level->sort_order }}" required>
                                            <input type="text" step="0.01" name="clb_level[{{$index}}][clb_level]" class="form-control mb-3 clb_level" required
                                                placeholder="CLB Level" aria-label="CLB Level" value="{{ $level->clb_level }}">
                                        </div>
                                        <div class="col-md-2 js-form-message">
                                            <input type="text" step="0.01" name="clb_level[{{$index}}][reading]" class="form-control mb-3 reading" required
                                                placeholder="CLB Level" aria-label="Reading" value="{{ $level->reading }}">
                                        </div>
                                        <div class="col-md-2 js-form-message">
                                            <input type="text" step="0.01" name="clb_level[{{$index}}][writing]" class="form-control mb-3 writing" required
                                                placeholder="CLB Level" aria-label="CLB Level" value="{{ $level->writing }}">
                                        </div>
                                        <div class="col-md-2 js-form-message">
                                            <input type="text" step="0.01" name="clb_level[{{$index}}][listening]" class="form-control mb-3 listening" required
                                                placeholder="CLB Level" aria-label="CLB Level" value="{{ $level->listening }}">
                                        </div>
                                        <div class="col-md-2 js-form-message">
                                            <input type="text" step="0.01" name="clb_level[{{$index}}][speaking]" class="form-control mb-3 speaking" required
                                                placeholder="CLB Level" aria-label="CLB Level" value="{{ $level->speaking }}">
                                        </div>
                                    </div>
                                    <!-- End Row -->

                                    <a class="js-delete-field input-group-add-field-delete ext-delete"
                                        href="javascript:;" data-toggle="tooltip" data-placement="top"
                                        title="Remove item">
                                        <i class="tio-clear"></i>
                                    </a>
                                </div>
                              </div>
                            @endforeach
                        </div>

                        <a href="javascript:;"
                            class="js-create-field form-link btn btn-sm btn-no-focus btn-ghost-primary">
                            <i class="tio-add"></i> Add item
                        </a>

                        <!-- Add Phone Input Field -->
                        <div id="addOptionsTemplate" class="item-row ui-state-default" style="display: none;">
                            <!-- Content -->
                            <div class="input-group-add-field">
                                <?php
                                  $index = randomNumber(4);
                                ?>
                                <div class="row">
                                    <div class="col-md-2 js-form-message">
                                        <input type="hidden" class="form-control mb-3 sort_order" required>
                                        <input type="text" class="form-control mb-3 clb_level" required placeholder="CLB Level" aria-label="CLB Level">
                                    </div>
                                    <div class="col-md-2 js-form-message">
                                        <input type="text" class="form-control mb-3 reading" required
                                            placeholder="Reading" aria-label="Readimg">
                                    </div>
                                    <div class="col-md-2 js-form-message">
                                        <input type="text" class="form-control mb-3 writing" required
                                            placeholder="Writing" aria-label="Writing">
                                    </div>
                                    <div class="col-md-2 js-form-message">
                                        <input type="text" class="form-control mb-3 listening" required
                                            placeholder="Listening" aria-label="Listening">
                                    </div>
                                    <div class="col-md-2 js-form-message">
                                        <input type="text" class="form-control mb-3 speaking" required
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
          <button type="button" class="btn update-btn btn-primary">Update</button>
        </div>
        <!-- End Input Group -->

      </div><!-- End Card body-->
    </div>
    <!-- End Card -->
  </div>
  <!-- End Content -->
  @endsection

  @section('javascript')
  <link rel="stylesheet" href="{{ asset('assets/vendor/sortablejs/css/jquery-ui.css') }}">
  <script src="//code.jquery.com/jquery-1.12.4.js"></script>
  <script src="{{ asset('assets/vendor/sortablejs/js/jquery-ui.js') }}"></script>

  <script src="assets/vendor/hs-add-field/dist/hs-add-field.min.js"></script>
  <script type="text/javascript">
    
    $(document).ready(function(){
      $(".ext-delete").click(function() {
        $(this).parents(".item-row").remove();
        sortOrder();
      });
      initSortable();
      $('.js-add-field').each(function() {
          new HSAddField($(this), {
              addedField: function() {
                  var index = randomNumber();
                  $("#addOptionsContainer > .item-row:last").find(".clb_level").attr(
                      "name", "clb_level[" + index + "][clb_level]");
                  $("#addOptionsContainer > .item-row:last").find(".clb_level").attr(
                      "required", "true");

                  $("#addOptionsContainer > .item-row:last").find(".sort_order").attr(
                      "name", "clb_level[" + index + "][sort_order]");
                  $("#addOptionsContainer > .item-row:last").find(".sort_order").attr(
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
                  initSortable();
                  sortOrder();
              },
              deletedField: function() {
                  $('.tooltip').hide();
                  sortOrder();
              }
          }).init();
      });
      $(".update-btn").click(function(e){
        e.preventDefault(); 
        
        
        var id = $("#rid").val();
        var name = $("#name").val();
        var formData = $("#languages-form").serialize();
        var url = $("#languages-form").attr('action');
        $.ajax({
          url:url,
          type:"post",
          data:formData,
          dataType:"json",
          beforeSend:function(){
            showLoader();
          },
          success:function(response){
            hideLoader();
           if(response.status == true){
            successMessage(response.message);
            window.location.href = response.redirect_back;
           }else{
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
          }
        },
        error:function(){
          hideLoader();
       }
     });
      });
    });
    function initSortable(){
      $( function() {
        $('#addOptionsContainer').sortable({
            start: function(event, ui) {
                var start_pos = ui.item.index();
            },
            change: function(event, ui) {
                var start_pos = ui.item.data('start_pos');
                var index = ui.placeholder.index();
                if (start_pos < index) {
                    $('#sortable li:nth-child(' + index + ')').addClass('highlights');
                } else {
                    $('#sortable li:eq(' + (index + 1) + ')').addClass('highlights');
                }
            },
            update: function(event, ui) {
                // $('#sortable li').removeClass('highlights');
                sortOrder();
            }
        });
      });
    }
    function sortOrder(){
      var index = 1;
      $("#addOptionsContainer .sort_order").each(function(){
        $(this).val(index);
        index++;
      });
    }
  </script>


  @endsection