<?php

//UserモデルはApp名前空間以外ではApp\Userで指定できる
namespace App;

use Illuminate\Notifications\Notifiable;
use Illuminate\Foundation\Auth\User as Authenticatable;

class User extends Authenticatable
{
    use Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name', 'email', 'password',
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password', 'remember_token',
    ];
    
    
    public function microposts() {
        return $this->hasMany(Micropost::class);
    }
    
    //ユーザーA（仮）がフォローしている人たちを指す
    public function followings() {
        
            /*第一引数でフォローの対象（ユーザ達）となるモデルクラスを指定
            　第二引数で中間テーブルを指定
            　第三引数で自分のidと紐づけされたカラム名（user_id）を指定
            　第四引数でフォロー対象（ユーザ達）のidと紐づけされたカラム名（follow_id）を指定*/
        return $this->belongsToMany(User::class, 'user_follow', 'user_id', 'follow_id')->withTimestamps();
    }
    
    //$user->followingsで$userがフォローしている人たちを取得できる
    
    
    
    //ユーザーA（仮）をフォローしている人たちを指す
    public function followers() {
        
            /*第一引数でフォローの対象（ユーザA）のモデルクラスを指定
            　第二引数で中間テーブル
            　第三引数で自分のidと紐づけされたカラム名（follow_id）を指定
            　第四引数で対象（ユーザA）のidと紐づけされたカラム名（follow_id）を指定*/
        return $this->belongsToMany(User::class, 'user_follow', 'follow_id', 'user_id')->withTimestamps();
    }
    
    //$user->followersで$userをフォローしている人たちを取得できる
    
    
    
    
    public function follow($userId){
        
        //$userId　→　対象となるid（相手のid）のこと
        
        //既にフォローしている
        //$thisはユーザ（インスタンス　$user）を指している？
        $exist = $this->is_following($userId);
        
        //自分のidである
        $its_me = $this->id == $userId;
        
        if ($exist || $its_me) {
            return false;
        } else {
            
            
            // atach() 中間テーブルのレコードを保存
            $this->followings()->attach($userId);
            return true;
        }
    }
    
    //フォローを外す
    public function unfollow($userId) {
        
        $exist = $this->is_following($userId);
        $its_me = $this->id == $userId;
        
        // $its_me　に「!」を付けることで反対の意味（自分ではない）にする
        if ($exist && !$its_me) {
            
            //// detach() 中間テーブルのレコードを削除
            $this->followings()->detach($userId);
            return true;
        } else {
            return false;
        }
    }
    
    
    //関数is_following()の処理を定義   
    public function is_following($userId) {
        return $this->followings()->where('follow_id', $userId)->exists();
        
        /*where(A, B) 　A = B
        　$thisがフォローしている人のfollow_id = $userId　
        　where() だけではクエリを作成しただけで、実行されないので実行文exists()が必要*/
    }

}
