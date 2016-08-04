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
            ]
        ]);
    }
}
