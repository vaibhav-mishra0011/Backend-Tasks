<?php

namespace Database\Seeders;

use App\Models\Role;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class RoleSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run()
    {
        $adminRole = Role::create(['name' => 'admin', 'guard_name' => config('auth.defaults.guard')]);
        $userRole = Role::create(['name' => 'user', 'guard_name' => config('auth.defaults.guard')]);

        // $userRole->givePermissionTo('all');
        // $adminRole->givePermissionTo('all');
    }
}
