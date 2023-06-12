<?php

namespace Database\Seeders;

use App\Permissions\Permissions;
use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;

class RoleAndPermissionSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $permissions = [
            'role-list',
            'role-create',
            'role-edit',
            'role-delete',
        ];
        $permissions = array_merge($permissions, Permissions::PRODUCT_PERMISSIONS);

        foreach ($permissions as $permission) {
            Permission::create(['name' => $permission]);
        }

        $adminRole = Role::create(['name' => 'Admin']);
        $adminRole->givePermissionTo($permissions);

    }
}
