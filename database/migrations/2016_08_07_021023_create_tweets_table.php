<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateTweetsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('tweets', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('user_id')->unsigned()->index()->comment('用户id');
            $table->tinyInteger('app_client')->default(0)->comment('0:iOS 1:Android');
            $table->text('content')->comment('动弹内容');
            $table->integer('view')->default(0)->comment('动弹访问量');
            $table->text('photos')->nullable()->comment('原图。以,分割 存储多张图片');
            $table->text('photo_thumbs')->nullable()->comment('缩略图');
            $table->text('at_user_ids')->nullable()->comment('被at用户的user_id');
            $table->text('at_nicknames')->nullable()->comment('被at用户的昵称。以,分割 可存储多个昵称');
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
        Schema::drop('tweets');
    }
}
