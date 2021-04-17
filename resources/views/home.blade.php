@extends('layouts.app')

@section('content')
<link href="{{ asset('css/home.css') }}" rel="stylesheet">
<div class="container-body">
<div class="row chat-row">
    <div class="col-md-3">
        <div class="users">
            <h5>{{ __('page.users') }}</h5>
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
                                        <span>{{ $user->name }}</span>
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
                <div class="profile-section">
                    <div class="profile-name">
                        {{ __('page.welcome') }} {{ Auth::user()->name }}
                    </div>
                    <div class="profile-phone">
                        <span>
                            {{ App\Models\Profile::where('user_id',Auth::id())->get()[0]->phone }}
                        </span>
                        <i class="fas fa-edit"></i>
                    </div>
                    <div class="profile-about-me">
                        <span>
                            {{ App\Models\Profile::where('user_id',Auth::id())->get()[0]['about-me'] }}
                        </span>
                        <i class="fas fa-edit"></i>
                    </div>
                </div>
                <div class="post-header">
                    
                    <h1>
                        {{ __('page.posts_section') }}
                    </h1>
                    <p>
                        {{ __('page.post_section_content') }}
                    </p>
                    <span style="font-size: 25px">&#8595;</span>
                </div>
                <div class="post-container">
                    @foreach($posts as $post)
                        <div class="post-inner">
                            <div>
                                <i class="fa fa-user" aria-hidden="true"></i>
                                <span style="font-weight: 400">{{ App\Models\User::where('id',$post->user_id)->get()[0]->name }}</span>
                            </div>
                            <div class="post-inner-image">
                                <img src='{{ asset("images/$post->image") }}' alt="" width="400px" height="300">
                            </div>
                            <div class="post-inner-text">
                                {{ $post->content }}
                            </div>
                        </div>
                    @endforeach
                </div>
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