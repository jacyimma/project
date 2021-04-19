@extends('layouts.app')

@section('content')
<link href="{{ asset('css/conversation.css') }}" rel="stylesheet">
<link href="{{ asset('css/home.css') }}" rel="stylesheet">
<div class="container-body">
<div class="row">
<div class="col-md-3">  
 <div class="users">
 <div class="back-button">
    <a href="{{ route('home') }}">&#8592; Back to posts</a>
 </div>
 <h5>Users</h5>
    <div  class="list-group list-chat-item">
        @if($users->count())
            @foreach($users as $user)
        <div class="chat-user-list ">
            <a href="{{route('message.conversation',$user->id)}}">
            <div class="chat-image">
                {!!makeImageFromName($user->name)!!}  
            </div>
            <span class="chat-name"> 
            <i class="fa fa-circle user-status-icon @if($user->id == $friendInfo->id) active @else disactive  @endif"></i>   
                {{$user->name}}
              </span>
            </a>
        </div>
        @endforeach
        @endif
    </div>
 </div>
</div>
 <div class="col-md-9 chat">
     <div class="chat-header">
     <div class="chat-image">
                {!!makeImageFromName($friendInfo->name)!!}  
     </div>
            <span class="chat-name"> 
                {{$friendInfo->name}} 
              </span>
     </div>
     <div class="chat-body">
     <div class="message-list" id="messageWrapper">
        <div class="row message align-items-center mb-2">
      <div class="col-md-12 user-info">
            <div class="chat-image">
            {!!makeImageFromName($friendInfo->name)!!}
            </div>
            <div class="chat-name font-weight-bold">
            {{$friendInfo->name}} 
            <span class="small time" title="2021-04-08 10:30PM">
                10:30 PM
            </span>
            </div>
      </div>
      <div class="col-12 message-content">
        <div class="message-text">
        Message here
        </div> 
      </div>
     </div>
     </div>
    
    </div>
    <div class="chat-box">
    <div class="chat-input bg-white" id="chatInput" contenteditable="">
    </div>
    <div class="chat-input-toolbar">
        <button title="Add File" class="btn btn-light btn-sm btn-file-upload">
            <i class="fa fa-paperclip"></i>
        </button> |
        <button 
            class="btn btn-light btn-sm tool-items" 
            title="Bold"
            onclick="document.execCommand('bold',false,'');"
        >
        <i class="fa fa-bold tool-icon"></i>
        </button>
        <button class="btn btn-light btn-sm tool-items" 
        title="Italic"  
        onclick="document.execCommand('italic',false,'');"
        >
        <i class="fa fa-italic tool-icon"></i>
        </button>
    </div>
     </div>
 </div>

</div>
</div>

@endsection

@push('scripts')
<script src="https://cdnjs.cloudflare.com/ajax/libs/socket.io/4.0.1/socket.io.js"></script>
    <script>
        $(function (){
            let user_id = "{{ auth()->user()->id }}";
            let ip_address = '127.0.0.1';
            let socket_port = '8005';
            let socket = io(ip_address + ':' + socket_port);
            
            socket.on('connect', function() {
               socket.on('user_connected', function(user_id){
                   console.log(user_id);
               });
            });

            socket.on('updateUserStatus', (data) => {
                let $userStatusIcon = $('.user-status-icon');
                $userStatusIcon.removeClass('text-success');
                $userStatusIcon.attr('title', 'Away');
                $.each(data, function (key, val) {
                   if (val !== null && val !== 0) {
                      let $userIcon = $(".user-icon-"+key);
                      $userIcon.addClass('text-success');
                      $userIcon.attr('title','Online');
                   }
                });
            });
        });
    </script>
@endpush