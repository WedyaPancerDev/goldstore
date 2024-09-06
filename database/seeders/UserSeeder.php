<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        User::create([
            'id' => 1,
            'username' => 'admin',
            'fullname' => 'Administrator',
            'password' => Hash::make('password'),
        ]);

        User::create([
            'id' => 2,
            'username' => 'manajer',
            'fullname' => 'Manager',
            'password' => Hash::make('password'),
        ]);

        User::create([
            'id' => 3,
            'username' => 'akuntan',
            'fullname' => 'Accountant',
            'password' => Hash::make('password'),
        ]);

        User::create([
            'id' => 4,
            'username' => 'staff',
            'fullname' => 'Staff Sales',
            'password' => Hash::make('password'),
        ]);
    }
}
