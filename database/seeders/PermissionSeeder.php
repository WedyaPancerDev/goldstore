<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Role;

class PermissionSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Role::create(
            ['name' => 'admin'],
        );
        Role::create(
            ['name' => 'manajer'],
        );
        Role::create(
            ['name' => 'akuntan'],
        );
        Role::create(
            ['name' => 'staff'],
        );

        $currentAdmin = User::find(1);
        $currentManajer = User::find(2);
        $currentAkuntan = User::find(3);
        $currentStaff = User::find(4);



        $currentAdmin->assignRole('admin');
        $currentManajer->assignRole('manajer');
        $currentAkuntan->assignRole('akuntan');
        $currentStaff->assignRole('staff');

    }
}
