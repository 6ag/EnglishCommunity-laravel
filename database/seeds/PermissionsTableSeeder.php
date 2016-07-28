<?php

use Illuminate\Database\Seeder;

class PermissionsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('permissions')->insert([
            [
                'name' => '会员',
                'sign' => 'member'
            ], [
                'name' => '管理员',
                'sign' => 'administrator'
            ]
        ]);
    }
}