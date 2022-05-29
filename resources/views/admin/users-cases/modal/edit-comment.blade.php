<div class="modal-dialog modal-lg" role="document">
    <div class="modal-content">
        <div class="modal-header">
            <div class="imm-modal-slanted-div angled lower-start">
            <div class="row">
                <div class="col-10">
                <h3 class="modal-title" id="exampleModalLongTitle">{{$pageTitle}}</h3>
                </div>
            <div class="col-2" style="text-align:right"> 
                <button type="button" class="btn-close" data-dismiss="modal" aria-label="Close"></button>
                </div>
            </div>
            </div>
        </div>
        <div class="modal-body imm-education-modal-body">
            <form method="post" id="popup-form" class="js-validate" action="{{ baseUrl('/users-cases/edit-comment/'.$record->unique_id) }}">
                @csrf
                <div class="form-group js-form-message">
                    <label class="col-form-label input-label">Comments</label>
                    <div class="col-sm-12">
                        <textarea type="text"
                            class="form-control ckeditor @error('comments') is-invalid @enderror"
                            name="comments" id="description" placeholder="Enter description"
                            aria-label="Enter description"><?php echo $record->comments ?></textarea>
                        @error('name')
                        <span class="invalid-feedback" role="alert">
                            <strong>{{ $message }}</strong>
                        </span>
                        @enderror
                    </div>
                </div>
                <!-- End Form Group -->

            </form>
        </div>
        <div class="modal-footer">
            <button type="button" class="btn btn-white" data-dismiss="modal">Close</button>
            <button form="popup-form" class="btn btn-primary">Save</button>
        </div>
    </div>
</div>
<script type="text/javascript">
initEditor("description");
var dropzone;
$(document).ready(function() {

    $("#popup-form").submit(function(e){
        e.preventDefault();
        var formData = $("#popup-form").serialize();
        var url = $("#popup-form").attr('action');
        $.ajax({
            url: url,
            type: "post",
            data: formData,
            dataType: "json",
            beforeSend: function() {
                showLoader();
            },
            success: function(response) {
                hideLoader();
                if (response.status == true) {
                    successMessage(response.message);
                    closeModal();
                    location.reload();
                } else {
                    validation(respoonse.message);
                    // errorMessage(response.message);
                }
            },
            error: function() {
                internalError();
            }
        });
    });
});

</script>