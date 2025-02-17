<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;

class RolesAndPermissionsSeeder extends Seeder
{
    public function run()
    {
        // Clear cached roles and permissions
        app()[\Spatie\Permission\PermissionRegistrar::class]->forgetCachedPermissions();

        // Create permissions
        $manageStudents = Permission::create(['name' => 'view manage students']);
        $viewInfo = Permission::create(['name' => 'view info']);
        $crud = Permission::create(['name' => 'perform crud operations']);
        // Create roles and assign created permissions
        $admin = Role::create(['name' => 'admin']);
        $student = Role::create(['name' => 'student']);
        $teacher = Role::create(['name' => 'teacher']);
        $developer = Role::create(['name' => 'developer']);
        // Give specific permissions to each role
        $admin->givePermissionTo($crud);
        $student->givePermissionTo($viewInfo);
        $teacher->givePermissionTo($manageStudents);
        $developer->givePermissionTo(['super admin', 'perform crud operations', 'manage orders', 'view orders']);

    }
}
