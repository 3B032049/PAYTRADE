<?php

namespace Database\Seeders;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class PermissionsSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run()
    {
        $superAdminRole = Role::create(['name' => 'super-admin']);
        $highLevelAdminRole = Role::create(['name' => 'high-level-admin']);
        $generalAdminRole = Role::create(['name' => 'general-admin']);

        $permissions = [
            'access_users',
            'access_sellers',
            'access_orders',
            // ... add other permissions here
        ];

        foreach ($permissions as $permission) {
            Permission::create(['name' => 'access_' . $permission]);
            $superAdminRole->givePermissionTo('access_' . $permission);
            // Assign other permissions to roles as needed
        }
    }
}
