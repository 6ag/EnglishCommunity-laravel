<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateMessageRecordsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('message_records', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('by_user_id')->unsigned()->index()->comment('发布信息的用户id');
            $table->integer('to_user_id')->unsigned()->index()->comment('接收信息的用户id');
            $table->string('message_type')->comment('消息类型 comment at');
            $table->string('type', 20)->comment('消息来源类型 video_info tweet');
            $table->integer('source_id')->unsigned()->index()->comment('消息来源id video_info tweet的id');
            $table->text('content')->comment('消息内容');
            $table->tinyInteger('looked')->default(0)->comment('0:未读 1:已读 是否已经查看');
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
        Schema::drop('message_records');
    }
}
