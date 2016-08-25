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
                'id' => 10000,
                'nickname' => '管理员',
                'say' => '好好学习天天向上',
                'avatar' => 'uploads/user/default/avatar.jpg',
                'mobile' => '15626427299',
                'email' => 'admin@6ag.cn',
                'mobile_binding' => 1,
                'email_binding' => 1,
                'sex' => 1,
                'is_admin' => 1,
                'created_at' => \Carbon\Carbon::now(),
                'updated_at' => \Carbon\Carbon::now(),
            ]
        ]);
    }
}
