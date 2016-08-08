<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateVideosTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('videos', function (Blueprint $table) {
            $table->increments('id');
            $table->string('title')->comment('标题');
            $table->integer('video_info_id')->unsigned()->index()->comment('视频信息id');
            $table->string('video_url')->comment('视频地址 例如: http://v.youku.com/v_show/id_XMTUwNjQ0NDQ4MA==.html');
            $table->integer('order')->comment('视频顺序');
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
        Schema::drop('videos');
    }
}
