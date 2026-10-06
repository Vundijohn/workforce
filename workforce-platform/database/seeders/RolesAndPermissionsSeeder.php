<?php

namespace Database\Seeders;

use App\Enums\Role as RoleEnum;
use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;
use Spatie\Permission\PermissionRegistrar;

class RolesAndPermissionsSeeder extends Seeder
{
    public function run(): void
    {
        app(PermissionRegistrar::class)->forgetCachedPermissions();

        foreach (RoleEnum::cases() as $role) {
            $model = Role::findOrCreate($role->value, 'web');

            foreach ($role->permissions() as $permission) {
                Permission::findOrCreate($permission, 'web');
            }

            $model->syncPermissions($role->permissions());
        }
    }
}
