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
            $table->string('type', 20)->comment('评论的类型 video_info tweet');
            $table->integer('source_id')->unsigned()->index()->comment('来源id');
            $table->integer('user_id')->unsigned()->index()->comment('用户id');
            $table->text('content')->comment('评论内容');
            $table->integer('pid')->index()->default(0)->comment('回复的那条评论id 如果为0, 则表示回复视频信息/动弹');
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
