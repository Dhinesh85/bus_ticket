<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\User;
use Illuminate\Support\Facades\Hash;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;

class CreateSuperAdminUserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     * KEY : MULTIPERMISSION
     */
    public function run(): void
    {
       
        User::truncate();
      
        $user = User::create([
            'name' => 'SuperAdmin user',
            'email' => 'superadmin@yopmail.com',
            'password' => Hash::make('superadmin@123456'),
            'role_id' => 1,
        ]);
        
    }
}
