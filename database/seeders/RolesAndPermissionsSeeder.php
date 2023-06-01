<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;

class RolesAndPermissionsSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Reset cached roles and permissions
        app()[\Spatie\Permission\PermissionRegistrar::class]->forgetCachedPermissions();

        // Create permissions
        $permission1 = Permission::create(["name" => "edit project"]);
        $permission2 = Permission::create(["name" => "view project"]);

        // Create roles and assign existing permissions
        $role1 = Role::create(["name" => "editor"])->givePermissionTo($permission1);
        $role2 = Role::create(["name" => "viewer"])->givePermissionTo($permission2);
        $role3 = Role::create(["name" => "super-admin"])->givePermissionTo(Permission::all());
    }
}
