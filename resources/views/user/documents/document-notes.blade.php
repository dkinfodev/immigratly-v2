@foreach($notes as $chat)

<li class="message right appeared">
   <span class="avatar avatar-circle">
     <img class="avatar-img" src="{{ userProfile($chat->created_by,'t') }}" alt="Image Description">
   </span>
   <div class="text_wrapper">
      @if($chat->type == 'text')
      <div class="text">
         <div class="send-date"><small>{{dateFormat($chat->created_at,"F d, Y H:i:s a")}}</small></div>
         <div class="text-msg">{{$chat->message}}</div>
         <div class="text-right"><small><b>-You</b></small></div>
      </div>
      @else
      <div class="text file-msg">
         <div class="send-date"><small>{{dateFormat($chat->created_at,"F d, Y H:i:s a")}}</small></div>
         
         <?php
            $file_url = userDirUrl()."/documents/".$chat->file_name;
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
@endforeach