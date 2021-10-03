@foreach($comments as $comment)
<li>
  <!-- Media -->
  <div class="media">
    <div class="avatar avatar-circle mr-3">
      @if($comment->user_type == 'user')
      <img class="avatar-img" src="{{ userProfile($comment->send_by,'m') }}" alt="Image Description">
      @else
      <img class="avatar-img" src="assets/frontend/img/100x100/img1.jpg" alt="Image Description">
      @endif
      
    </div>
    <div class="media-body">
      <h5 class="mb-0">{{$comment->User->first_name." ".$comment->User->last_name}}</h5>
      
      <div class="d-flex align-items-center mb-3">
        <small class="d-block">on {{ dateFormat($comment->created_at) }}</small>
      </div>

      <blockquote class="blockquote mb-4">{{$comment->message}}</blockquote>
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
  <!-- End Media -->
</li>
@endforeach
