<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $user = User::create([
            'nama' => 'Udin',
            'no_hp' => '082252397405',
            'resort' => 3,
            'email' => 'hazimudinlaode@gmail.com',
            'email_verified_at' => now(),
            'password' => Hash::make('12345678'),
            'status' => 'aktif',
        ]);

        $user->assignRole('admin');
        $user->givePermissionTo('marketing');
    }
}
