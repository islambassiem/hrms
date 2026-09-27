<?php

use App\Http\Resources\Employee\DashboardResource;
use App\Models\Employee\Employee;
use App\Models\Lookup\IdentityType;

it('transforms an employee into the dashboard resource', function (): void {
    $employee = Employee::factory()->create([
        'head_id' => Employee::factory()->create()->id,
    ]);

    $type = IdentityType::factory(2)->create();

    $employee->identifications()->createMany([
        [
            'identity_type_id' => $type[0]->id,
            'identity_number' => 'ABC123',
            'expiry_date' => '2030-01-15',
        ],
        [
            'identity_type_id' => $type[1]->id,
            'identity_number' => 'XYZ789',
            'expiry_date' => '2031-06-20',
        ],
    ]);

    $result = DashboardResource::make($employee)->resolve();

    expect($result)->toMatchArray([
        'id' => $employee->id,
        'name' => $employee->name,
        'joiningDate' => $employee->joining_date->toDateString(),
        'jobTitle' => $employee->latestCurrentJobTitle,
        'department' => $employee->department->name,
        'head' => $employee->head->name,
        'annualLeaveBalance' => $employee->annualLeaveBalance,
        'identifications' => [
            [
                'id' => $type[0]->id,
                'type' => $type[0]->name,
                'number' => 'ABC123',
                'expiryDate' => '2030-01-15',
            ],
            [
                'id' => $type[1]->id,
                'type' => $type[1]->name,
                'number' => 'XYZ789',
                'expiryDate' => '2031-06-20',
            ],
        ],

    ]);
});
