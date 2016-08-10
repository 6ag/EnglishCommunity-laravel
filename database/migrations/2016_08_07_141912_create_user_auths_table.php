<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateUserAuthsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('user_auths', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('user_id')->unsigned()->index()->comment('用户id');
            $table->string('identity_type')->comment('登录类型（手机号mobile 邮箱email 用户名username）或第三方应用名称（微信weixin 微博weibo 腾讯QQqq等）');
            $table->string('identifier')->unique()->index()->comment('标识（手机号 邮箱 用户名或第三方应用的唯一标识）');
            $table->string('credential')->comment('密码凭证（站内的保存密码，站外的不保存或保存token）');
            $table->tinyInteger('verified')->default(0)->comment('是否已经验证');
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
        Schema::drop('user_auths');
    }
}
