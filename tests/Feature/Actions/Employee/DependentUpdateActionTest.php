<?php

declare(strict_types=1);

use App\Actions\Employee\DependentUpdateAction;
use App\Data\Employee\DependentData;
use App\Models\Employee\EmployeeDependent;
use App\Models\User;
use Illuminate\Validation\ValidationException;

it('updates an employee dependent with authenticated user', function (): void {
    $user = User::factory()->create();
    $dependent = EmployeeDependent::factory()->create([
        'name_en' => 'Old Name',
        'date_of_birth' => now()->subYears(8),
    ]);

    $this->actingAs($user);

    $data = DependentData::from([
        ...$dependent->toArray(),
        'name_en' => 'Updated Name',
        'date_of_birth' => now()->subYears(8),
    ]);

    $action = new DependentUpdateAction;
    $updatedDependent = $action->handle($dependent, $data);

    expect($updatedDependent->name_en)->toBe('Updated Name');

    $this->assertDatabaseHas('employee_dependents', [
        'id' => $dependent->id,
        'name_en' => 'Updated Name',
        'updated_by' => $user->id,
    ]);
});

it('allows keeping the same identification when updating', function (): void {
    $dependent = EmployeeDependent::factory()->create([
        'identification' => '1098765432',
        'date_of_birth' => now()->subYears(8),
    ]);

    $data = DependentData::from([
        ...$dependent->toArray(),
        'identification' => '1098765432',
        'date_of_birth' => now()->subYears(8),
    ]);

    $action = new DependentUpdateAction;
    $updatedDependent = $action->handle($dependent, $data);

    expect($updatedDependent->identification)->toBe('1098765432');
});

it('fails validation when updating with an identification assigned to another dependent', function (): void {
    $dependent1 = EmployeeDependent::factory()->create(['identification' => '1111111111']);
    $dependent2 = EmployeeDependent::factory()->create([
        'identification' => '2222222222',
        'date_of_birth' => now()->subYears(8),
    ]);

    $data = DependentData::from([
        ...$dependent2->toArray(),
        'identification' => '1111111111',
        'date_of_birth' => now()->subYears(8),
    ]);

    $action = new DependentUpdateAction;
    $action->handle($dependent2, $data);
})->throws(ValidationException::class);
