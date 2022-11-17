<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $admin = User::create([
            'fullname'          =>  'Admin One',
            'email'         =>  'admin@gmail.com',
            'password'      =>  bcrypt('admin@123'),
            'is_admin'          => 'admin',
        ]);

        $user = User::create([
            'fullname'          =>  'User',
            'email'         =>  'user@gmail.com',
            'password'      =>  bcrypt('user@123'),
            'is_admin'          => 'user',
        ]);
    }
}
