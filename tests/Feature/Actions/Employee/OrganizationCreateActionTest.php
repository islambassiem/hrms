<?php

use App\Actions\Employee\OrganizationCreateAction;
use App\Data\Employee\OrganizationData;
use App\Models\Employee\Employee;
use App\Models\Employee\EmployeeOrganization;

it('creates an employee organization association', function (): void {
    $employee = Employee::factory()->create();

    $data = OrganizationData::from(EmployeeOrganization::factory()->make([
        'employee_id' => $employee->id,
    ]));

    $employeeOrganization = resolve(OrganizationCreateAction::class)->handle($data);

    expect($employeeOrganization)->toBeInstanceOf(EmployeeOrganization::class);
    $this->assertDatabaseHas('employee_organizations', $employeeOrganization->getAttributes());
});

it('fails to create a job title assignment for non employee', function (): void {
    $data = OrganizationData::from(EmployeeOrganization::factory()->make([
        'employee_id' => 999,
    ]));
    expectValidationError(
        fn () => resolve(OrganizationCreateAction::class)->handle($data),
        ['employee_id']
    );
});

it('fails to create an employee organization relationship when :dataset', function (array $overrides, array $fields): void {
    expectValidationError(
        fn () => resolve(OrganizationCreateAction::class)->handle(
            OrganizationData::from(EmployeeOrganization::factory()->make($overrides))
        ),
        $fields
    );
})->with('employee organization dataset');
