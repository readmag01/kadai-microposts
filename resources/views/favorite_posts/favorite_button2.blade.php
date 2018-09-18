<!-- favoritings.blade.phpのファイルにお気に入りボタンを表示させる場合のみこのファイル（favorite_button2.blade.php）を使用
　　　上記以外のページでお気に入りボタンを表示させる際はfavorite_button.blade.phpを使用　-->

<div class='btn-group'>
@if (Auth::user()->is_favoriting($favorite->id))

 <!-- 配列の2つ目に $micropost->id を入れることでdestroyのURLである
            /post/{id}/unfavoriteの{id} に対象のidが入る　updateやdelete、storeの時によく使われる？-->
    {!! Form::open(['route' => ['post.unfavorite', $favorite->id], 'method' => 'delete']) !!}
        {!! Form::submit('Unfavorite', ['class' => 'btn btn-warning btn-xs']) !!}
    {!! Form::close() !!}
    
    
    @else
    
    {!! Form::open(['route' => ['post.favorite', $favorite->id]]) !!}
        {!! Form::submit('Favorite', ['class' => 'btn btn-success btn-xs']) !!}
    {!! Form::close() !!}
    
    @endif
    
</div>