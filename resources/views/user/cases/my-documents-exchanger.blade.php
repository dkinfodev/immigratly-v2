@extends('layouts.master')
@section("style")
<style>
.ui-droppable {
    left: 0px !important;
}
.ui-draggable-dragging {
  z-index: 9999 !important;
}
.del_icon {
    margin-right: 15px;
}
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
}
.document-drop {
    list-style: none;
    padding: 10px 0px;
    border: 0.0625rem solid #e7eaf3;
}
</style>
@endsection

@section('breadcrumb')
<!-- Content -->
<ol class="breadcrumb breadcrumb-no-gutter">
  <li class="breadcrumb-item"><a class="breadcrumb-link" href="{{ baseUrl('/') }}">Dashboard</a></li>
  <li class="breadcrumb-item active" aria-current="page">{{$record['case_title']}}</li>
</ol>
<!-- End Content -->
@endsection

@section('pageheader')
<!-- Content -->
<div class="">
    <div class="content container" style="height: 25rem;">
        <!-- Page Header -->
        <div class="page-header page-header-light page-header-reset">
            <div class="row align-items-center">
                <div class="col">
                  <h1 class="page-title">{{$pageTitle}}<small class="text-danger"> (Drag and move the files between folders)</small></h1>
                  <div class="text-dark">{{$record['case_title']}}</div>
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
<!-- Content -->
<div class="documents-list">
  
  <!-- Card -->
  <?php
    $default_documents = $service['Documents']
  ?>
  <div class="row d-flex flex-row1">
    <div class="col-md-6 col-sm-12 col-lg-6">
        <div class="card mb-3">
          <div class="card-header bg-primary">
              <h3 class="card-title text-white">My Documents</h3>
          </div>
        </div>
        @foreach($user_folders as $key => $document)
        <div class="card mb-3 documents extra" data-file="{{$document->unique_id}}" data-type="extra">
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
                   $filesize = file_size($user_file_dir."/".$file->FileDetail->file_name);
                ?>
                 {{$file->FileDetail->original_name}}
              </li>
              @endforeach
            </ul>
          </div>
        </div>
      @endforeach
    </div>
    <div class="col-md-6 col-sm-12 col-lg-6">
      <div class="card mb-3">
        <div class="card-header bg-primary">
            <h3 class="card-title text-white">Case Documents</h3>
        </div>
      </div>
      @foreach($default_documents as $key => $document)
      <div class="card mb-3 documents default" data-file="{{$document['unique_id']}}" data-type="default">
        <div class="card-header">
            <h3 class="card-title">{{$document['name']}}</h3>
            <h6 class="card-subtitle text-primary">Default Document</h6>
        </div>
        <div class="card-body">
          <?php
            $files = $document['files'];
          ?>
          <ul class="list-group list-group-lg">
            @foreach($files as $file)
            @if($file['file_detail']['is_shared'] == 1)
            <li data-id="{{ $file['file_detail']['shared_id'] }}" class="list-group-item document-exchange">
            @else
            <li class="list-group-item document-exchange">
            @endif
              <?php 
                 $fileicon = fileIcon($file['file_detail']['original_name']);
                 echo $fileicon;
                 $filesize = file_size($file_dir."/".$file['file_detail']['file_name']);
              ?>
               {{$file['file_detail']['original_name']}}
               
               @if($file["file_detail"]["is_shared"] == 1)
                <a href="javascript:;" class="float-right del_icon text-danger"><i class="tio-delete"></i></a><div class="clearfix"></div>
               @endif
            </li>
            @endforeach
          </ul>
          <ul class="list-group list-group-lg droppable">
          </ul>
        </div>
      </div>
    @endforeach
    @foreach($documents as $key => $document)
      <div class="card mb-3 documents other" data-file="{{$document['unique_id']}}" data-type="other">
        <div class="card-header">
            <h3 class="card-title">{{$document['name']}}</h3>
            <h6 class="card-subtitle text-primary">Other Document</h6>
        </div>
        <div class="card-body">
          <?php
            
            $files = $document['files'];
          ?>
          <ul class="list-group list-group-lg">
            @foreach($files as $file)
            @if($file['file_detail']['is_shared'] == 1)
            <li data-id="{{ $file['file_detail']['shared_id'] }}" class="list-group-item document-exchange">
            @else
            <li class="list-group-item document-exchange">
            @endif
              <?php 
                 $fileicon = fileIcon($file['file_detail']['original_name']);
                 echo $fileicon;
                 $filesize = file_size($file_dir."/".$file['file_detail']['file_name']);
              ?>
               {{$file['file_detail']['original_name']}}
               @if($file["file_detail"]["is_shared"] == 1)
                <a href="javascript:;" class="float-right del_icon text-danger"><i class="tio-delete"></i></a><div class="clearfix"></div>
               @endif
            </li>
            @endforeach
          </ul>
          <ul class="list-group list-group-lg droppable">
          </ul>
        </div>
      </div>
    @endforeach
    @foreach($case_folders as $key => $document)
      <div class="card mb-3 documents extra" data-file="{{$document['unique_id']}}" data-type="extra">
        <div class="card-header">
            <h3 class="card-title">{{$document['name']}}</h3>
            <h6 class="card-subtitle text-primary">Extra Document</h6>
        </div>
        <div class="card-body">
          <?php
            $files = $document['files'];
          ?>
          <ul class="list-group list-group-lg">
            @foreach($files as $file)
            @if($file['file_detail']['is_shared'] == 1)
            <li data-id="{{ $file['file_detail']['shared_id'] }}" class="list-group-item document-exchange">
            @else
            <li class="list-group-item document-exchange">
            @endif
              <?php 
                 $fileicon = fileIcon($file['file_detail']['original_name']);
                 echo $fileicon;
                 $filesize = file_size($file_dir."/".$file['file_detail']['file_name']);
              ?>
               {{$file['file_detail']['original_name']}}
               @if($file["file_detail"]["is_shared"] == 1)
                <a href="javascript:;" class="float-right del_icon text-danger"><i class="tio-delete"></i></a><div class="clearfix"></div>
               @endif
            </li>
            @endforeach
          </ul>
          <ul class="list-group list-group-lg droppable">
          </ul>
        </div>
      </div>
    @endforeach
    </div>
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
  $(".del_icon").click(function(){
    removeFile($(this));
  });
  $('.draggable').draggable({
      revert: true,
      revertDuration: 0,
      stack: ".draggable",
      refreshPositions: false,
      helper: 'clone'
  });
  $('.droppable').droppable({
      accept: ".draggable",
      activeClass: "ui-state-highlight",
      drop: function( event, ui ) {
          var droppable = $(this);
          var draggable = ui.draggable;
          var clone = draggable.clone();   
          var parent = draggable.parents(".documents").data("type");
          var id = draggable.attr("data-id");
          var folder_id = $(this).parents(".documents").data("file");
          var document_type = $(this).parents(".documents").data("type");
          var is_exists = false;
          $("."+document_type+"[data-file="+folder_id+"] li[data-id]").each(function(){
              var did = $(this).data("id");
              if(did == id){
                is_exists = true;
              }
          });
          if(is_exists == true){
            errorMessage("File already added");
            return false;
          }
          
          $(this).append(clone);

          clone.css({top: '5px', left: '5px'});
          $("."+document_type+" li[data-id='"+id+"']").addClass("draggable");
          $("."+document_type+" li[data-id='"+id+"'] .del_icon").remove();
          var del_icon = '<a href="javascript:;" class="float-right del_icon text-danger"><i class="tio-delete"></i></a><div class="clearfix"></div>';
          $("."+document_type+" li[data-id='"+id+"']").append(del_icon);
          $(".del_icon").click(function(){
             removeFile($(this));
          });
          // $('.'+document_type+' .draggable').draggable({
          //     revert: true,
          //     revertDuration: 0,
          //     stack: ".draggable",
          //     refreshPositions: false
          //       //helper: 'clone'
          // });
          var files = [];
          $("."+document_type+"[data-file="+folder_id+"] li[data-id]").each(function(){
              files.push($(this).data("id"));
          });
          $.ajax({
             type: "POST",
             url: BASEURL + '/cases/my-documents-exchanger',
             data:{
                 _token:csrf_token,
                 files:files,
                 document_type:document_type,
                 folder_id:folder_id,
                 subdomain:"{{ $subdomain }}",
                 case_id:"{{ $record['unique_id'] }}"
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
  
   // $('.js-hs-action').each(function () {
   //  var unfold = new HSUnfold($(this)).init();
   // });
   if($(".row-checkbox:checked").length > 0){
      $("#datatableCounterInfo").show();
   }else{
      $("#datatableCounterInfo").hide();
   }
});
function removeFile(e){
  var cls = $(e).attr("class");

  var document_type = $(e).parents(".documents").attr("data-type");
  var folder_id = $(e).parents(".documents").attr("data-file");
  var id = $(e).parent("li").attr("data-id");
  
  if(id == undefined || folder_id == undefined || document_type == undefined){
      errorMessage("Issue while removing file!");
      return false;
  }
  $.ajax({
     type: "POST",
     url: BASEURL + '/cases/remove-case-document',
     data:{
         _token:csrf_token,
         file_id:id,
         document_type:document_type,
         folder_id:folder_id,
         subdomain:"{{ $subdomain }}",
         case_id:"{{ $record['unique_id'] }}"
     },
     dataType:'json',
     beforeSend:function(){
         showLoader();
     },
     success: function (data) {
         hideLoader();
         if(data.status == true){
            $(e).parent("li").remove();
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
</script>
@endsection