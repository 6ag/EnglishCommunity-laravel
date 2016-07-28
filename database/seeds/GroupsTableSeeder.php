<?php

use Illuminate\Database\Seeder;

class GroupsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('groups')->insert([
            [
                'name' => '一级会员',
                'sign' => 'level_1'
            ], [
                'name' => '二级会员',
                'sign' => 'level_2'
            ], [
                'name' => '三级会员',
                'sign' => 'level_3'
            ], [
                'name' => '四级会员',
                'sign' => 'level_4'
            ], [
                'name' => '五级会员',
                'sign' => 'level_5'
            ], [
                'name' => '六级会员',
                'sign' => 'level_6'
            ]
        ]);
    }
}