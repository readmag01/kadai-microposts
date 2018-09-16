@extends('layouts.app')

@section('content')
    <div class="row">
        <aside class="col-xs-4">
            <div class="panel panel-default">
                <div class="panel-heading">
                    <h3 class="panel-title">{{ $user->name }}</h3>
                </div>
                <div class="panel-body">
                    <img class="media-object img-rounded img-responsive" src="{{ Gravatar::src($user->email, 500) }}" alt="">
                </div>
            </div>
            @include('user_follow.follow_button', ['user' => $user])
        </aside>
        
        <div class="col-xs-8">
            <ul class="nav nav-tabs nav-justified">
                
                <!-- class="{{ Request::is('users/' . $user->id) ? 'active' : '' }}" は
                     /users/{id} という URL の場合には、 class="active" にするコード
                     Bootstrap のタブでは class="active" を付与することでこのタブが今開いている
                     状態だとわかりやすくなる -->
                <li role="presentation" class="{{ Request::is('users/' . $user->id) ? 'achive' : '' }}"><a href="{{ route('users.show', ['id' => $user->id]) }}">Time Line <span class="badge">{{ $count_microposts }}</span></a></li>
                <li role="presentation" class="{{ Request::is('users/*/followings') ? 'active' : '' }}"><a href="{{ route('users.followings', ['id' => $user->id]) }}">Followings <span class="badge">{{ $count_followings }}</span></a></li>
                <li role="presentation" class="{{ Request::is('users/*/followers') ? 'active' : '' }}"><a href="{{ route('users.followers', ['id' => $user->id]) }}">Followers <span class="badge">{{ $count_followers }}</span></a></li>
            </ul>
            
            @if(Auth::id() == $user->id)
                {!! Form::open(['route' => 'microposts.store']) !!}
                    {!! Form::textarea('content', old('content'), ['class' => 'form-control', 'rows' => 2]) !!}
                    {!! Form::submit('Post', ['class' => 'btn btn-primary btn-block']) !!}
                {!! Form::close() !!}
            @endif
            @if (count($microposts) > 0)
                 @include('microposts.microposts', ['microposts' => $microposts])
            @endif
        </div>
    </div>
@endsection