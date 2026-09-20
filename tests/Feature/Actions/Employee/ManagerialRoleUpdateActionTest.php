<?php

declare(strict_types=1);

use App\Actions\Employee\ManagerialRoleUpdateAction;
use App\Data\Employee\ManagerialRoleData;
use App\Models\Employee\EmployeeManagerialRole;
use App\Models\User;
use Illuminate\Validation\ValidationException;

it('updates a managerial role assignment with authenticated user', function (): void {
    $user = User::factory()->create();
    $managerialRole = EmployeeManagerialRole::factory()->create();

    $this->actingAs($user);

    $data = ManagerialRoleData::from(EmployeeManagerialRole::factory()->create());

    $action = new ManagerialRoleUpdateAction;
    $updatedRole = $action->handle($managerialRole, $data);

    expect($updatedRole->managerial_role_id)->toBe(2);

    $this->assertDatabaseHas('employee_managerial_roles', [
        'managerial_role_id' => $data->managerial_role_id,
        'updated_by' => $user->id,
    ]);
});

it('fails validation when updating with an invalid end_date', function (): void {
    $managerialRole = EmployeeManagerialRole::factory()->create([
        'start_date' => now(),
    ]);

    $data = ManagerialRoleData::from([
        ...$managerialRole->toArray(),
        'end_date' => now()->subMonth(),
    ]);

    $action = new ManagerialRoleUpdateAction;
    $action->handle($managerialRole, $data);
})->throws(ValidationException::class);
