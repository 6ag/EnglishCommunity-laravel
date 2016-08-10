<?php

use Illuminate\Database\Seeder;

class TrendsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('trends')->insert([
            [
                'user_id' => 1,
                'content' => '今天吃屎非常合适',
                'view' => 5,
                'small_photo' => null,
                'photo' => null,
                'created_at' => \Carbon\Carbon::now(),
                'updated_at' => \Carbon\Carbon::now(),
            ], [
                'user_id' => 2,
                'content' => '一起吃屎吧',
                'view' => 1,
                'small_photo' => 'uploads/0ac23ab277e4b0e458e5aeccb49e327c.jpg',
                'photo' => 'uploads/0ac23ab277e4b0e458e5aeccb49e327c.jpg',
                'created_at' => \Carbon\Carbon::now(),
                'updated_at' => \Carbon\Carbon::now(),
            ], [
                'user_id' => 1,
                'content' => '刚把爹',
                'view' => 1,
                'small_photo' => null,
                'photo' => null,
                'created_at' => \Carbon\Carbon::now(),
                'updated_at' => \Carbon\Carbon::now(),
            ]
        ]);
    }
}
