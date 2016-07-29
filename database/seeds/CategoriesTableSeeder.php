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
                'order' => 1
            ], [
                'name' => '单词',
                'order' => 2
            ], [
                'name' => '语法',
                'order' => 3
            ], [
                'name' => '口语',
                'order' => 4
            ], [
                'name' => '听力',
                'order' => 5
            ], [
                'name' => '阅读',
                'order' => 6
            ], [
                'name' => '作文',
                'order' => 7
            ], [
                'name' => '大学英语',
                'order' => 8
            ], [
                'name' => '英语四六级',
                'order' => 9
            ], [
                'name' => '考研英语',
                'order' => 10
            ], [
                'name' => '新概念英语',
                'order' => 11
            ], [
                'name' => '商务英语',
                'order' => 12
            ], [
                'name' => '雅思',
                'order' => 13
            ], [
                'name' => '托福',
                'order' => 14
            ], [
                'name' => '看电影学英语',
                'order' => 15
            ]
        ]);
    }
}
