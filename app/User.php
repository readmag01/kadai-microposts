<?php

//UserモデルはApp名前空間以外ではApp\Userで指定できる
namespace App;

use Illuminate\Notifications\Notifiable;
use Illuminate\Foundation\Auth\User as Authenticatable;

use App\Micropost;

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
    
    public function feed_microposts() {
        
        /*  User がフォローしているユーザ達のidの配列を取得する
            pluck('users.id')　usersテーブルのidカラムを抜き出す
            ->toArray()で取得したものを配列に変換*/
        $follow_user_ids = $this->followings()-> pluck('users.id')->toArray();
        
        //自分のidも追加
        $follow_user_ids[] = $this->id;
        
        //micropostsテーブルのuser_idカラムで、$follow_user_idsの中のidを含む場合に、すべて取得してreturnする
        return Micropost::whereIn('user_id', $follow_user_ids);
    }
    
    
    
    
    public function favoritings() {
        
        /*第一引数でfavoriteの対象（ポスト）となるモデルクラスを指定
            　第二引数で中間テーブルを指定
            　第三引数で自分のidと紐づけされたカラム名（user_id）を指定
            　第四引数でお気に入り対象（ポスト）のidと紐づけされたカラム名（follow_id）を指定*/
        return $this->belongsToMany(Micropost::class, 'favorites', 'user_id', 'micropost_id')->withTimestamps();
        
    }
    
    
    
    /*　favoriteやunfavoriteを行う主体は$userなので、$userが属するモデルに
        favoriteやunfavoriteの処理を書く必要がある
        $user->favorite()　$user->unfavorite()など
    */
    
    public function favorite($micropostId) {
        
        $exist = $this->is_favoriting($micropostId);
        
        if($exist) {
            return false;
        } else {
            $this->favoritings()->attach($micropostId);
            return true;
        }
        
    }
    
    
    public function unfavorite($micropostId) {
        
    $exist = $this->is_favoriting($micropostId);
        
    if($exist) {
            $this->favoritings()->detach($micropostId);
            return true;
        } else {
            return false;
        }
    }
    
        
    public function is_favoriting($micropostId) {
            return $this->favoritings()->where('micropost_id', $micropostId)->exists();
        /*where(A, B) 　A = B
        　$thisがお気に入りしている投稿のfollow_id = $micropostId　
        　where() だけではクエリを作成しただけで、実行されないので実行文exists()が必要*/
        
        
    }
    

}
