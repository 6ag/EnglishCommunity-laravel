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
            'username' => 'admin',
            'password' => bcrypt('123456'), // Hash散列
            'nickname' => '管理员',
            'group_id' => 1,
            'permission_id' => 2,
            'created_at' => \Carbon\Carbon::getLocale(),
            'updated_at' => \Carbon\Carbon::getLocale(),
        ]);
    }
}
