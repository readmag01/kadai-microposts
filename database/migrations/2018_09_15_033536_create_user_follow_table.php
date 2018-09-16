<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateUserFollowTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('user_follow', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('user_id')->unsigned()->index();
            $table->integer('follow_id')->unsigned()->index();
            $table->timestamps();
            
            /*　$table->foreign(このテーブルで外部キーを設定するカラム名)->
            　　references(制約先のID名、この場合制約先はusersテーブルのid名)->on(外部キー制約先のテーブル名、users);
            　　
            　　onDelete('cascade')でデータが削除されたときにこのテーブルのデータ（レコード）も一緒に消す
            　　ここではuserテーブルでユーザデータ（レコード）が削除されたら、これに紐づいたuser_followテーブルの
            　　レコード（フォロー、フォロワー関係）も消すということ　*/

            //user_idにはユーザのid番号が、follow_idにはユーザがフォローしている人のid番号が来る
            
            $table->foreign('user_id')->references('id')->on('users')->onDelete('cascade');
            $table->foreign('follow_id')->references('id')->on('users')->onDelete('cascade');
            
            //user_idとfollow_idが重複しないようにする
            $table->unique(['user_id', 'follow_id']);
            
            
            //mysql側では「show create table user_follow」で内容をチェックできる
            
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('user_follow');
    }
}
