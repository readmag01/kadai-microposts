<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Controllers\Controller;

class MicropostsController extends Controller
{
    public function index() {
        
        $data = [];
        if (\Auth::check()) {
            $user = \Auth::user();
            $microposts = $user->microposts()->orderBy('created_at', 'desc')->paginate(10);
            
            
            /* view側で変数$user、$micropostsが使えるようにする
            　連想配列で変数$dateとしてまとめている　*/
            $data = [
                'user' => $user,
                'microposts' => $microposts,
                ];
                
                //Controller.phpのcounts関数
                $data += $this->counts($user);
                
                //第二引数に上記の配列を渡し、viewに変数(上記のデータ)を渡す
                return view('users.show', $data);
        } else {
            return view('welcome');
        } 
                
        }
        
    
    public function store(Request $request) {
        
        $this->validate($request,[
            'content' => 'required|max:191',
            ]);
            
            $request->user()->microposts()->create([
                'content' => $request->content,
                ]);
                
                return redirect()->back();
    }
    
    
    public function destroy($id) {
        
        $micropost = \App\Micropost::find($id);
        
        if(\Auth::id() === $micropost->user_id) {
            $micropost->delete();
            
            return redirect()->back();
        }
    }
    
}
