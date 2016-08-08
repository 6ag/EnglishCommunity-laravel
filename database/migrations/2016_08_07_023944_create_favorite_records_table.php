<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateFavoriteRecordsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        // 记录谁赞过 动弹、视频
        Schema::create('favorite_records', function (Blueprint $table) {
            $table->increments('id');
            $table->string('type', 20)->comment('赞的类型 video_info trends');
            $table->integer('source_id')->unsigned()->index()->comment('来源id');
            $table->integer('user_id')->unsigned()->index()->comment('用户id');
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
        Schema::drop('favorite_record');
    }
}
