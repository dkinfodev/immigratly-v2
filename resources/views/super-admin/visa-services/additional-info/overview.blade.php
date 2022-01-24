<div class="modal-dialog modal-xl" role="document">
  <div class="modal-content">
    <div class="modal-header">
      <h5 class="modal-title" id="staticBackdropLabel">Overview</h5>
      <button type="button" class="btn btn-xs btn-icon btn-ghost-secondary" data-dismiss="modal" aria-label="Close">
        <i class="tio-clear tio-lg"></i>
      </button>
    </div>
    <div class="modal-body">
        <div class="additional-block">
            @if(isset($record))
            <form class="form-horizontal" action="{{ baseUrl('/visa-services/additional-information/'.base64_encode($visa_type_id).'/update-visa-block/'.$record->id) }}" id="popup-form" autocomplete="off" method="post" novalidate>
            @else
            <form class="form-horizontal" action="{{ baseUrl('/visa-services/additional-information/'.base64_encode($visa_type_id).'/save-visa-block') }}" id="popup-form" autocomplete="off" method="post" novalidate>
            @endif
                {{ csrf_field() }}
                <input type="hidden" name="visa_type_id" value="{{ $visa_service->unique_id }}">
                <input type="hidden" name="block" value="overview">
                <div class="row">
                    <div class="col-md-12">
                        <div class="form-group {{ ($errors->has('title'))?'error':'' }}">
                            <label>Title</label>
                            <div class="controls">
                                <input type="text" name="title" value="{{ isset($record->title)?$record->title:old('title') }}" class="form-control" data-validation-required-message="This field is required" placeholder="Name">
                                @if ($errors->has('title'))
                                    <span class="help-block">
                                        <strong>{{ $errors->first('title') }}</strong>
                                    </span>
                                @endif
                            </div>
                        </div>
                        <div class="form-group {{ ($errors->has('description'))?'error':'' }}">
                            <label class="mb-1">Description</label>
                            <textarea id="over_desc" name="description">{{ isset($record->description)?$record->description:old('description')  }}</textarea>
                            @if ($errors->has('description'))
                                <span class="help-block">
                                    <strong>{{ $errors->first('description') }}</strong>
                                </span>
                            @endif
                        </div>
                        <div class="form-group {{ ($errors->has('tags'))?'error':'' }}">
                            <label class="mb-1">Tags</label>
                            <?php
                                
                                $exist_tags = array();
                                if(isset($record->additional_data)){
                                    $additional_data = json_decode($record->additional_data,true);
                                    $exist_tags = $additional_data['tags'];
                                }
                            ?>
                            <ul class="list-unstyled mb-0">
                                @foreach($tags as $tag)
                                <li class="d-inline-block mr-2">
                                    <fieldset>
                                        <div class="custom-control custom-checkbox mb-3 float-right">
                                            <input type="checkbox" <?php echo (in_array($tag->id,$exist_tags))?'checked':'' ?> name="tags[]" value="{{$tag->id}}" id="customCheck-{{$tag->id}}" class="custom-control-input">
                                            <label class="custom-control-label" for="customCheck-{{$tag->id}}">{{$tag->name}}</label>
                                        </div>
                                    </fieldset>
                                </li>
                                    @endforeach
                            </ul>
                            
                        </div>
                            <!-- <button type="submit" class="btn btn-primary">Submit</button> -->
                    </div>
                </div>
            </form>
        </div>
    </div>
    <div class="modal-footer">
      <button type="button" class="btn btn-white" data-dismiss="modal">Close</button>
      <button form="popup-form" class="btn btn-primary">Save</button>
    </div>
  </div>
</div>

<script type="text/javascript">
setTimeout(function(){
    var editor = initEditor('over_desc');
},500);

$(document).ready(function(){
    $("#popup-form").submit(function(e){
        e.preventDefault();

        var formData = $("#popup-form").serialize();
        
        var url = $("#popup-form").attr("action");
        $.ajax({
            url:url,
            type:"post",
            data:formData,
            beforeSend:function(){
                showLoader();
            },
            success:function(response){
              hideLoader();
              if(response.status == true){
                successMessage(response.message);
                location.reload();
              }else{
                errorMessage(response.message);
              }
            },
            error:function(){
                hideLoader();
                errorMessage("Something wents wrong");
                // internalServerError();
            }
        });
    });
});
</script>