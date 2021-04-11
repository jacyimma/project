@extends('layouts.app')
<style>
    .list-group{
        /* height:auto;  
        width:100%;
        background:white;
        box-shadow: 0 0 5px rgba(0,0,0,0.2); */
    }
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
        width:auto;
        align-items:center;
        display:inline-block !important;
    }
    .chat-image{
        position: relative;
    }
    .chat-name{
        padding-left:5px;
    }
    .user-status-icon{
        font-size:8px;
        top:29px;
        left:27px;
        position: absolute;
    }
    .active{
        color:blue; 
    }
    .disactive{
        color:grey;
    }
    .chat-header{
        background:white;
        height:50px;
        padding:0px 10px;
        width:100%;
        display: flex;
        align-items:center;
        border:1px solid #f5f5f5;
    }
    .chat-body{
        background:white;
        height:100%;
        width:100%;
        padding: 10px;
        border:1px solid #f5f5f5;
    }
    .time{
        color:gray;
    }
    .message-text{
        margin:-10px 0px 0px 45px;
        padding:8px 10px;
        width:auto;
        max-width:300px;
        border:1px solid #f5f5f5;
        border-bottom-left-radius:15px;
        border-bottom-right-radius:15px;
        border-top-right-radius:15px;
    }
    .chat-input{
        border:1px solid lightgray;
        margin-top:2px;
        padding:8px 10px;
    }
    .chat-input:focus{
        outline:none;
        border:1px solid lightblue;
    }
    .chat-input-toolbar{
        border-bottom:1px solid #dedede;
        border-left:1px solid #dedede;
        border-right:1px solid #dedede;
        background-color:#f8f9fa;
    }
</style>
@section('content')
<div class="container">
<div class="row">
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
                <i class="fa fa-circle user-status-icon @if($user->id == $friendInfo->id) active @else disactive  @endif"></i>   
            </div>
            <span class="chat-name"> 
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
                {!!makeImageFromName($user->name)!!}  
     </div>
            <span class="chat-name"> 
                {{$user->name}}
                <i 
                class="fa fa-circle user-status-head"
                id="userStatushead({{$friendInfo->id}})" 
                title="away"></i>   
              </span>
     </div>
     <div class="chat-body">
     <div class="message-list" id="messageWrapper">
        <div class="row message align-items-center mb-2">
      <div class="col-md-12 user-info">
            <div class="chat-image">
            {!!makeImageFromName('Rimma')!!}
            </div>
            <div class="chat-name font-weight-bold">
            Rimma
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
