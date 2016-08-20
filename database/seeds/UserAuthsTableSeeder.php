<?php

use Illuminate\Database\Seeder;

class UserAuthsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('user_auths')->insert([
            [
                'user_id' => 10000,
                'identity_type' => 'username',
                'identifier' => 'admin',
                'credential' => bcrypt('123456'),
                'created_at' => \Carbon\Carbon::now(),
                'updated_at' => \Carbon\Carbon::now(),
            ], [
                'user_id' => 10000,
                'identity_type' => 'phone',
                'identifier' => '15626427299',
                'credential' => bcrypt('123456'),
                'created_at' => \Carbon\Carbon::now(),
                'updated_at' => \Carbon\Carbon::now(),
            ], [
                'user_id' => 10000,
                'identity_type' => 'email',
                'identifier' => 'admin@6ag.cn',
                'credential' => bcrypt('123456'),
                'created_at' => \Carbon\Carbon::now(),
                'updated_at' => \Carbon\Carbon::now(),
            ], [
                'user_id' => 10001,
                'identity_type' => 'username',
                'identifier' => 'admin8',
                'credential' => bcrypt('123456'),
                'created_at' => \Carbon\Carbon::now(),
                'updated_at' => \Carbon\Carbon::now(),
            ], [
                'user_id' => 10002,
                'identity_type' => 'username',
                'identifier' => 'admin88',
                'credential' => bcrypt('123456'),
                'created_at' => \Carbon\Carbon::now(),
                'updated_at' => \Carbon\Carbon::now(),
            ]
        ]);
    }
}
