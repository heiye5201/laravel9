<?php

namespace Database\Seeders;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        // \App\Models\User::factory(10)->create();
         \App\Models\Admins::factory()->create([
             'username' => 'admin',
             'password' => Hash::make('admin'),
             'nickname' => '超级管理员',
             'avatar' => '',
             'is_super' => 1,
             'ip' => '127.0.0.1',
         ]);
    }
}
