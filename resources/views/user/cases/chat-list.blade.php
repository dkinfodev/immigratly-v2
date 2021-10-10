@foreach($chats as $chat)
<?php 
if($chat['send_by'] != 'client'){
   $user = docChatSendBy($chat['send_by'],$chat['created_by'],$subdomain);
}else{
   $user = docChatSendBy($chat['send_by'],$chat['created_by']);   
}
?>
@if($chat['created_by'] != \Auth::user()->unique_id)
<div class="message-blue-wrap mb-5 mt-3">
    <div class="message-blue">
        @if($chat['type'] == 'file')
         <?php
            $file_url = professionalDirUrl($subdomain)."/documents/".$chat['file_detail']['file_name'];
         ?>
         <a href="{{$file_url}}" class="d-flex" download>
           <?php 
              $fileicon = fileIcon($chat['message']);
              echo $fileicon;
           ?>
           <div class="text-msg text-dark">{{$chat['message']}}</div>
         </a>
        @else
        <p class="mb-0">
          {{$chat['message']}}
        </p>
        @endif

    </div>
    <div class="message-timestamp-left">{{$user->first_name." ".$user->last_name}} ({{$user->role}}), {{ dateFormat($chat['created_at'],'F d,Y H:i:s') }}</div>
    <span class="avatar avatar-xs avatar-circle">
        <img class="avatar-img" src="{{ professionalProfile($chat['created_by'],'t',$subdomain) }}"
            alt="Image Description">
    </span>
</div>

{{--<li class="justify-content-between mb-4">
  <div class="row m-0">
    <div class="col-md-2">
      <span class="avatar avatar-sm avatar-circle">
         <img class="avatar-img" src="{{ professionalProfile($chat['created_by'],'t',$subdomain) }}" alt="Image Description">
      </span>
    </div>
    <div class="col-md-10">
      <div class="chat-body white p-0 ml-2 z-depth-1">
        <div class="header">
          <strong class="primary-font">{{$user->first_name." ".$user->last_name}} ({{$user->role}})</strong>
          <small class="pull-right text-muted"><i class="far fa-clock"></i> {{ dateFormat($chat['created_at'],'F d,Y H:i:s') }}</small>
        </div>
        <hr class="w-100">
        @if($chat['type'] == 'file')
         <?php
            $file_url = professionalDirUrl($subdomain)."/documents/".$chat['file_detail']['file_name'];
         ?>
         <a href="{{$file_url}}" download>
         <?php 
            $fileicon = fileIcon($chat['message']);
            echo $fileicon;
         ?>
         <div class="text-msg">{{$chat['message']}}</div>
         </a>
        @else
        <p class="mb-0">
          {{$chat['message']}}
        </p>
        @endif
      </div>
    </div>
  </div>
</li> --}}
@else
<div class="message-orange-wrap  mb-5 mt-3">
    <div class="message-orange">
    @if($chat['type'] == 'file')
         <?php
            $file_url = professionalDirUrl($subdomain)."/documents/".$chat['file_detail']['file_name'];
         ?>
         <a href="{{$file_url}}" class="d-flex" download>
           <?php 
              $fileicon = fileIcon($chat['message']);
              echo $fileicon;
           ?>
           <div class="text-msg text-dark">{{$chat['message']}}</div>
         </a>
        @else
        <p class="mb-0">
          {{$chat['message']}}
        </p>
        @endif

    </div>
    <div class="message-timestamp-left">You, {{ dateFormat($chat['created_at'],'F d,Y H:i:s') }}</div>
    <span class="avatar avatar-xs avatar-circle">
        <img class="avatar-img" src="assets/img/160x160/img7.jpg"
            alt="Image Description">
    </span>
</div>
{{--<li class="justify-content-between mb-4">
  <div class="row m-0">
    <div class="col-md-10">
      <div class="chat-body white p-0 ml-2 z-depth-1">
        <div class="header">
          <strong class="primary-font">-You</strong>
          <small class="pull-right text-muted"><i class="far fa-clock"></i> {{ dateFormat($chat['created_at'],'F d,Y H:i:s') }}</small>
        </div>
        <hr class="w-100">
        @if($chat['type'] == 'file')
         <?php
            $file_url = professionalDirUrl($subdomain)."/documents/".$chat['file_detail']['file_name'];
         ?>
         <a href="{{$file_url}}" class="d-flex" download>
           <?php 
              $fileicon = fileIcon($chat['message']);
              echo $fileicon;
           ?>
           <div class="text-msg text-dark">{{$chat['message']}}</div>
         </a>
        @else
        <p class="mb-0">
          {{$chat['message']}}
        </p>
        @endif
      </div>
    </div>
    <div class="col-md-2">
      <span class="avatar avatar-sm avatar-circle">
         <img class="avatar-img" src="{{ userProfile() }}" alt="Image Description">
      </span>
    </div>
  </div>
</li>--}}
@endif
@endforeach
