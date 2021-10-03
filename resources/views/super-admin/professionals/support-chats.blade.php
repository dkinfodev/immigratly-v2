@foreach($chats as $chat)
<?php 
if($chat->send_by != 'super_admin'){
   $user = professionalAdmin($chat->subdomain);
}else{
   $user = superAdminInfo($chat->sender_id);   
}
?>
@if($chat->sender_id != Auth::user()->unique_id)

<li class="message left appeared">
   <span class="avatar avatar-sm avatar-circle">
     @if($chat->send_by != 'client')
      <img class="avatar-img" src="{{ professionalProfile($chat->sender_id,'t',$chat->subdomain) }}" alt="Image Description">
     @else
     <img class="avatar-img" src="{{ superAdminProfile($chat->sender_id,'t') }}" alt="Image Description">
     @endif

   </span>
   <div class="text_wrapper">
      <div class="text-left"><b>{{dateFormat($chat->created_at,"F d, Y H:i:s a")}}</div>
      @if($chat->type == 'text')
      <div class="text">
         <div class="text-msg">{{$chat->message}}</div>
         <div class="clearfix"></div>
         <div class="text-right">
            <small><b>-{{$user->first_name." ".$user->last_name}} ({{$chat->send_by}})</b></small>
         </div>
      </div>
      @else
      <div class="text file-msg">
         <div class="text-left"><b>{{dateFormat($chat->created_at,"F d, Y H:i:s a")}}</div>
         <?php
            $file_url = asset("public/uploads/support/".$chat->file_name);
         ?>
         <a href="{{$file_url}}" download>
         <?php 
            $fileicon = fileIcon($chat->message);
            echo $fileicon;
         ?>
         <div class="text-msg">{{$chat->message}}</div>
         </a>
         <div class="clearfix"></div>
         <div class="text-right">
            <small><b>-{{$user->first_name." ".$user->last_name}} ({{$chat->send_by}})</b></small>
         </div>
      </div>
      @endif
   </div>
</li>
@else
<li class="message right appeared">
   <span class="avatar avatar-circle">
     @if($chat->send_by != 'super_admin')
      <img class="avatar-img" src="{{ professionalProfile($chat->sender_id,'t',$chat->subdomain) }}" alt="Image Description">
     @else
     <img class="avatar-img" src="{{ superAdminProfile($chat->sender_id,'t') }}" alt="Image Description">
     @endif
   </span>
   <div class="text_wrapper">
      @if($chat->type == 'text')
      <div class="text">
         <div class="send-date"><small>{{dateFormat($chat->created_at,"F d, Y H:i:s a")}}</small></div>
         <div class="text-msg">{{$chat->message}}</div>
         @if($chat->sender_id == Auth::user()->unique_id)
         <div class="text-right"><small><b>-You</b></small></div>
         @else
         <div class="text-right">
            <small><b>-{{$user->first_name." ".$user->last_name}} ({{$chat->send_by}})</b></small>
         </div>
         @endif
      </div>
      @else
      <div class="text file-msg">
         <div class="send-date"><small>{{dateFormat($chat->created_at,"F d, Y H:i:s a")}}</small></div>
         <?php
            $file_url = asset("public/uploads/support/".$chat->file_name);
         ?>
         <a href="{{$file_url}}" download>
         <?php 
            $fileicon = fileIcon($chat->message);
            echo $fileicon;
         ?>
         <div class="text-msg">{{$chat->message}}</div>
         </a>
         <div class="clearfix"></div>
         <div class="text-right"><small><b>-You</b></small></div>
      </div>
      @endif
   </div>
</li>
@endif
@endforeach