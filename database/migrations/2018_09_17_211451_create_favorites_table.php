<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateFavoritesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('favorites', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('user_id')->unsigned()->index();
            $table->integer('micropost_id')->unsigned()->index();
            $table->timestamps();
            
            /*　$table->foreign(このテーブルで外部キーを設定するカラム名)->
            　　references(制約先のID名、この場合制約先はusersとmicropostsテーブルのid名)->on(外部キー制約先のテーブル名、usersとmicroposts);
            　　
            　　onDelete('cascade')でデータが削除されたときにこのテーブルのデータ（レコード）も一緒に消す
            　　ここではテーブルでユーザデータ（レコード）が削除されたら、これに紐づいたfavoritesテーブルの
            　　レコード（フォロー、フォロワー関係）も消すということ　*/

            //user_idにはユーザのid番号が、microposts_idには投稿のid番号が来る
            
            $table->foreign('user_id')->references('id')->on('users')->onDelete('cascade');
            $table->foreign('micropost_id')->references('id')->on('microposts')->onDelete('cascade');
            

            $table->unique(['user_id', 'micropost_id']);
            
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('favorites');
    }
}
