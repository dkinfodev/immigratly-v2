@foreach($notes as $note)
@if($note->created_by != Auth::user()->unique_id)
<?php 
if($note->send_by != 'client'){
   $user = docChatSendBy($note->send_by,$note->created_by,$subdomain);
}else{
   $user = docChatSendBy($note->send_by,$note->created_by);   
}
?>
<li class="message left appeared">
   <span class="avatar avatar-sm avatar-circle">
     @if($note->send_by != 'client')
      <img class="avatar-img" src="{{ professionalProfile($note->created_by,'t',$subdomain) }}" alt="Image Description">
     @else
     <img class="avatar-img" src="{{ userProfile($note->created_by,'t') }}" alt="Image Description">
     @endif

   </span>
   <div class="text_wrapper">
      <div class="text-left"><b>{{dateFormat($note->created_at,"F d, Y H:i:s a")}}</div>
      @if($note->type == 'text')
      <div class="text">
         <div class="text-msg">{{$note->message}}</div>
         <div class="clearfix"></div>
         <div class="text-right">
            <small><b>-{{$user->first_name." ".$user->last_name}} ({{$note->send_by}})</b></small>
         </div>
      </div>
      @else
      <div class="text file-msg">
         <div class="text-left"><b>{{dateFormat($note->created_at,"F d, Y H:i:s a")}}</div>
         <?php
            $file_url = userDirUrl($user_id)."/assessments/".$assessment_id."/".$note->file_name;
         ?>
         <a href="{{$file_url}}" download>
         <?php 
            $fileicon = fileIcon($note->message);
            echo $fileicon;
         ?>
         <div class="text-msg">{{$note->message}}</div>
         </a>
         <div class="clearfix"></div>
         <div class="text-right">
            <small><b>-{{$user->first_name." ".$user->last_name}} ({{$note->send_by}})</b></small>
         </div>
      </div>
      @endif
   </div>
</li>
@else
<li class="message right appeared">
   <span class="avatar avatar-circle">
     @if($note->send_by != 'client')
      <img class="avatar-img" src="{{ professionalProfile($note->created_by,'t',$subdomain) }}" alt="Image Description">
     @else
     <img class="avatar-img" src="{{ userProfile($note->created_by,'t') }}" alt="Image Description">
     @endif
   </span>
   <div class="text_wrapper">
      @if($note->type == 'text')
      <div class="text">
         <div class="send-date"><small>{{dateFormat($note->created_at,"F d, Y H:i:s a")}}</small></div>
         <div class="text-msg">{{$note->message}}</div>
         @if($note->created_by == Auth::user()->unique_id)
         <div class="text-right"><small><b>-You</b></small></div>
         @else
         <div class="text-right">
            <small><b>-{{$user->first_name." ".$user->last_name}} ({{$note->send_by}})</b></small>
         </div>
         @endif
      </div>
      @else
      <div class="text file-msg">
         <div class="send-date"><small>{{dateFormat($note->created_at,"F d, Y H:i:s a")}}</small></div>
         <?php
            $file_url = userDirUrl($user_id)."/assessments/".$assessment_id."/".$note->file_name;
         ?>
         <a href="{{$file_url}}" download>
         <?php 
            $fileicon = fileIcon($note->message);
            echo $fileicon;
         ?>
         <div class="text-msg">{{$note->message}}</div>
         </a>
         <div class="clearfix"></div>
         <div class="text-right"><small><b>-You</b></small></div>
      </div>
      @endif
   </div>
</li>
@endif
@endforeach