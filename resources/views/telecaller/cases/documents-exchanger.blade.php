@extends('layouts.master')

@section('breadcrumb')
<!-- Content -->
<ol class="breadcrumb breadcrumb-no-gutter">
  <li class="breadcrumb-item"><a class="breadcrumb-link" href="{{ baseUrl('/') }}">Dashboard</a></li>
  <li class="breadcrumb-item"><a class="breadcrumb-link" href="{{ baseUrl('/cases') }}">Cases</a></li>
  <li class="breadcrumb-item active" aria-current="page">{{$pageTitle}}</li>
</ol>
<!-- End Content -->
@endsection

@section('header-right')
<a href="{{ baseUrl('cases/case-documents/documents/'.base64_encode($record->id)) }}" class="btn btn-primary" href="javascript:;">
         <i class="tio-arrow-large-backward mr-1"></i> Back
        </a>

@endsection

@section("style")
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
}
.document-drop {
    list-style: none;
    padding: 10px 0px;
    border: 0.0625rem solid #e7eaf3;
}
</style>
@endsection
@section('content')
<!-- Content -->
<div class="cases">
  <div class="page-header">
    <div class="row align-items-end">
      <div class="col-sm mb-2 mb-sm-0">
<!--         <nav aria-label="breadcrumb">
          <ol class="breadcrumb breadcrumb-no-gutter">
            <li class="breadcrumb-item"><a class="breadcrumb-link" href="{{ baseUrl('/') }}">Dashboard</a></li>
            <li class="breadcrumb-item"><a class="breadcrumb-link" href="{{ baseUrl('/cases') }}">Cases</a></li>
            <li class="breadcrumb-item active" aria-current="page">{{$pageTitle}}</li>
          </ol>
        </nav>
        <h1 class="page-title">{{$pageTitle}}<small class="text-danger"> (Drag and move the files between folders)</small></h1>
        <div class="text-dark">{{$record->case_title}}</div> -->
      </div>
      <div class="col-sm-auto">
        <a href="{{ baseUrl('cases/case-documents/documents/'.base64_encode($record->id)) }}" class="btn btn-primary" href="javascript:;">
         <i class="tio-arrow-large-backward mr-1"></i> Back
        </a>
      </div>
    </div>
  </div>
  <!-- Card -->
  <?php
    $default_documents = $service->DefaultDocuments($service->service_id);
  ?>
  <div class="row d-flex flex-row1">
    @foreach($default_documents as $key => $document)
      <div class="col-md-4 card mb-3 documents default" data-file="{{$document->unique_id}}" data-type="default">
        <div class="card-header">
            <h3 class="card-title">{{$document->name}}</h3>
            <h6 class="card-subtitle text-primary">Default Document</h6>
        </div>
        <div class="card-body">
          <?php
            $files = $record->caseDocuments($record->id,$document->unique_id);
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
    @foreach($documents as $key => $document)
      <div class="col-md-4 card mb-3 documents other" data-file="{{$document->unique_id}}" data-type="other">
        <div class="card-header">
            <h3 class="card-title">{{$document->name}}</h3>
            <h6 class="card-subtitle text-primary">Other Document</h6>
        </div>
        <div class="card-body">
          <?php
            
            $files = $record->caseDocuments($record->id,$document->unique_id);
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
    @foreach($case_folders as $key => $document)
      <div class="col-md-4 card mb-3 documents extra" data-file="{{$document->unique_id}}" data-type="extra">
        <div class="card-header">
            <h3 class="card-title">{{$document->name}}</h3>
            <h6 class="card-subtitle text-primary">Extra Document</h6>
        </div>
        <div class="card-body">
          <?php
            $files = $record->caseDocuments($record->id,$document->unique_id);
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
          var parent = draggable.parents(".documents").data("type");
          var id = draggable.attr("data-id");
          $("."+parent).find("li[data-id='"+id+"']").remove();
          var document_type = $(this).parents(".documents").data("type");
          var folder_id = $(this).parents(".documents").data("file");
          $(this).append(clone);
          clone.css({top: '5px', left: '5px'});
          $("."+document_type+" li[data-id='"+id+"']").addClass("draggable");
          $('.'+document_type+' .draggable').draggable({
              revert: true,
              revertDuration: 0,
              stack: ".draggable",
              refreshPositions: false
                //helper: 'clone'
          });
          var files = [];
          $("."+document_type+"[data-file="+folder_id+"] li[data-id]").each(function(){
              files.push($(this).data("id"));
          });
          $.ajax({
             type: "POST",
             url: BASEURL + '/cases/case-documents/documents-exchanger',
             data:{
                 _token:csrf_token,
                 files:files,
                 document_type:document_type,
                 folder_id:folder_id,
                 case_id:"{{ $record->unique_id }}"
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