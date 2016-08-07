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
                'user_id' => 1,
                'identity_type' => 'username',
                'identifier' => 'admin',
                'credential' => bcrypt('123456'),
            ], [
                'user_id' => 1,
                'identity_type' => 'phone',
                'identifier' => '15626427299',
                'credential' => bcrypt('123456'),
            ], [
                'user_id' => 1,
                'identity_type' => 'email',
                'identifier' => 'admin@6ag.cn',
                'credential' => bcrypt('123456'),
            ]
        ]);
    }
}
