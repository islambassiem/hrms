<?php

declare(strict_types=1);

namespace Database\Seeders;

use App\Enums\PermissionEnum;
use App\Enums\RoleEnum;
use App\Models\User;
use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;

class RolesAndPermissionsSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $roles = RoleEnum::cases();
        $permissions = PermissionEnum::cases();

        foreach ($roles as $role) {
            Role::create(['name' => $role->value]);
        }

        foreach ($permissions as $permission) {
            Permission::create(['name' => $permission->value]);
        }

        $admin = User::query()->findOrFail(1);

        foreach ($roles as $role) {
            $admin->assignRole($role->value);
        }

        foreach ($permissions as $permission) {
            $admin->givePermissionTo($permission->value);
        }

        $departmentHead = User::query()->findOrFail(2);
        /** @var Role $headRole */
        $headRole = Role::query()->where('name', RoleEnum::DEPARTMENT_HEAD->value)->first();
        $departmentHead->assignRole(RoleEnum::DEPARTMENT_HEAD->value);
        $headRole->givePermissionTo(PermissionEnum::HEAD_PAGE->value);

        $hrPersonnel = User::query()->findOrFail(3);
        $hrRole = Role::query()->where('name', RoleEnum::HR_PERSONNEL->value)->first();
        /** @var Role $hrRole */
        $hrPersonnel->assignRole(RoleEnum::HR_PERSONNEL->value);
        $hrRole->givePermissionTo(PermissionEnum::HR_PAGE->value);
    }
}
