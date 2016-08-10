<?php

use Illuminate\Database\Seeder;

class CommentsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('comments')->insert([
            [
                'type' => 'trends',
                'source_id' => 1,
                'user_id' => 2,
                'content' => '一起吃行不',
                'pid' => 0,
                'created_at' => \Carbon\Carbon::now(),
                'updated_at' => \Carbon\Carbon::now(),
            ], [
                'type' => 'trends',
                'source_id' => 1,
                'user_id' => 1,
                'content' => '完全可以啊',
                'pid' => 1,
                'created_at' => \Carbon\Carbon::now(),
                'updated_at' => \Carbon\Carbon::now(),
            ], [
                'type' => 'trends',
                'source_id' => 1,
                'user_id' => 2,
                'content' => '你们吃屎竟然不叫我',
                'pid' => 2,
                'created_at' => \Carbon\Carbon::now(),
                'updated_at' => \Carbon\Carbon::now(),
            ]
        ]);
    }
}
