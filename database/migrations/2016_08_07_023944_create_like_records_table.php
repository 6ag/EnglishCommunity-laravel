<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateLikeRecordsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        // 记录谁赞过 动弹、视频
        Schema::create('like_records', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('user_id')->unsigned()->index()->comment('用户id');
            $table->string('type', 20)->comment('喜欢的类型 video_info tweet');
            $table->integer('source_id')->unsigned()->index()->comment('来源id');
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
        Schema::drop('like_records');
    }
}
