@foreach($chats as $chat)
@if($chat->created_by != Auth::user()->unique_id)
<?php 
$subdomain = \Session::get("subdomain");
if($chat->send_by != 'client'){
   $user = docChatSendBy($chat->send_by,$chat->created_by);
}else{
   $user = docChatSendBy($chat->send_by,$chat->created_by,$subdomain);   
}
?>
<div class="message-blue-wrap mb-5 mt-3">
    <div class="message-blue">
        @if($chat->type == 'file')
         <?php
            $file_url = professionalDirUrl($subdomain)."/documents/".$chat->FileDetail->file_name;
         ?>
         <a href="{{$file_url}}" class="d-flex" download>
           <?php 
              $fileicon = fileIcon($chat->message);
              echo $fileicon;
           ?>
           <div class="text-msg text-dark">{{$chat->message}}</div>
         </a>
        @else
        <p class="mb-0">
          {{$chat->message}}
        </p>
        @endif

    </div>
    <div class="message-timestamp-left">{{$user->first_name." ".$user->last_name}} ({{$user->role}}), {{ dateFormat($chat->created_at,'F d,Y H:i:s') }}</div>
    <span class="avatar avatar-xs avatar-circle">
    @if($chat->send_by != 'client')
      <img class="avatar-img" src="{{ professionalProfile($chat->created_by,'t') }}" alt="Image Description">
     @else
     <img class="avatar-img" src="{{ userProfile($chat->created_by,'t') }}" alt="Image Description">
     @endif
        
    </span>
</div>

@else
<div class="message-orange-wrap  mb-5 mt-3">
    <div class="message-orange">
    @if($chat->type == 'file')
         <?php
            $file_url = professionalDirUrl($subdomain)."/documents/".$chat['file_detail']['file_name'];
         ?>
         <a href="{{$file_url}}" class="d-flex" download>
           <?php 
              $fileicon = fileIcon($chat->message);
              echo $fileicon;
           ?>
           <div class="text-msg text-dark">{{$chat->message}}</div>
         </a>
        @else
        <p class="mb-0">
          {{$chat->message}}
        </p>
        @endif

    </div>
    <div class="message-timestamp-left">You, {{ dateFormat($chat->created_at,'F d,Y H:i:s') }}</div>
    <span class="avatar avatar-xs avatar-circle">
        <img class="avatar-img" src="{{ professionalProfile($chat->created_by,'t') }}"
            alt="Image Description">
    </span>
</div>

@endif
@endforeach



{{--
@foreach($chats as $chat)
@if($chat->created_by != Auth::user()->unique_id)
<?php 
if($chat->send_by != 'client'){
   $user = docChatSendBy($chat->send_by,$chat->created_by);
}else{
   $user = docChatSendBy($chat->send_by,$chat->created_by,$subdomain);   
}

?>
<li class="message left appeared">
   <span class="avatar avatar-sm avatar-circle">
     @if($chat->send_by != 'client')
      <img class="avatar-img" src="{{ professionalProfile($chat->created_by,'t') }}" alt="Image Description">
     @else
     <img class="avatar-img" src="{{ userProfile($chat->created_by,'t') }}" alt="Image Description">
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
            $file_url = professionalDirUrl()."/documents/".$chat->FileDetail->file_name;
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
     @if($chat->send_by != 'client')
      <img class="avatar-img" src="{{ professionalProfile($chat->created_by,'t') }}" alt="Image Description">
     @else
     <img class="avatar-img" src="{{ userProfile($chat->created_by,'t') }}" alt="Image Description">
     @endif
   </span>
   <div class="text_wrapper">
      @if($chat->type == 'text')
      <div class="text">
         <div class="send-date"><small>{{dateFormat($chat->created_at,"F d, Y H:i:s a")}}</small></div>
         <div class="text-msg">{{$chat->message}}</div>
         @if($chat->created_by == Auth::user()->unique_id)
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
            $file_url = professionalDirUrl()."/documents/".$chat->FileDetail->file_name;
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
@endforeach --}}