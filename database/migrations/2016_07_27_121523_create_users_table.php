<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateUsersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('users', function (Blueprint $table) {
            $table->increments('id');
            $table->string('nickname', 30)->default('佚名')->comment('昵称');
            $table->string('say')->nullable()->comment('心情寄语');
            $table->string('avatar', 100)->default('uploads/user/default/avatar.jpg')->comment('头像');
            $table->string('mobile', 11)->nullable()->comment('手机号码');
            $table->string('email', 50)->nullable()->comment('邮箱');
            $table->tinyInteger('sex')->default(0)->comment('性别 0女 1男');
            $table->tinyInteger('status')->default(1)->comment('状态 1可用 0 不可用');
            $table->tinyInteger('ad_disabled')->default(0)->comment('0没有禁用 1禁用');
            $table->tinyInteger('is_admin')->default(0)->comment('是否是管理员');
            $table->tinyInteger('qq_binding')->default(0)->comment('QQ登录是否绑定');
            $table->tinyInteger('weixin_binding')->default(0)->comment('微信登录是否绑定');
            $table->tinyInteger('weibo_binding')->default(0)->comment('微博登录是否绑定');
            $table->tinyInteger('email_binding')->default(0)->comment('邮箱登录是否绑定');
            $table->tinyInteger('mobile_binding')->default(0)->comment('手机登录是否绑定');
            $table->timestamp('last_login_time')->nullable()->comment('最后一次登录时间');
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
        Schema::drop('users');
    }
}
