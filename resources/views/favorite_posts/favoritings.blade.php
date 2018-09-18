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
                
                <!--   <a href="{{ route('users.followings', ['id' => $user->id]) }}">などで
                    ツイート一覧、フォロー一覧、フォロワー一覧ページへ飛ぶ
                    
                    ルーター先やコントローラ先で変数$idが使えるように連想配列で['id' => $user->id]と定義する
                    コントローラのメソッドpublic function followings($id)などで$idを渡す必要があるため-->
                <li role="presentation" class="{{ Request::is('users' . $user->id) ? 'active' : '' }}"><a href="{{ route('users.show', ['id' => $user->id]) }}">TimeLine <span class="badge"> {{ $count_microposts }}</span></a></li>
                <li role="presentation" class="{{ Request::is('users/*/followings') ? 'active' : '' }}"><a href="{{ route('users.followings', ['id' => $user->id]) }}">Followings <span class="badge"> {{ $count_followings }}</span></a></li>
                <li role="presentation" class="{{ Request::is('users/*/followers') ? 'active' : '' }}"><a href="{{ route('users.followers', ['id' => $user->id]) }}"> Followers<span class="badge">{{ $count_followers }}</span></a></li>
                <li role="presentation" class="{{ Request::is('users/*/favoritings') ? 'active' : '' }}"><a href="{{ route('users.favorites', ['id' => $user->id]) }}"> Favorites<span class="badge">{{ $count_favoritings }}</span></a></li>
            </ul>
            
            <ul class="meida-list">
                @foreach($favorites as $favorite)
                <?php $user = $favorite->user; ?>
                <li class="media">
                    <div class="media-left">
                        <img class="media-object img-rounded" src="{{ Gravatar::src($user->email, 50) }}" alt="">
                    </div>
                    <div class="media-body">
                        <div>
                            {!! link_to_route('users.show', $user->name, ['id' => $user->id]) !!} <span class="text-muted"> posted at {{ $favorite->created_at }}</span>
                        </div>
                        <div>
                            <p>{!! nl2br(e($favorite->content)) !!}</p>
                        </div>
                        <div>
                            @include('favorite_posts.favorite_button2',['favorite' => $favorite])
                            
                        </div>
                    </div>
                </li>
                @endforeach
            </ul>
            {!! $microposts->render() !!}
        
        </div>
    </div>
@endsection
    