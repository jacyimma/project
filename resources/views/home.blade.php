@extends('layouts.app')
<style>
   .container-body{
     background:#f0f2f5;
     height:100vh;
     width:90%;
     margin-left:5%;
     border-radius:10px;
     font-family:'SF Pro Text';
    }
    .chat-user-list{
        width:100%;
        padding:10px;
        height:auto;  
    }
    .users{
        padding:10px;
        margin:10px;
        background:#fcfcfc;
        border-radius:10px;
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
    h5{
        font-family:'SF Pro Text';
        font-size:20px;
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
    .fa-circle{
        font-size:7px;
        top:25px;
        left:-7px;
        position: absolute;
        color:grey;
    }
    .active{
        color:blue; 
    }
    .disactive{
        color:grey;
    }
    .chat-select{
        padding:10px;
        height:95%;
        margin:10px;
        background:#fcfcfc;
        border-radius:10px;
    }
    .col-md-9,.col-md-3{
        height:100vh;
    }
    
</style>
@section('content')
<div class="container-body">
<div class="row chat-row">
    <div class="col-md-3">
        <div class="users">
            <h5>Users</h5>
               <div class="list-group list-chat-item">
                    @if($users->count())
                        @foreach($users as $user)
                            <div class="chat-user-list">
                                <a href="{{ route('message.conversation', $user->id) }}">
                                    <div class="chat-image">
                                            {!! makeImageFromName($user->name) !!}            
                                    </div>
                                    <div class="chat-name font-weight-bold">
                                    <i class="fa fa-circle user-status-icon user-icon-{{ $user->id }}" title="away"></i>
                                        {{ $user->name }}
                                    </div>
                                </a>
                            </div>
                        @endforeach
                    @endif
                </div>
            </div>
        </div>
        <div class="col-md-9">
         <div class="chat-select">
         <h1>
                Message Section
            </h1>
            <p>
                Select user from the list to begin conversation.
            </p>
         </div>
        </div>
    </div>
    </div>
@endsection

@push('scripts')
    <script>
        $(function (){
            let user_id = "{{ auth()->user()->id }}";
            let ip_add = '127.0.0.1';
            let socket_port = '8005';
            let socket = io(ip_add + ':' + socket_port);
            socket.on('connect', function() {
               socket.emit('user_connected', user_id);
            });
            socket.on('updateUserStatus', (data) => {
                let $statusShow = $('.user-status-icon');
                $statusShow.removeClass('text-success');
                $statusShow.attr('title', 'Away');
                $.each(data, function (key, val) {
                   if (val !== null && val !== 0) {
                      let $statusIcon = $(".user-icon-"+key);
                      $statusIcon.addClass('text-success');
                      $statusIcon.attr('title','Online');
                   }
                });
            });
        });
    </script>
@endpush