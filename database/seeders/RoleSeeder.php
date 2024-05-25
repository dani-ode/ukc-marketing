<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Role;

class RoleSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $data = ['admin', 'editor', 'viewer'];
        foreach ($data as $value) {
            Role::create([
                'name' => $value,
                'guard_name' => 'web'
            ]);
        }
    }
}
