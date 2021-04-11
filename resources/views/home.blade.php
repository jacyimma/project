@extends('layouts.app')
<style>
    .chat-user-list{
        width:100%;
        padding:10px;
        height:auto;  
    }
   .name-image{
    border-radius: 50%;
    height: 35px;
    display:flex;
    background-color:blue;
    align-items:center;
    justify-content:center;
    width: 35px;
    color:white;
    font-sizze:17px;
    }
    .chat-image,.chat-name{
        display:flex;
        height:40px;
        width:auto;
        align-items:center;
        display:inline-block !important;
    }
    .chat-name{
        position: relative;
    }
    .user-status-icon{
        font-size:5px;
        top:25px;
        left:-7px;
        position: absolute;
    }
    .active{
        color:blue; 
    }
    .disactive{
        color:grey;
    }
</style>
@section('content')
<div class="container">
<div class="row align-items-center">
<div class="col-md-3">
 <div class="users">
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
              <i class="fa fa-circle user-status-icon"></i> 
                {{$user->name}}
              </span>
            </a>
        </div>
        @endforeach
        @endif
    </div>
 </div>
</div>
 <div class="col-md-9">
     <h1>Message section</h1>
     Select user from the list to begin conversation.
 </div>
</div>
</div>
@endsection

@push('scripts')
<script src="/socket.io/socket.io.js"></script>
    <script>
        $(function (){
            let user_id = "{{ auth()->user()->id }}";
            let ip_address = '127.0.0.1';
            let socket_port = '8005';
            let socket = io(ip_address + ':' + socket_port);
            
            socket.on('connect', function() {
               socket.emit('user_connected', user_id);
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
