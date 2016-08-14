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
            $table->text('content')->comment('动弹内容');
            $table->tinyInteger('app_client')->default(0)->comment('0:iOS 1:Android');
            $table->integer('view')->default(0)->comment('动弹访问量');
            $table->string('photos')->nullable()->comment('正常尺寸图片。以,分割 存储多张图片');
            $table->string('photo_thumbs')->nullable()->comment('缩略图');
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
