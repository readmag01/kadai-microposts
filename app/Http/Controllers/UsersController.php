<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\User;
use App\Micropost;

class UsersController extends Controller
{
    
    public function index() {
    
    $users = User::paginate(10);
    
    return view('users.index', [
        'users' => $users,
        ]);
    
    }
    
    
    
    public function show($id) {
        $user = User::find($id);
        
        // ->microposts()の処理はUserモデルで定義している
        $microposts = $user->microposts()->orderBy('created_at', 'desc')->paginate(10);
        
        
        $data = [
            'user' => $user,
            'microposts' => $microposts,
            
            ];
            
        $data += $this->counts($user);
        
        return view('users.show', $data);
    }
    
    
    public function followings($id) {
        
        $user = User::find($id);
        
        // ->followings()の処理はUserモデルで定義している
        $followings = $user->followings()->paginate(10);
        
        /* view側で変数$user、$users（中身は$followings）が使えるようにする
        　連想配列で変数$dateとしてまとめている　*/
        $data = [
            'user' => $user,
            'users' => $followings,
            ];
            
        $data += $this->counts($user);
        
        return view('users.followings', $data);
        
    }
    
    
    public function followers($id) {
        
        $user = User::find($id);
        
        //　->followers()の処理はUserモデルで定義している
        $followers = $user->followers()->paginate(10);
        
        $data = [
            'user' => $user,
            'users' => $followers,
            ];
            
            $data += $this->counts($user);
            
            return view('users.followers', $data);
    }
    
    
    
    
    

    
}
