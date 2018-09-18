<!-- 現在ログインしてるユーザーのidとマイクロポストのユーザーidが一致した場合 -->
    <div class='btn-group'>
    @if (Auth::id() == $micropost->user_id)
        {!! Form::open(['route' => ['microposts.destroy', $micropost->id], 'method' => 'delete']) !!}
            {!! Form::submit('Delete', ['class' => 'btn btn-danger btn-xs']) !!}
        {!! Form::close() !!}
                    
    @endif
    </div>