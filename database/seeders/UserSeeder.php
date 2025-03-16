<?php
namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\User;
use App\Models\Role;
use Illuminate\Support\Facades\Hash;

class UserSeeder extends Seeder
{
    public function run(): void
    {
        // Create Admin User
        $admin = User::create([
            'full_name'        => 'Manager',
            'passport_name'    => 'Manager',
            'passport_number'  => 'Manager',
            'national_number'  => 'Manager',
            'job_number'       => 'manager@akakusoil.com',
            'phone_number'     => 'Manager',
            'password'         => Hash::make('manager@akakusoil.com'),
        ]);

        // Assign Admin Role
        $adminRole = Role::where('name', 'admin')->first();

        if ($adminRole) {
            $admin->roles()->attach($adminRole->id);
        }
    }
}
