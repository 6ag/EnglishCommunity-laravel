<?php

use Illuminate\Database\Seeder;

class TweetsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('tweets')->insert([
            [
                'user_id' => 1,
                'content' => '今天吃屎非常合适',
                'view' => 5,
                'photos' => 'http://static.oschina.net/uploads/space/2016/0814/131553_I5At_2298771.jpg,http://static.oschina.net/uploads/space/2016/0814/131554_40Qe_2298771.jpg,http://static.oschina.net/uploads/space/2016/0814/131554_Jt5j_2298771.jpg',
                'photo_thumbs' => 'http://static.oschina.net/uploads/space/2016/0814/131553_I5At_2298771_thumb.jpg,http://static.oschina.net/uploads/space/2016/0814/131554_40Qe_2298771_thumb.jpg,http://static.oschina.net/uploads/space/2016/0814/131554_Jt5j_2298771_thumb.jpg',
                'created_at' => \Carbon\Carbon::now(),
                'updated_at' => \Carbon\Carbon::now(),
            ], [
                'user_id' => 2,
                'content' => '一起吃屎吧',
                'view' => 1,
                'photos' => '',
                'photo_thumbs' => '',
                'created_at' => \Carbon\Carbon::now(),
                'updated_at' => \Carbon\Carbon::now(),
            ], [
                'user_id' => 1,
                'content' => '刚把爹',
                'view' => 1,
                'photos' => 'http://static.oschina.net/uploads/space/2016/0814/131553_I5At_2298771.jpg,http://static.oschina.net/uploads/space/2016/0814/131554_40Qe_2298771.jpg,http://static.oschina.net/uploads/space/2016/0814/131554_Jt5j_2298771.jpg',
                'photo_thumbs' => 'http://static.oschina.net/uploads/space/2016/0814/131553_I5At_2298771_thumb.jpg,http://static.oschina.net/uploads/space/2016/0814/131554_40Qe_2298771_thumb.jpg,http://static.oschina.net/uploads/space/2016/0814/131554_Jt5j_2298771_thumb.jpg',
                'created_at' => \Carbon\Carbon::now(),
                'updated_at' => \Carbon\Carbon::now(),
            ], [
                'user_id' => 1,
                'content' => '测试一下啊测试一下啊测试一下啊测试一下啊测试一下啊测试一下啊测试一下啊测试一下啊测试一下啊测试一下啊测试一下啊测试一下啊测试一下啊测试一下啊测试一下啊测试一下啊测试一下啊',
                'view' => 1,
                'photos' => '',
                'photo_thumbs' => '',
                'created_at' => \Carbon\Carbon::now(),
                'updated_at' => \Carbon\Carbon::now(),
            ]
        ]);
    }
}
