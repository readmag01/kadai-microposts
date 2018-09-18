<!-- favoritings.blade.phpのファイル以外でお気に入りボタンを表示させる場合のみこのファイル（favorite_button.blade.php）を使用
　　　favoritings.blade.phpのページでお気に入りボタンを表示させる際はfavorite_button2.blade.phpを使用
　　　favoritings.blade.phpでは、その元になるFavoriteControllerで$micropostをうまく定義できなかったため　-->

<div class='btn-group'>
@if (Auth::user()->is_favoriting($micropost->id))

 <!-- 配列の2つ目に $micropost->id を入れることでdestroyのURLである
            /post/{id}/unfavoriteの{id} に対象のidが入る　updateやdelete、storeの時によく使われる？-->
    {!! Form::open(['route' => ['post.unfavorite', $micropost->id], 'method' => 'delete']) !!}
        {!! Form::submit('Unfavorite', ['class' => 'btn btn-warning btn-xs']) !!}
    {!! Form::close() !!}
    
    
    @else
    
    {!! Form::open(['route' => ['post.favorite', $micropost->id]]) !!}
        {!! Form::submit('Favorite', ['class' => 'btn btn-success btn-xs']) !!}
    {!! Form::close() !!}
    
    @endif
    
</div>