@foreach($chats as $chat)
@if($chat['created_by'] != Auth::user()->unique_id)
<?php 
$user = docChatSendBy($chat['send_by'],$chat['created_by'],$subdomain);
?>
<li class="message left appeared">
   <span class="avatar avatar-sm avatar-circle">
     <img class="avatar-img" src="assets/img/160x160/img5.jpg" alt="Image Description">
   </span>
   <div class="text_wrapper">
      <div class="send-date"><small>{{dateFormat($chat['created_at'],"F d, Y H:i:s a")}}</small></div>
      @if($chat['type'] == 'text')
      <div class="text">
         <div class="text-msg">{{$chat['message']}}</div>
         <div class="clearfix"></div>
         <div class="text-right">
            <small><b>-{{$user->first_name." ".$user->last_name}} ({{$chat['send_by']}})</b></small>
         </div> 
      </div>
      @else
      <div class="text file-msg">
         <div class="send-date"><small>{{dateFormat($chat['created_at'],"F d, Y H:i:s a")}}</small></div>
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
         <div class="clearfix"></div>
         <div class="text-right">
            <small><b>-{{$user->first_name." ".$user->last_name}} ({{$chat['send_by']}})</b></small>
         </div>
      </div>
      @endif
   </div>
</li>
@else
<li class="message right appeared">
   <span class="avatar avatar-circle">
     <img class="avatar-img" src="{{ userProfile(Auth::user()->unique_id,'t') }}" alt="Image Description">
   </span>
   <div class="text_wrapper">

      @if($chat['type'] == 'text')
      <div class="text">
         <div class="send-date"><small>{{dateFormat($chat['created_at'],"F d, Y H:i:s a")}}</div>
         <div class="text-msg">{{$chat['message']}}</div>
         <div class="clearfix"></div>
         <div class="text-right"><b>-You</b></div>
      </div>
      @else
      <div class="text file-msg">
         <div class="text-right"><small>{{dateFormat($chat['created_at'],"F d, Y H:i:s a")}}</small></div>
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
         <div class="clearfix"></div>
         <div class="text-right"><small><b>-You</b></small></div>
      </div>
      @endif
   </div>
</li>
@endif
@endforeach