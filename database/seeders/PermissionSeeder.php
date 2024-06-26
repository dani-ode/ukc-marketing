<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Permission;

class PermissionSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $data = ['marketing', 'accounting'];
        foreach ($data as $value) {
            Permission::create([
                'name' => $value,
                'guard_name' => 'web'
            ]);
        }
    }
}
