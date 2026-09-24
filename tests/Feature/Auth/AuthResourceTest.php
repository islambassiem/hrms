<?php

use App\Http\Resources\AuthResource;
use App\Models\Employee\Employee;
use App\Models\User;
use Spatie\Permission\Models\Permission;

it('transforms a user into the auth resource', function (): void {
    $user = User::factory()->create();
    $employee = Employee::factory()->create([
        'user_id' => $user->id,
    ]);
    $employee->refresh();

    $resource = AuthResource::make($user);

    expect($resource->resolve(request()))
        ->toBe([
            'id' => $user->id,
            'name' => $user->name,
            'email' => $user->email,
            'employee_code' => $employee->employee_code,
            'name_en' => $employee->full_name_en,
            'name_ar' => $employee->full_name_ar,
            'avatar' => $employee->image,
            'permissions' => [],
        ]);
});

it('includes the user permissions', function (): void {
    $user = User::factory()->create();

    Permission::create(['name' => 'users.view']);
    Permission::create(['name' => 'users.create']);

    $user->givePermissionTo([
        'users.view',
        'users.create',
    ]);

    $resource = AuthResource::make($user)->resolve(request());

    expect($resource['permissions'])
        ->toBe([
            'users.view',
            'users.create',
        ]);
});

it('returns null auth for unauthenticated users', function (): void {
    AuthResource::make(null)->resolve(request());
})->throws(ErrorException::class);
