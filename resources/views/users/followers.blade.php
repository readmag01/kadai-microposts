@extends('layouts.app')

@section('content')

    <div class="row">
        <aside class="col-xs-4">
            <div class="panel panel-default">
                <div class="panel panel-heading">
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
                    状態だとわかりやすくなる
                     
                    <a href="{{ route('users.followings', ['id' => $user->id]) }}">などで
                    ツイート一覧、フォロー一覧、フォロワー一覧ページへ飛ぶ
                    
                    ルーター先やコントローラ先で変数$idが使えるように連想配列で['id' => $user->id]と定義する-->
                
                <li role="presentation" class="{{ Request::is('users/' . $user->id) ? 'active' : '' }}"><a href="{{ route('users.show', ['id' => $user->id]) }}">TimeLine <span class="badge">{{ $count_microposts }}</span></a></li>
                <li role="presentation" class="{{ Request::is('users/*/followings') ? 'active' : '' }}"><a href="{{ route('users.followings', ['id' => $user->id]) }}">Followings <span class="badge">{{ $count_followings }}</span></a></li>
                <li role="presentation" class="{{ Request::is('users/*/followers') ? 'active' : '' }}"><a href="{{ route('users.followers', ['id' => $user->id]) }}">Followers <span class="badge">{{ $count_followers }}</span></a></li>
            </ul>
            @include('users.users', ['users' => $users])
        </div>
    </div>
@endsection