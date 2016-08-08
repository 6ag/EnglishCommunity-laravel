<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateTrendsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('trends', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('user_id')->unsigned()->index()->comment('用户id');
            $table->text('content')->comment('动弹内容');
            $table->string('photo')->nullable()->comment('图片字段 只存一张图片');
            $table->integer('view')->default(0)->comment('动弹访问量');
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
        Schema::drop('trends');
    }
}
