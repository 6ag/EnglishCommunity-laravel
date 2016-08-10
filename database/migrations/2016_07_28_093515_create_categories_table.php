<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateCategoriesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('categories', function (Blueprint $table) {
            $table->increments('id');
            $table->string('name')->unique()->index()->comment('分类名称');
            $table->string('alias')->unique()->index()->comment('分类别名');
            $table->integer('view')->unsigned()->default(0)->comment('浏览量');
            $table->tinyInteger('order')->unsigned()->default(0)->comment('排序');
            $table->integer('pid')->index()->unsigned()->default(0)->comment('分类父id');
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
        Schema::drop('categories');
    }
}
