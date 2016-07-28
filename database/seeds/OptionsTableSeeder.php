<?php

use Illuminate\Database\Seeder;

class OptionsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('options')->insert([
            [
                'name' => 'is_allow_register',
                'content' => '0',
                'comment' => '是否允许注册 0不允许 1允许',
            ]
        ]);
    }
}
