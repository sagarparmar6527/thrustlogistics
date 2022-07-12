<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Database\Seeder;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run(){
        DB::table('users')->insert([
            'name' => 'Super Admin',
            'username' => 'superadmin',
            'email' => 'superadmin@gmail.com',
            'password' => Hash::make('12345678'),
            'is_system' => 1,
            'permission' => '["Data entry","Invoicing","Manage Users"]',
        ]);

        DB::table('users')->insert([
            'name' => 'Test user',
            'username' => 'testuser',
            'email' => 'testuser@gmail.com',
            'password' => Hash::make('12345678'),
            'permission' => '["Data entry","Invoicing","Manage Users"]',
        ]);
    }
}
