<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\User;
use App\Micropost;

class FavoriteController extends Controller
{
    public function store(Request $request, $id) {
        
        // ->favorite()の処理はUserクラスに記載
        \Auth::user()->favorite($id);
        return redirect()->back();
    }
    
    
    public function destroy($id) {
        
        \Auth::user()->unfavorite($id);
        return redirect()->back();
    }
    
    
    
    
    public function favorites($id) {
        
        $user = User::find($id);
        
        //　->favoritings()の処理はUserモデルで定義している
        $favorites = $user->favoritings()->orderBy('created_at', 'desc')->paginate(10);
        $microposts = $user->microposts()->orderBy('created_at', 'desc')->paginate(10);
        
        
        $data = [
            'user' => $user,
            'microposts' => $microposts,
            'favorites' => $favorites,
            ];
            
            $data += $this->counts($user);
            
            return view('favorite_posts.favoritings', $data);
    }

}
