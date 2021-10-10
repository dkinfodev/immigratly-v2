@foreach($chats as $chat)
@if($chat['created_by'] != Auth::user()->unique_id)
<?php 
$user = docChatSendBy($chat['send_by'],$chat['created_by'],$subdomain);
?>
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

@endif
@endforeach