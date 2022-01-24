@foreach($chats as $chat)
<?php 
if($chat->send_by != 'client'){
   $user = docChatSendBy($chat->send_by,$chat->created_by,$subdomain);
}else{
   $user = docChatSendBy($chat->send_by,$chat->created_by);   
}
?>
@if($chat->send_by == 'client')
<li class="justify-content-between mb-4">
  <div class="row m-0">
    <div class="col-md-2">
      <span class="avatar avatar-sm avatar-circle">
         <img class="avatar-img" src="{{ userProfile($chat->created_by,'t',$subdomain) }}" alt="Image Description">
      </span>
    </div>
    <div class="col-md-10">
      <div class="chat-body white p-0 ml-2 z-depth-1">
        <div class="header">
          <div class="float-left">
            <strong class="primary-font">{{$user->first_name." ".$user->last_name}} ({{$user->role}})</strong>
          </div>
          <div class="float-right"><small class="pull-right text-muted"><i class="far fa-clock"></i> {{ dateFormat($chat->created_at,'F d,Y H:i:s') }}</small></div>
          <div class="clearfix"></div>
        </div>
        <hr class="w-100">
        @if($chat->type == 'file')
         <?php
            $file_url = professionalDirUrl($subdomain)."/documents/".$chat->FileDetail->file_name;
         ?>
         <a href="{{$file_url}}" class="d-flex" download>
         <?php 
            $fileicon = fileIcon($chat->message);
            echo $fileicon;
         ?>
         <div class="text-msg">{{$chat->message}}</div>
         </a>
        @else
        <p class="mb-0">
          {{$chat->message}}
        </p>
        @endif
      </div>
    </div>
  </div>
</li>
@else
<li class="justify-content-between mb-4">
  <div class="row m-0">
    <div class="col-md-10">
      <div class="chat-body white p-0 z-depth-1 float-left">
        <div class="header">
          <div class="float-left">
          @if($chat->created_by == \Auth::user()->unique_id)
          <strong class="primary-font">-You</strong>
          @else
          <strong class="primary-font">{{$user->first_name." ".$user->last_name}} ({{$user->role}})</strong>
          @endif
          </div>
          <div class="float-right"><small class="text-muted"><i class="far fa-clock"></i> {{ dateFormat($chat->created_at,'F d,Y H:i:s') }}</small></div>
          <div class="clearfix"></div>
        </div>
        <hr class="w-100">
        @if($chat->type == 'file')
         <?php
            $file_url = professionalDirUrl($subdomain)."/documents/".$chat->FileDetail->file_name;
         ?>
         <a href="{{$file_url}}" class="d-block" download>
           <?php 
              $fileicon = fileIcon($chat->message);
              echo $fileicon;
           ?>
           <div class="text-msg text-dark">{{$chat->message}}</div>
           <div class="text-msg text-dark">{{$chat->file_message}}</div>
         </a>
        @else
        <p class="mb-0">
          {{$chat->message}}
        </p>
        @endif
      </div>
    </div>
    <div class="col-md-2">
      <span class="avatar avatar-sm avatar-circle">
         <img class="avatar-img" width="80" height="80" src="{{ professionalProfile($chat->created_by) }}" alt="Image Description">
      </span>
    </div>
  </div>
</li>
@endif
@endforeach
