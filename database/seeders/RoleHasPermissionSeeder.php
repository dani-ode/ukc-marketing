<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Role;

class RoleHasPermissionSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $admin_role = Role::find(1);
        $editor_role = Role::find(2);

        // Admin
        $admin_role->givePermissionTo('marketing');

        $editor_role->givePermissionTo('marketing');
    }
}
