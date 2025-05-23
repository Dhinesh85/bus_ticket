<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\User;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\DB;
use Spatie\Permission\Models\Role;

class CreateSuperAdminUserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Disable foreign key checks
       

        // Truncate relevant tables
        DB::table('model_has_roles')->truncate();
       

        // Create the user
        $user = User::create([
            'name' => 'SuperAdmin user',
            'email' => 'superadmin@yopmail.com',
            'password' => Hash::make('superadmin@123456'),
            'role_id' => 1,
        ]);

        // Assign SuperAdmin role
        $superAdminRole = Role::where('name', 'SuperAdmin')->first();
        if ($superAdminRole) {
            $user->assignRole($superAdminRole);
        }
    }
}
