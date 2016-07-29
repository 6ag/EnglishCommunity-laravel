<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateVideoInfosTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('video_infos', function (Blueprint $table) {
            $table->increments('id');
            $table->string('title'); // 标题
            $table->string('intro')->nullable(); // 简介
            $table->string('photo')->nullable(); // 标题图片
            $table->integer('view')->default(0); // 浏览量
            $table->tinyInteger('category_id'); // 分类id
            $table->string('teacher')->nullable(); // 讲师
            $table->tinyInteger('type')->default(0); // 视频类型: 0 优酷
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
        Schema::drop('video_infos');
    }
}
