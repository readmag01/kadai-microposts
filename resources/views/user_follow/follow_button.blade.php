<!--ログイン中のidと対象のidが同じではない場合 -->
@if(Auth::id() != $user->id)
    <!--ログイン中のユーザがこのユーザidをフォローしているなら-->
    @if(Auth::user()->is_following($user->id))
    
        <!-- 配列の2つ目に $uesr->id を入れることでdestroyのURLである
            /users/{id}/unfollowの{id} に対象のidが入る　updateやdelete、storeの時によく使われる？-->
        {!! Form::open(['route' => ['user.unfollow', $user->id], 'method' => 'delete']) !!}
            {!! Form::submit('Unfollow', ['class' => 'btn btn-danger btn-block']) !!}
        {!! Form::close() !!}
    <!--ログイン中のユーザがこのユーザidをフォローしていないなら -->
    @else
        {!! Form::open(['route' => ['user.follow', $user->id]]) !!}
            {!! Form::submit('Follow', ['class' => 'btn btn-primary btn-block']) !!}
        {!! Form::close() !!}
    @endif
@endif