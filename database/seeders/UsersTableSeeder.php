<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;

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
            'name' => 'admin',
            'email' => 'admin@gmail.com',
            'email_verified_at' => null,
            'password' => Hash::make('admin12345'), // Use Hash::make to hash the password
            'roles' => '1',
            'remember_token' => null,
            'created_at' => now(),
            'updated_at' => now(),
        ]);
    }
}
