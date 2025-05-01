<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;
use Illuminate\Support\Facades\DB;

class PermissionTableSeeder extends Seeder
{
    public function run(): void
    {
        // Reset roles and permissions
      
        Permission::truncate();
        Role::truncate();
        DB::table('role_has_permissions')->truncate();


        // Create roles
        $roles = [
            'SuperAdmin', 
            'Administrator',
            'Member'
        ];

        foreach ($roles as $roleName) {
            Role::firstOrCreate(['name' => $roleName]);
        }

        // Define permissions
        $permissions = [
            "Users",
            "Role and Permission",
            "Location",
            "Renewell",
            "Chat Box"
        ];

        foreach ($permissions as $permissionName) {
            $permission = Permission::create(['name' => $permissionName]);

            // Assign all permissions to SuperAdmin
            $superAdmin = Role::where('name', 'SuperAdmin')->first();

            DB::table('role_has_permissions')->insert([
                'permission_id'     => $permission->id,
                'role_id'           => $superAdmin->id,
                'show_permission'   => 1,
                'edit_permission'   => 1,
                'delete_permission' => 1,
                'add_permission'    => 1,
            ]);
        }
    }
}
