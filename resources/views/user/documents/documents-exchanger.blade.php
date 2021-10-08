@extends('layouts.master')
<style>
.all_services li {
    padding: 16px;
    border-bottom: 1px solid #ddd;
}
.sub_services li {
    border-bottom: none;
}
.document-exchange{
  cursor: move;
  padding: 10px 0px;
}
.droppable{
  min-height: 65px;
  padding-bottom:65px;
}
.document-drop {
    list-style: none;
    padding: 10px 0px;
    border: 0.0625rem solid #e7eaf3;
}
</style>
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
                  <div class="col-sm-auto">
                    <a href="{{ baseUrl('documents') }}" class="btn btn-primary" href="javascript:;">
                      <i class="tio-arrow-large-backward mr-1"></i> Back
                    </a>
                  </div>
            </div>
            <!-- End Row -->
        </div>
        <!-- End Page Header -->
    </div>
</div>
@endsection
<!-- End Content -->
@section('content')
<!-- Content -->
<div class="document-exchanger">
  
  <!-- Card -->
  
  <div class="row d-flex flex-row1">
    
    @foreach($user_folders as $key => $document)
      <div class="col-md-4 card mb-3 documents extra" data-file="{{$document->unique_id}}" data-type="extra">
        <div class="card-header">
            <h3 class="card-title">{{$document->name}}</h3>
        </div>
        <div class="card-body">
          <?php
            $files = $document->Files;
          ?>
          <ul class="list-group list-group-lg">
            @foreach($files as $file)
            <li data-id="{{ $file->FileDetail->unique_id }}" class="list-group-item document-exchange draggable">
              <?php 
                 $fileicon = fileIcon($file->FileDetail->original_name);
                 echo $fileicon;
                 $filesize = file_size($file_dir."/".$file->FileDetail->file_name);
              ?>
               {{$file->FileDetail->original_name}}
            </li>
            @endforeach
          </ul>
          <ul class="list-group list-group-lg droppable">
          </ul>
        </div>
      </div>
    @endforeach
  </div>
  <!-- End Card -->
</div>
<!-- End Content -->
@endsection

@section('javascript')
<link rel="stylesheet" href="assets/vendor/jquery-ui/jquery-ui.css">
<script src="assets/vendor/jquery-ui/jquery-ui.js"></script>
<script type="text/javascript">
$(document).ready(function(){
  $('.draggable').draggable({
      revert: true,
      revertDuration: 0,
      stack: ".draggable",
      refreshPositions: false
        //helper: 'clone'
  });
  $('.droppable').droppable({
      accept: ".draggable",
      activeClass: "ui-state-highlight",
      drop: function( event, ui ) {
          var droppable = $(this);
          var draggable = ui.draggable;
          var clone = draggable.clone();   
          var parent = draggable.parents(".documents").data("file");
          var id = draggable.attr("data-id");
          $(".documents[data-file="+parent+"]").find("li[data-id='"+id+"']").remove();
          var folder_id = $(this).parents(".documents").data("file");
          $(this).append(clone);
          clone.css({top: '5px', left: '5px'});
          $(".documents[data-file="+folder_id+"] li[data-id='"+id+"']").addClass("draggable");
          $(".documents[data-file="+folder_id+"] .draggable").draggable({
              revert: true,
              revertDuration: 0,
              stack: ".draggable",
              refreshPositions: false
                //helper: 'clone'
          });
          var files = [];
          $(".documents[data-file="+folder_id+"] li[data-id]").each(function(){
              files.push($(this).data("id"));
          });
          $.ajax({
             type: "POST",
             url: BASEURL + '/documents/documents-exchanger',
             data:{
                 _token:csrf_token,
                 files:files,
                 folder_id:folder_id,
             },
             dataType:'json',
             beforeSend:function(){
                 showLoader();
             },
             success: function (data) {
                 hideLoader();
                 if(data.status == true){
                    bottomMessage(data.message,'success');
                 }else{
                    errorMessage('Issue while file transfer');
                 }
             },
             error:function(){
               internalError();
             }
          });
      }   
  }); 
  
   $('.js-hs-action').each(function () {
    var unfold = new HSUnfold($(this)).init();
   });
   if($(".row-checkbox:checked").length > 0){
      $("#datatableCounterInfo").show();
   }else{
      $("#datatableCounterInfo").hide();
   }
});

</script>
@endsection