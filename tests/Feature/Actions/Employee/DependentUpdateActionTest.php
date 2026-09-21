<?php

declare(strict_types=1);

use App\Actions\Employee\DependentUpdateAction;
use App\Data\Employee\DependentData;
use App\Models\Employee\EmployeeDependent;

it('updates an employee dependent ', function (): void {
    $dependent = EmployeeDependent::factory()->create();
    $data = DependentData::from(EmployeeDependent::factory()->make());
    $updatedDependent = resolve(DependentUpdateAction::class)->handle($dependent, $data);

    expect($updatedDependent)->toBeInstanceOf(EmployeeDependent::class);
    $this->assertDatabaseHas('employee_dependents', $updatedDependent->getAttributes());
});

it('fails to update dependent when :dataset', function (array $overrides, array $fields): void {
    expectValidationError(
        fn () => resolve(DependentUpdateAction::class)->handle(
            EmployeeDependent::factory()->create(),
            DependentData::from(EmployeeDependent::factory()->make($overrides)),
        ),
        $fields,
    );
})->with('dependent dataset');
