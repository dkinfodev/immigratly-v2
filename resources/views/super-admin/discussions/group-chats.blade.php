@foreach($comments as $comment)
<!-- Step Item -->
<li class="step-item">
  <div class="step-content-wrapper">
    <small class="step-divider">{{ dateFormat($comment->created_at) }}</small>
  </div>
</li>
<!-- End Step Item -->

<!-- Step Item -->
<li class="step-item">
  <div class="step-content-wrapper">
    <div class="step-avatar">
      @if($comment->user_type == 'user')
      <img class="step-avatar-img" src="{{ userProfile($comment->send_by,'m') }}" alt="Image Description">
      @elseif($comment->user_type == 'super_admin')
      <img class="step-avatar-img" src="{{ userProfile($comment->send_by,'m') }}" alt="Image Description">
      @else
      <img class="step-avatar-img" src="{{ userProfile($comment->send_by,'m') }}" alt="Image Description">
      @endif
    </div>

    <div class="step-content">
      <h5 class="mb-1">
        <a class="text-dark" href="javascript:;">{{$comment->User->first_name." ".$comment->User->last_name}}</a>
      </h5>
      @if($comment->message != '')
      <p class="font-size-sm">{{$comment->message}}</p>
      @endif
      @if($comment->file_name != '')
      <ul class="list-group">
        <!-- List Item -->
        @if(file_exists(public_path('uploads/files/'.$comment->file_name)) && $comment->file_name != '')
        <li class="list-group-item list-group-item-light">
          <a href="{{url('public/uploads/files/'.$comment->file_name)}}" download>
          <div class="row gx-1">
            <div class="col">
              <div class="media">
                <span class="mt-1 mr-2">
                  <!-- <img class="avatar avatar-xs" src="./assets/svg/brands/excel.svg" alt="Image Description"> -->
                  <?php 
                      $fileicon = fileIcon($comment->file_name);
                      echo $fileicon;
                      $file_dir = public_path('uploads/files/'.$comment->file_name);
                      $filesize = file_size($file_dir);
                  ?>
                </span>
                <div class="media-body text-truncate">
                  <span class="d-block font-size-sm text-dark text-truncate js-nav-tooltip-link" data-toggle="tooltip" data-placement="left" title="{{$comment->file_name}}">{{$comment->file_name}}</span>
                  <small class="d-block text-muted">{{$filesize}}</small>
                </div>
              </div>
            </div>
          </div>
          </a>
        </li>
        @endif
        <!-- End List Item -->
      </ul>
      @endif
    </div>
  </div>
</li>
<!-- End Step Item -->
@endforeach
<script type="text/javascript">
$(document).ready(function(){
  $('.js-nav-tooltip-link').tooltip({ boundary: 'window' })

})
</script>