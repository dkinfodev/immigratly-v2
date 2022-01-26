@extends('layouts.master')

@section('breadcrumb')
<!-- Content -->
<ol class="breadcrumb breadcrumb-no-gutter">
  <li class="breadcrumb-item"><a class="breadcrumb-link" href="{{ baseUrl('/') }}">Dashboard</a></li>
  <li class="breadcrumb-item active" aria-current="page">{{$pageTitle}}</li>
</ol>
<!-- End Content -->
@endsection

@section('style')
<link rel="stylesheet" href="assets/css/jquery.mThumbnailScroller.css">
<link rel="stylesheet" href="assets/vendor/jquery-ui/jquery-ui.css">
<style>
.sidebar-detached-content {
    margin-left: 147px;
}
</style>
@endsection


@section('content')
<!-- Content -->
<div class="sidebar-detached-content mt-3 mt-lg-0">
    <!-- Content -->
    <!-- Page Header -->
    <div class="page-header">
        <!-- Nav -->
        <div class="js-nav-scroller hs-nav-scroller-horizontal">
            <span class="hs-nav-scroller-arrow-prev" style="display: none;">
                <a class="hs-nav-scroller-arrow-link" href="javascript:;">
                    <i class="tio-chevron-left"></i>
                </a>
            </span>

            <span class="hs-nav-scroller-arrow-next" style="display: none;">
                <a class="hs-nav-scroller-arrow-link" href="javascript:;">
                    <i class="tio-chevron-right"></i>
                </a>
            </span>

            <ul class="nav nav-tabs page-header-tabs" id="projectsTab" role="tablist">
            <li class="nav-item">
                    <a class="nav-link {{$message_type=='all_messages'?'active':''}}" href="{{ baseUrl('/messages-center') }}">All chats</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link {{$message_type=='general_chats'?'active':''}}" href="{{ baseUrl('messages-center/general-chats') }}">General Chats
                    <span class="badge badge-soft-dark rounded-circle ml-1">{{$unread_general_chat}}</span>
                    </a>
                </li>
                <li class="nav-item">
                    <a class="nav-link {{$message_type=='case_chats'?'active':''}}" href="{{ baseUrl('/messages-center/case-chats') }}">Case chats
                        <span class="badge badge-soft-dark rounded-circle ml-1">{{$unread_case_chat}}</span>
                    </a>
                </li>
                <li class="nav-item">
                    <a class="nav-link {{$message_type=='document_chats'?'active':''}}" href="{{ baseUrl('messages-center/document-chats') }}">Document messages ({{$unread_doc_chat}})</a>
                </li>
            </ul>
        </div>
        <!-- End Nav -->

    </div>
    <!-- End Page Header -->
    <div class="chat-wrapper">
        <div class="col-12 ">


            <div class="row  g-0">
                <div class="col-12 col-lg-5 col-xl-5" style="border-right: 1px solid rgba(231, 234, 243, 0.7);">
                    <div class="chat-search-list">
                        <!-- Input Group -->
                        <div class="input-group">
                            <input type="text" id="search_name" class="form-control" placeholder="Search">

                            <div class="input-group-append">
                                <select onchange="filterChat(this.value)"  class="js-select2-custom custom-select" style="width: 100%;" size="1"
                                    style="opacity: 0;" data-hs-select2-options='{
                                      "minimumResultsForSearch": "Infinity",
                                      "width": "100px"
                                    }'>
                                    <option {{ ($message_type == 'all_messages')?'selected':'' }} value="all_messages">All</option>
                                    <option {{ ($message_type == 'general_chats')?'selected':'' }} value="general_chats">General</option>
                                    <option {{ ($message_type == 'case_chats')?'selected':'' }} value="case_chats">Cases</option>
                                    <option {{ ($message_type == 'document_chats')?'selected':'' }} value="document_chats">Documents</option>
                                </select>
                            </div>


                        </div>
                        <!-- End Input Group -->
                    </div>
                    <div class="chat-list py-8 scrollbar-macosx">
                        <!-- Card -->
                        <?php 
                            $user_names = array();
                        ?>
                        @if($message_type == 'all_messages')
                            @foreach($grouped_messages as $chat)
                                
                            <?php 
                                if($chat->send_by != 'client'){
                                $user = docChatSendBy($chat->send_by,$chat->created_by,$subdomain);
                                }else{
                                $user = docChatSendBy($chat->send_by,$chat->created_by);   
                                }
                                $uname =  $user->first_name." ".$user->last_name;
                                if(!in_array($uname,$user_names)){
                                    $user_names[] = $user->first_name." ".$user->last_name;
                                }
                            ?>
                            <!-- Card -->
                            @if($chat->message_type == "general")
                            <?php 
                                $chat_users = $chat->ChatUsers($chat->chat_client_id,'general');
                            ?>
                            <div class="card  mb-2 chat-general-message" data-name="{{$uname}}">
                            @elseif($chat->message_type == 'case')
                            <?php 
                                $chat_users = $chat->ChatUsers($chat->chat_client_id,'case');
                            ?>
                            <div class="card  mb-2 chat-panel-message" data-name="{{$uname}}">
                            @elseif($chat->message_type == 'document')
                            <?php 
                                $chat_users = $chat->ChatUsers($chat->document_id);
                            ?>
                            <div class="card  mb-2 chat-document-message" data-name="{{$uname}}">
                            @else
                            <?php 
                                $chat_users = array();
                            ?>
                            <div class="card  mb-2 chat-general-message">
                            @endif
                                <div class="card-body">
                                    <div class="row">
                                        <div class="col-auto">
                                            <div class="avatar avatar-circle">
                                                @if($chat->send_by == 'client')
                                                <img class="avatar-img" src="{{ userProfile($chat->created_by,'t',\Session::get('subdomain')) }}" alt="Image Description">
                                                @else
                                                <img class="avatar-img" src="{{ professionalProfile($chat->created_by) }}" alt="Image Description">
                                                @endif
                                            </div>
                                        </div>

                                        <div class="col" style="padding:0"> <span
                                                class="text-muted extra-small ms-2 chat-last-time">{{ dateFormat($chat->created_at,'F d,Y H:i:s') }}</span>
                                            <div class="d-flex align-items-center mb-2">
                                            <a href="{{$chat->href}}">
                                                <h5 class="me-auto mb-0">{{$user->first_name." ".$user->last_name}} ({{$user->role}})</h5>
                                            </a>

                                            </div>

                                            <div class="d-flex align-items-center">
                                                <div class="line-clamp me-auto">
                                                    <?php echo $chat->message ?>
                                                </div>

                                                <!-- <div class="badge badge-circle ms-5" style="color: #fff;border-radius: 50%;">
                                                    <span>3</span>
                                                </div> -->
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="card-footer">
                                    <div class="chat-category">
                                        <div class="chat-category-span"> <img src="assets/img/chat.png" alt="Chat"></div>
                                        @if($chat->message_type == "general")
                                        <div class="chat-category-name">General Chats</div>
                                        @elseif($chat->message_type == 'case')
                                        <div class="chat-category-name">Case Chats</div>
                                        @elseif($chat->message_type == 'document')
                                        <div class="chat-category-name">Document Chats</div>
                                        @else
                                        <div class="card  mb-2 chat-general-message">
                                        <div class="chat-category-name">Other Chats</div>
                                        @endif
                                        
                                    </div>
                                    <div class="row align-items-center">
                                        <!-- <div class="col">
                                            <h6 class="mb-1">Bootstrap Community</h6>
                                        </div> -->

                                        <div class="col-auto">
                                            <!-- Avatar Group -->
                                            <div class="avatar-group avatar-group-sm mb-1">
                                                @foreach($chat_users as $usr)
                                                <?php
                                                if($usr->send_by != 'client'){
                                                    $cuser = docChatSendBy($usr->send_by,$usr->created_by,$subdomain);
                                                }else{
                                                    $cuser = docChatSendBy($usr->send_by,$usr->created_by);   
                                                }
                                                ?>
                                                <span class="avatar avatar-circle">
                                                    <a data-toggle="tooltip" data-placement="top" title="{{ $cuser->first_name.' '.$cuser->last_name }}" href="javascript:;">
                                                    @if($usr->send_by == 'client')
                                                    
                                                    <img class="avatar-img" src="{{ userProfile($usr->created_by,'t',\Session::get('subdomain')) }}" alt="Image Description">
                                                    @else
                                                    <img class="avatar-img" src="{{ professionalProfile($usr->created_by) }}" alt="Image Description">
                                                    @endif
                                                    </a>
                                                </span>
                                                @endforeach
                                            </div>
                                            <!-- End Avatar Group -->
                                        </div>
                                    </div><!-- .row -->
                                </div>
                            </div>
                            <!-- End Card -->
                            @endforeach
                        @endif
                        <!-- End Card -->
                        @if($message_type == 'general_chats')
                        @foreach($grouped_messages as $chat)
                        
                        <?php 
                            $chat_users = $chat->ChatUsers($chat->chat_client_id,'general');
                           
                            if($chat->send_by != 'client'){
                            $user = docChatSendBy($chat->send_by,$chat->created_by,$subdomain);
                            }else{
                            $user = docChatSendBy($chat->send_by,$chat->created_by);   
                            }
                            $uname =  $user->first_name." ".$user->last_name;
                            if(!in_array($uname,$user_names)){
                                $user_names[] = $user->first_name." ".$user->last_name;
                            }
                        ?>
                        <!-- Card -->
                        <div class="card  mb-2 chat-general-message" data-name="{{$uname}}">
                            <div class="card-body">
                                <div class="row">
                                    <div class="col-auto">
                                        <div class="avatar avatar-circle">
                                            @if($chat->send_by == 'client')
                                            <img data-toggle="tooltip" data-placement="top" title="{{ $user->first_name.' '.$user->last_name }}" class="avatar-img" src="{{ userProfile($chat->created_by,'t',\Session::get('subdomain')) }}" alt="Image Description">
                                            @else
                                            <img data-toggle="tooltip" data-placement="top" title="{{ $user->first_name.' '.$user->last_name }}" class="avatar-img" src="{{ professionalProfile($chat->created_by) }}" alt="Image Description">
                                            @endif
                                        </div>
                                    </div>

                                    <div class="col" style="padding:0"> <span
                                            class="text-muted extra-small ms-2 chat-last-time">{{ dateFormat($chat->created_at,'F d,Y H:i:s') }}</span>
                                        <div class="d-flex align-items-center mb-2">
                                        <a href="{{ baseUrl('/messages-center/general-chats') }}?client_id={{$chat->chat_client_id}}">
                                            <h5 class="me-auto mb-0">{{$user->first_name." ".$user->last_name}} ({{$user->role}})</h5>
                                        </a>

                                        </div>

                                        <div class="d-flex align-items-center">
                                            <div class="line-clamp me-auto">
                                                <?php echo $chat->message ?>
                                            </div>

                                            <!-- <div class="badge badge-circle ms-5" style="color: #fff;border-radius: 50%;">
                                                <span>3</span>
                                            </div> -->
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="card-footer">
                                <div class="chat-category">
                                    <div class="chat-category-span"> <img src="assets/img/chat.png" alt="Chat"></div>
                                    <div class="chat-category-name">General Chats</div>
                                </div>
                                <div class="row align-items-center">
                                    <!-- <div class="col">
                                        <h6 class="mb-1">Bootstrap Community</h6>
                                    </div> -->

                                    <div class="col-auto">
                                        <!-- Avatar Group -->
                                        
                                        <div class="avatar-group avatar-group-sm mb-1">
                                            @foreach($chat_users as $usr)
                                            <?php
                                            if($usr->send_by != 'client'){
                                                $cuser = docChatSendBy($usr->send_by,$usr->created_by,$subdomain);
                                            }else{
                                                $cuser = docChatSendBy($usr->send_by,$usr->created_by);   
                                            }
                                            ?>
                                            <span class="avatar avatar-circle">
                                                <a data-toggle="tooltip" data-placement="top" title="{{ $cuser->first_name.' '.$cuser->last_name }}" href="javascript:;">
                                                @if($usr->send_by == 'client')
                                                
                                                <img class="avatar-img" src="{{ userProfile($usr->created_by,'t',\Session::get('subdomain')) }}" alt="Image Description">
                                                @else
                                                <img class="avatar-img" src="{{ professionalProfile($usr->created_by) }}" alt="Image Description">
                                                @endif
                                                </a>
                                            </span>
                                            @endforeach
                                            <!-- <span class="avatar avatar-dark avatar-circle">
                                                <span class="avatar-initials">A</span>
                                            </span>
                                            <span class="avatar avatar-circle">
                                                <img class="avatar-img" src="assets/img/160x160/img3.jpg"
                                                    alt="Image Description">
                                            </span>
                                            <span class="avatar avatar-primary avatar-circle chat-avatar-count">
                                                <span class="avatar-initials">2+</span>
                                            </span> -->
                                        </div>
                                        <!-- End Avatar Group -->
                                    </div>
                                </div><!-- .row -->
                            </div>
                        </div>
                        <!-- End Card -->
                        @endforeach
                        @endif

                        @if($message_type == 'case_chats')
                        @foreach($grouped_messages as $chat)
                        <?php 
                            $chat_users = $chat->ChatUsers($chat->chat_client_id,'case');
                            if($chat->send_by != 'client'){
                            $user = docChatSendBy($chat->send_by,$chat->created_by,$subdomain);
                            }else{
                            $user = docChatSendBy($chat->send_by,$chat->created_by);   
                            }
                            $uname =  $user->first_name." ".$user->last_name;
                            if(!in_array($uname,$user_names)){
                                $user_names[] = $user->first_name." ".$user->last_name;
                            }
                        ?>
                        <!-- Card -->
                        <div class="card  mb-2 chat-panel-message" data-name="{{$uname}}">
                            <div class="card-body">
                                <div class="row">
                                    <div class="col-auto">
                                        <div class="avatar avatar-circle">
                                            @if($chat->send_by == 'client')
                                            <img class="avatar-img" src="{{ userProfile($chat->created_by,'t',\Session::get('subdomain')) }}" alt="Image Description">
                                            @else
                                            <img class="avatar-img" src="{{ professionalProfile($chat->created_by) }}" alt="Image Description">
                                            @endif
                                        </div>
                                    </div>

                                    <div class="col" style="padding:0"> <span
                                            class="text-muted extra-small ms-2 chat-last-time">{{ dateFormat($chat->created_at,'F d,Y H:i:s') }}</span>
                                        <div class="d-flex align-items-center mb-2">
                                        <a href="{{ baseUrl('/messages-center/case-chats') }}?case_id={{$chat->case_id}}">
                                            <h5 class="me-auto mb-0">{{$user->first_name." ".$user->last_name}} ({{$user->role}})</h5>
                                        </a>
                                        </div>

                                        <div class="d-flex align-items-center">
                                            <div class="line-clamp me-auto">
                                                <?php echo $chat->message ?>
                                            </div>

                                            <!-- <div class="badge badge-circle ms-5" style="color: #fff;border-radius: 50%;">
                                                <span>3</span>
                                            </div> -->
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="card-footer">
                                <div class="chat-category">
                                    <div class="chat-category-span"> <img src="assets/img/chat.png" alt="Chat"></div>
                                    <div class="chat-category-name">Case Chats ({{$chat->Case->case_title}})</div>
                                </div>
                                <div class="row align-items-center">
                                    <!-- <div class="col">
                                        <h6 class="mb-1">Bootstrap Community</h6>
                                    </div> -->

                                    <div class="col-auto">
                                        <!-- Avatar Group -->
                                        <div class="avatar-group avatar-group-sm mb-1">
                                            @foreach($chat_users as $usr)
                                            <?php
                                            if($usr->send_by != 'client'){
                                                $cuser = docChatSendBy($usr->send_by,$usr->created_by,$subdomain);
                                            }else{
                                                $cuser = docChatSendBy($usr->send_by,$usr->created_by);   
                                            }
                                            ?>
                                            <span class="avatar avatar-circle">
                                                <a data-toggle="tooltip" data-placement="top" title="{{ $cuser->first_name.' '.$cuser->last_name }}" href="javascript:;">
                                                @if($usr->send_by == 'client')
                                                
                                                <img class="avatar-img" src="{{ userProfile($usr->created_by,'t',\Session::get('subdomain')) }}" alt="Image Description">
                                                @else
                                                <img class="avatar-img" src="{{ professionalProfile($usr->created_by) }}" alt="Image Description">
                                                @endif
                                                </a>
                                            </span>
                                            @endforeach
                                            <!-- <span class="avatar avatar-dark avatar-circle">
                                                <span class="avatar-initials">A</span>
                                            </span>
                                            <span class="avatar avatar-circle">
                                                <img class="avatar-img" src="assets/img/160x160/img3.jpg"
                                                    alt="Image Description">
                                            </span>
                                            <span class="avatar avatar-primary avatar-circle chat-avatar-count">
                                                <span class="avatar-initials">2+</span>
                                            </span> -->
                                        </div>
                                        <!-- End Avatar Group -->
                                    </div>
                                </div><!-- .row -->
                            </div>
                        </div>
                        <!-- End Card -->
                        @endforeach
                        @endif
                        <!-- Card -->
                        @if($message_type == 'document_chats')
                        @foreach($grouped_messages as $chat)
                        <?php 
                            $chat_users = $chat->ChatUsers($chat->document_id);
                            if($chat->send_by != 'client'){
                            $user = docChatSendBy($chat->send_by,$chat->created_by,$subdomain);
                            }else{
                            $user = docChatSendBy($chat->send_by,$chat->created_by);   
                            }
                            $uname =  $user->first_name." ".$user->last_name;
                            if(!in_array($uname,$user_names)){
                                $user_names[] = $user->first_name." ".$user->last_name;
                            }
                        ?>
                        <div class="card  mb-2 chat-document-message" data-name="{{$uname}}">
                            <div class="card-body">
                                <div class="row">
                                    <div class="col-auto">
                                            <div class="avatar avatar-circle">
                                                @if($chat->send_by == 'client')
                                                <img class="avatar-img" src="{{ userProfile($chat->created_by,'t',\Session::get('subdomain')) }}" alt="Image Description">
                                                @else
                                                <img class="avatar-img" src="{{ professionalProfile($chat->created_by) }}" alt="Image Description">
                                                @endif
                                            </div>
                                        </div>

                                        <div class="col" style="padding:0"> <span
                                                class="text-muted extra-small ms-2 chat-last-time">{{ dateFormat($chat->created_at,'F d,Y H:i:s') }}</span>
                                            <div class="d-flex align-items-center mb-2">
                                            <a href="{{ baseUrl('/messages-center/document-chats') }}?document_id={{$chat->document_id}}">
                                                <h5 class="me-auto mb-0">{{$user->first_name." ".$user->last_name}} ({{$user->role}})</h5>
                                            </a>
                                            </div>

                                            <div class="d-flex align-items-center">
                                                <div class="line-clamp me-auto">
                                                @if($chat->type == 'file')
                                                <?php
                                                    $file_url = professionalDirUrl($subdomain)."/documents/".$chat->FileDetail->file_name;
                                                ?>
                                                <a href="{{$file_url}}" class="d-flex" download>
                                                <?php 
                                                    $fileicon = fileIcon($chat->FileDetail->original_name);
                                                    echo $fileicon;
                                                ?>
                                                <div class="text-msg text-dark">{{$chat->FileDetail->original_name}}</div>
                                                <div class="text-white d-block">{{$chat->file_message}}</div>
                                                </a>
                                                @else
                                                <p class="message-content">
                                                {{$chat->message}}
                                                </p>
                                                @endif
                                                </div>

                                                <!-- <div class="badge badge-circle ms-5" style="color: #fff;border-radius: 50%;">
                                                    <span>3</span>
                                                </div> -->
                                            </div>
                                        </div>
                                </div>
                            </div>
                            <div class="card-footer">
                                <div class="chat-category">
                                    <div class="chat-category-span"> <img src="assets/img/chat.png" alt="Chat"></div>
                                    <div class="chat-category-name">Case Chats ({{$chat->Case->case_title}})</div>
                                </div>
                                <div class="row align-items-center">


                                    <div class="col">
                                        <h6 class="mb-1">Document Messages</h6>
                                    </div>

                                    <div class="col-auto">
                                        <!-- Avatar Group -->
                                        <div class="avatar-group avatar-group-sm mb-1">
                                            @foreach($chat_users as $usr)
                                                <?php
                                                if($usr->send_by != 'client'){
                                                    $cuser = docChatSendBy($usr->send_by,$usr->created_by,$subdomain);
                                                }else{
                                                    $cuser = docChatSendBy($usr->send_by,$usr->created_by);   
                                                }
                                                ?>
                                                <span class="avatar avatar-circle">
                                                    <a data-toggle="tooltip" data-placement="top" title="{{ $cuser->first_name.' '.$cuser->last_name }}" href="javascript:;">
                                                    @if($usr->send_by == 'client')
                                                    
                                                    <img class="avatar-img" src="{{ userProfile($usr->created_by,'t',\Session::get('subdomain')) }}" alt="Image Description">
                                                    @else
                                                    <img class="avatar-img" src="{{ professionalProfile($usr->created_by) }}" alt="Image Description">
                                                    @endif
                                                    </a>
                                                </span>
                                                @endforeach
                                        </div>
                                        <!-- End Avatar Group -->
                                    </div>
                                </div><!-- .row -->
                            </div>
                        </div>
                        @endforeach
                        @endif
                        <!-- End Card -->
                     

                        <hr class="d-block d-lg-none mt-1 mb-0">
                    </div>
                </div>
                <div class="col-12 col-lg-7 col-xl-7">
                    <div class="py-2 px-4 border-bottom d-none d-lg-block" style="background: #fff;">
                        <div class="d-flex align-items-center py-1">
                            <div class="position-relative">
                                <!-- <img src="assets/img/avatar3.png" class="rounded-circle mr-1" alt="Sharon Lessman" width="40" height="40"> -->
                            </div>
                            <div class="flex-grow-1 pl-3">
                                @if($message_type == 'case_chats')
                                <?php 
                                if(isset($messages[0])){
                                    $pchat_users = $messages[0]->ChatUsers($messages[0]->chat_client_id,'case');
                                    echo "<strong>".$messages[0]->Case->case_title."</strong>";
                                }else{
                                    $pchat_users = array();
                                }
                                ?>
                                
                                @elseif($message_type == 'general_chats')
                                <?php 
                                if(isset($messages[0])){
                                    $pchat_users = $chat->ChatUsers($messages[0]->chat_client_id,'general');
                                }else{
                                    $pchat_users = array();
                                }
                                ?>
                                <strong>General Chats</strong>
                                @elseif($message_type == 'document_chats')
                                <?php 
                                    if(isset($messages[0])){
                                        $pchat_users = $messages[0]->ChatUsers($messages[0]->document_id);
                                    }else{
                                        $pchat_users = array();
                                    }
                                ?>
                                @else
                                <?php
                                    $pchat_users = array();
                                ?>
                                @endif
                                <!-- <div class="text-muted small"><em>Typing...</em></div> -->
                            </div>
                            <div>
                                <!-- Avatar Group -->
                                <div class="avatar-group avatar-group-sm mb-1">
                                @foreach($pchat_users as $usr)
                                    <?php
                                    if($usr->send_by != 'client'){
                                        $cuser = docChatSendBy($usr->send_by,$usr->created_by,$subdomain);
                                    }else{
                                        $cuser = docChatSendBy($usr->send_by,$usr->created_by);   
                                    }
                                    ?>
                                    <span class="avatar avatar-circle">
                                        <a data-toggle="tooltip" data-placement="top" title="{{ $cuser->first_name.' '.$cuser->last_name }}" href="javascript:;">
                                        @if($usr->send_by == 'client')
                                        
                                        <img class="avatar-img" src="{{ userProfile($usr->created_by,'t',\Session::get('subdomain')) }}" alt="Image Description">
                                        @else
                                        <img class="avatar-img" src="{{ professionalProfile($usr->created_by) }}" alt="Image Description">
                                        @endif
                                        </a>
                                    </span>
                                    @endforeach
                                </div>
                                <!-- End Avatar Group -->
                            </div>
                        </div>
                    </div>

                    <div class="position-relative">
                        <div class="chat-messages p-4 scrollbar-light">
                            <div class="chat-main-content">
                                <div class="chat-main-scrolling-container">
                                    <div class="chat-main-sidebar-contents">
                                        <div class="chat-main-sidebar-actions display-flex justify-space-between">
                                            @foreach($messages as $message)
                                            <?php 
                                                if($message->send_by != 'client'){
                                                $user = docChatSendBy($message->send_by,$message->created_by,$subdomain);
                                                }else{
                                                $user = docChatSendBy($message->send_by,$message->created_by);   
                                                }
                                            ?>
                                            @if($message->created_by != \Auth::user()->unique_id)
                                            <div class="message-blue-wrap mb-5 mt-3">
                                                <div class="message-blue w-90">
                                                @if($message->type == 'file')
                                                <?php
                                                    $file_url = professionalDirUrl($subdomain)."/documents/".$message->FileDetail->file_name;
                                                ?>
                                                <a href="{{$file_url}}" class="d-flex" download>
                                                <?php 
                                                    $fileicon = fileIcon($message->FileDetail->original_name);
                                                    echo $fileicon;
                                                ?>
                                                <div class="text-msg text-dark">{{$message->FileDetail->original_name}}</div>
                                                <div class="text-white d-block">{{$message->file_message}}</div>
                                                </a>
                                                @else
                                                <p class="message-content">
                                                {{$message->message}}
                                                </p>
                                                @endif

                                                </div>
                                                <div class="message-timestamp-left">{{$user->first_name." ".$user->last_name}}, {{dateFormat($message->created_at)}}</div>
                                                <span class="avatar avatar-xs avatar-circle">
                                                    @if($message->send_by == 'client')
                                                    <img class="avatar-img" src="{{ userProfile($message->created_by,'t',\Session::get('subdomain')) }}" alt="Image Description">
                                                    @else
                                                    <img class="avatar-img" src="{{ professionalProfile($message->created_by) }}" alt="Image Description">
                                                    @endif
                                                </span>
                                            </div>
                                            @else
                                            <div class="message-orange-wrap  mb-5 mt-3">
                                                <div class="message-orange w-90">
                                                    @if($message->type == 'file')
                                                    <?php
                                                        $file_url = professionalDirUrl($subdomain)."/documents/".$message->FileDetail->file_name;
                                                    ?>
                                                    <a href="{{$file_url}}" class=" text-white" download>
                                                    <?php 
                                                        $fileicon = fileIcon($message->FileDetail->original_name);
                                                        echo $fileicon;
                                                    ?>
                                                    <div class="text-msg text-dark d-block">{{$message->FileDetail->original_name}}</div><br>
                                                    <div class="text-white d-block">{{$message->file_message}}</div>
                                                    </a>
                                                    @else
                                                    <p class="message-content">
                                                    {{$message->message}}
                                                    </p>
                                                    @endif
                                                </div>
                                                <div class="message-timestamp-right">You, {{dateFormat($message->created_at)}}</div>
                                                <span class="avatar avatar-xs avatar-circle">
                                                    @if($message->send_by == 'client')
                                                    <img class="avatar-img" src="{{ userProfile($message->created_by,'t',\Session::get('subdomain')) }}" alt="Image Description">
                                                    @else
                                                    <img class="avatar-img" src="{{ professionalProfile($message->created_by) }}" alt="Image Description">
                                                    @endif
                                                </span>
                                            </div>
                                            @endif
                                            @endforeach
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <!-- End Modal -->
                        </div>
                    </div>
                    @if($message_type !== 'all_messages' && isset($messages[0]))
                    <div class="flex-grow-0 py-3 px-4 border-top" style="background: #fff;">
                        <form id="send_chat_form" method="post">
                            {{csrf_field()}}
                            <div class="input-group">
                                <input type="hidden" id="message_type" name="message_type" class="cht_field" value="{{ $message_type }}">
                                <input type="text" class="form-control cht_field" name="message" placeholder="Type your message">
                                @if($message_type == 'case_chats')
                                <input type="hidden" id="case_id" class="cht_field" name="case_id" value="{{ $messages[0]->case_id }}">
                                <input type="hidden" id="client_id" class="cht_field" name="client_id" value="{{ $messages[0]->chat_client_id }}">
                                @endif
                                @if($message_type == 'general_chats')
                                <input type="hidden" id="client_id" class="cht_field" name="client_id" value="{{ $messages[0]->chat_client_id }}">
                                @endif
                                @if($message_type == 'document_chats')
                                <input type="hidden" id="case_id" class="cht_field" name="case_id" value="{{ $messages[0]->case_id }}">
                                <input type="hidden" id="document_id" class="cht_field" name="document_id" value="{{ $messages[0]->document_id }}">
                                @endif
                                <input type="file" name="attachment" id="attachment" style="display:none" />
                                <button type="button" onclick="sendFile()" class="btn btn-outline-primary ml-2 mr-2"><i class="tio-link"></i></button>
                                <button type="button" onclick="sendChatMessage()" class="btn btn-primary">Send</button>
                            </div>
                            <div class="attached_file badge badge-orange mt-2"></div>
                        </form>
                    </div>
                    @endif

                </div>
            </div>
        </div>


        <!-- End Row -->
    </div>
    <!-- End Content -->
</div>
<!-- End Content -->
@endsection

@section('javascript')
<!-- JS Global Compulsory  -->
<!-- <script src="assets/vendor/jquery/dist/jquery.min.js"></script> -->
              <!-- <script src="assets/vendor/jquery-migrate/dist/jquery-migrate.min.js"></script>
              <script src="assets/vendor/bootstrap/dist/js/bootstrap.bundle.min.js"></script> -->

              <!-- JS Implementing Plugins -->
<script src="assets/vendor/hs-navbar-vertical-aside/hs-navbar-vertical-aside.min.js"></script>
<script src="assets/vendor/hs-unfold/dist/hs-unfold.min.js"></script>
<script src="assets/vendor/hs-form-search/dist/hs-form-search.min.js"></script>
<script src="assets/vendor/hs-mega-menu/dist/hs-mega-menu.min.js"></script>
<script src="assets/vendor/hs-file-attach/dist/hs-file-attach.min.js"></script>
<script src="assets/vendor/select2/dist/js/select2.full.min.js"></script>
<script src="assets/vendor/flatpickr/dist/flatpickr.min.js"></script>
<script src="assets/vendor/hs-quantity-counter/dist/hs-quantity-counter.min.js"></script>
<script src="assets/vendor/hs-add-field/dist/hs-add-field.min.js"></script>
<script src="assets/vendor/hs-sticky-block/dist/hs-sticky-block.min.js"></script>
<script src="assets/vendor/quill/dist/quill.min.js"></script>
<script src="assets/vendor/@yaireo/tagify/dist/tagify.polyfills.min.js"></script>
<script src="assets/vendor/@yaireo/tagify/dist/tagify.min.js"></script>
<script src="assets/vendor/dropzone/dist/min/dropzone.min.js"></script>
<script src="assets/vendor/datatables/media/js/jquery.dataTables.min.js"></script>
<script src="assets/vendor/datatables.net.extensions/select/select.min.js"></script>
<script src="assets/vendor/datatables.net-buttons/js/dataTables.buttons.min.js"></script>
<script src="assets/vendor/datatables.net-buttons/js/buttons.flash.min.js"></script>
<script src="assets/vendor/jszip/dist/jszip.min.js"></script>
<script src="assets/vendor/pdfmake/build/pdfmake.min.js"></script>
<script src="assets/vendor/pdfmake/build/vfs_fonts.js"></script>
<script src="assets/vendor/datatables.net-buttons/js/buttons.html5.min.js"></script>
<script src="assets/vendor/datatables.net-buttons/js/buttons.print.min.js"></script>
<script src="assets/vendor/datatables.net-buttons/js/buttons.colVis.min.js"></script>
<script src="assets/js/jquery.slidereveal.js"></script>
<script src="assets/js/jquery.mThumbnailScroller.js"></script>
<script src="assets/js/jquery.scrollbar.js"></script>
<script src="assets/vendor/jquery-ui/jquery-ui.js"></script>
<script type="text/javascript">
                $(function () {
                  $('[data-toggle="tooltip"]').tooltip()
                });
            jQuery(document).ready(function(){  
                
                jQuery('.scrollbar-light').scrollbar();
                jQuery('.scrollbar-macosx').scrollbar();

                $("#attachment").change(function(){
                    if($(this)[0].files.length > 0){
                        var filename =  $(this)[0].files[0].name;
                        $(".attached_file").html(filename);
                    }else{
                        $(".attached_file").html('');
                    }
                })
            });
            $( function() {
                var availableTags = <?php echo json_encode($user_names); ?>;
                $( "#search_name").autocomplete({
                    source: availableTags,
                    select: function (event, ui) {
                        var value = ui.item.value;
                        $(".chat-list .card").hide();
                        $(".chat-list .card[data-name='"+value+"']").show();
                        
                    }
                });
                $( "#search_name").blur(function(){
                    var value = $(this).val();
                    if(value != ''){
                        $(".chat-list .card").hide();
                        $(".chat-list .card[data-name='"+value+"']").show();
                    }else{
                        $(".chat-list .card").show();
                    }
                })
            });
            function sendChatMessage(){
                var formData = new FormData();
                formData.append("_token", csrf_token);
                $(".cht_field").each(function(){
                    var name = $(this).attr("name");
                    var value = $(this).val();
                    formData.append(name,value);
                });
                if($('#attachment')[0].files[0] != undefined){
                    formData.append('attachment', $('#attachment')[0].files[0]);
                    formData.append("type", 'file');
                }else{
                    formData.append("type", 'text');
                }
                $.ajax({
                    type: "POST",
                    url: "{{ baseUrl('messages-center/save-chat') }}",
                    data:formData,
                    dataType:'json',
                    cache: false,
                    contentType: false,
                    processData: false,
                    beforeSend:function(){
                        hideLoader();
                    },
                    success: function (response) {
                        if(response.status == true){
                            location.reload();
                        }else{
                            errorMessage(response.message);
                        }
                    },
                    error:function(){
                        internalError();
                    }
                });
            }

            function sendFile(){
                $("#attachment").trigger("click");
            }
            $(window).ready(function() {
                $("#send_chat_form").on("keypress", function (event) {
                    var keyPressed = event.keyCode || event.which;
                    if (keyPressed === 13) {
                        event.preventDefault();
                        return false;
                    }
                });
            });
            
            function filterChat(value){
                switch(value){
                    case "all_messages":
                        window.location.href= "{{ baseUrl('/messages-center') }}";
                        break;
                    case "general_chats":
                        window.location.href= "{{ baseUrl('/messages-center/general-chats') }}";
                        break;
                    case "case_chats":
                        window.location.href= "{{ baseUrl('/messages-center/case-chats') }}";
                        break;
                    case "document_chats":
                        window.location.href= "{{ baseUrl('/messages-center/document-chats') }}";
                        break;
                }
            }
            </script>
@endsection