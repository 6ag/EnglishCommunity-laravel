<?php

use Illuminate\Database\Seeder;

class CategoriesTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('categories')->insert([
            [
                'name' => '音标',
                'alias' => 'yinbiao',
                'order' => 1,
                'created_at' => \Carbon\Carbon::now(),
                'updated_at' => \Carbon\Carbon::now(),
            ], [
                'name' => '单词',
                'alias' => 'danci',
                'order' => 2,
                'created_at' => \Carbon\Carbon::now(),
                'updated_at' => \Carbon\Carbon::now(),
            ], [
                'name' => '语法',
                'alias' => 'yufa',
                'order' => 3,
                'created_at' => \Carbon\Carbon::now(),
                'updated_at' => \Carbon\Carbon::now(),
            ], [
                'name' => '口语',
                'alias' => 'kouyu',
                'order' => 4,
                'created_at' => \Carbon\Carbon::now(),
                'updated_at' => \Carbon\Carbon::now(),
            ], [
                'name' => '听力',
                'alias' => 'tingli',
                'order' => 5,
                'created_at' => \Carbon\Carbon::now(),
                'updated_at' => \Carbon\Carbon::now(),
            ], [
                'name' => '阅读',
                'alias' => 'yuedu',
                'order' => 6,
                'created_at' => \Carbon\Carbon::now(),
                'updated_at' => \Carbon\Carbon::now(),
            ], [
                'name' => '作文',
                'alias' => 'zuowen',
                'order' => 7,
                'created_at' => \Carbon\Carbon::now(),
                'updated_at' => \Carbon\Carbon::now(),
            ]
        ]);
    }
}
