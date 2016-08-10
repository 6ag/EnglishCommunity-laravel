<?php

use Illuminate\Database\Seeder;

class UsersTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('users')->insert([
            [
                'nickname' => '管理员',
                'say' => '好好学习天天向上',
                'avatar' => 'uploads/user/avatar.jpg',
                'mobile' => '15626427299',
                'email' => 'admin@6ag.cn',
                'mobile_binding' => 1,
                'email_binding' => 1,
                'sex' => 1,
                'is_admin' => 1,
                'created_at' => \Carbon\Carbon::now(),
                'updated_at' => \Carbon\Carbon::now(),
            ], [
                'nickname' => '王麻子',
                'say' => '好好学习天天向上',
                'avatar' => 'uploads/user/avatar.jpg',
                'mobile' => null,
                'email' => null,
                'mobile_binding' => 0,
                'email_binding' => 0,
                'sex' => 1,
                'is_admin' => 0,
                'created_at' => \Carbon\Carbon::now(),
                'updated_at' => \Carbon\Carbon::now(),
            ], [
                'nickname' => '李二狗',
                'say' => '好好学习天天向上',
                'avatar' => 'uploads/user/avatar.jpg',
                'mobile' => null,
                'email' => null,
                'mobile_binding' => 0,
                'email_binding' => 0,
                'sex' => 1,
                'is_admin' => 0,
                'created_at' => \Carbon\Carbon::now(),
                'updated_at' => \Carbon\Carbon::now(),
            ]
        ]);
    }
}
