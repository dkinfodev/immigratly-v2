@foreach($chats as $chat)
    @if($chat->send_by != Auth::user()->role)
        <div class="message-block left-message">
            <div class="row m-0">
                <div class="col-md-2 text-center">
                    <span class="avatar avatar-sm avatar-circle">
                        <img class="avatar-img" src="{{ professionalProfile() }}" alt="Image Description">
                        <div class="sendby">Admin</div>
                    </span>
                </div>
                <div class="col-md-10">
                    @if($chat->type == 'file')
                        @if(file_exists(public_path('uploads/support/'.$chat->file_name)) && $chat->file_name != '')
                            @php 
                                $file_url = asset("public/uploads/support/".$chat->file_name);
                            @endphp
                            <a href="{{$file_url}}" class="d-block" download>
                            <?php 
                                $fileicon = fileIcon($chat->file_name);
                                echo $fileicon;
                            ?>
                            <div class="message-file">{{$chat->file_name}}</div>
                            </a>
                        @endif
                    @else
                        <div class="message-text">{!! $chat->message !!}</div>
                    @endif
                    <div class="message-time text-right">{{dateFormat($chat->created_at)}}</div>
                </div>
            </div>
        </div>
    @else
        <div class="message-block right-message">
            <div class="row m-0">
                <div class="col-md-10">
                    @if($chat->type == 'file')
                        @if(file_exists(public_path('uploads/support/'.$chat->file_name)) && $chat->file_name != '')
                            @php 
                                $file_url = asset("public/uploads/support/".$chat->file_name);
                            @endphp
                            <a href="{{$file_url}}" class="d-block" download>
                            <?php 
                                $fileicon = fileIcon($chat->file_name);
                                echo $fileicon;
                            ?>
                            <div class="message-file text-white">{{$chat->file_name}}</div>
                            </a>
                        @endif
                    @else
                        <div class="message-text">{!! $chat->message !!}</div>
                    @endif
                    <div class="message-time">{{dateFormat($chat->created_at)}}</div>
                </div>
                <div class="col-md-2 text-center">
                    <span class="avatar avatar-sm avatar-circle">
                        <img class="avatar-img" src="{{ professionalProfile() }}" alt="Image Description">
                        <div class="sendby">You</div>
                    </span>
                </div>
            </div>
        </div>
    @endif
@endforeach
