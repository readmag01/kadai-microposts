<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class UserFollowController extends Controller
{
    public function store(Request $request, $id) {
        
        //　->follow($id)で、Userモデル（クラス）で定義したpublic function follow()が行われる
        \Auth::user()->follow($id);
        return redirect()->back();
    }
    
    
    public function destroy($id) {
        
        //　->unfollow($id)で、Userモデル（クラス）で定義したpublic function unfollow()が行われる
        \Auth::user()->unfollow($id);
        return redirect()->back();
    }
}
