<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateCommentsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('comments', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('user_id'); // 用户id
            $table->string('video_info_id'); // 视频信息id
            $table->string('content'); // 评论内容
            $table->integer('pid'); // 回复的那条评论id 如果为0,则表示回复视频
            $table->integer('favorite'); // 赞数量
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::drop('comments');
    }
}
