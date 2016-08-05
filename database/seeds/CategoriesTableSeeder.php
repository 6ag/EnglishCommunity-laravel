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
                'order' => 1
            ], [
                'name' => '单词',
                'alias' => 'danci',
                'order' => 2
            ], [
                'name' => '语法',
                'alias' => 'yufa',
                'order' => 3
            ], [
                'name' => '口语',
                'alias' => 'kouyu',
                'order' => 4
            ], [
                'name' => '听力',
                'alias' => 'tingli',
                'order' => 5
            ], [
                'name' => '阅读',
                'alias' => 'yuedu',
                'order' => 6
            ], [
                'name' => '作文',
                'alias' => 'zuowen',
                'order' => 7
            ]
        ]);
    }
}
