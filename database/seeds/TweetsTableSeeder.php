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
                'photos' => 'uploads/tweets/2016-08-15/79965b663a7b956f2b219dbcedcf12bc.jpg,uploads/tweets/2016-08-15/9eb090cd0da0659777ce7b2158043a79.jpg,uploads/tweets/2016-08-15/70b34cc93429893a070eb4ccf6354d5d.jpg,uploads/tweets/2016-08-15/a37dfcaac392d92f5b324b0b31d97935.jpg,uploads/tweets/2016-08-15/8bda6708f5c8cd544eaecc54aeda8316.jpg,uploads/tweets/2016-08-15/eaf1005c0511734840cbd6ee7e2971cc.jpg,uploads/tweets/2016-08-15/5c76afb035ad6175a1a8d20c95a8c7e3.jpg,uploads/tweets/2016-08-15/40e4becd02a0afdadbc4c246b0e97b91.jpg,uploads/tweets/2016-08-15/56295d5808a0aade667b8d4399efb006.jpg',
                'photo_thumbs' => 'uploads/tweets/2016-08-15/79965b663a7b956f2b219dbcedcf12bc_thumb.jpg,uploads/tweets/2016-08-15/9eb090cd0da0659777ce7b2158043a79_thumb.jpg,uploads/tweets/2016-08-15/70b34cc93429893a070eb4ccf6354d5d_thumb.jpg,uploads/tweets/2016-08-15/a37dfcaac392d92f5b324b0b31d97935_thumb.jpg,uploads/tweets/2016-08-15/8bda6708f5c8cd544eaecc54aeda8316_thumb.jpg,uploads/tweets/2016-08-15/eaf1005c0511734840cbd6ee7e2971cc_thumb.jpg,uploads/tweets/2016-08-15/5c76afb035ad6175a1a8d20c95a8c7e3_thumb.jpg,uploads/tweets/2016-08-15/40e4becd02a0afdadbc4c246b0e97b91_thumb.jpg,uploads/tweets/2016-08-15/56295d5808a0aade667b8d4399efb006_thumb.jpg',
                'created_at' => \Carbon\Carbon::now(),
                'updated_at' => \Carbon\Carbon::now(),
            ]
        ]);
    }
}
