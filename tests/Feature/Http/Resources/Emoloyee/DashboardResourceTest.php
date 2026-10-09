<?php

use App\Enums\LeaveTypeEnum;
use App\Http\Resources\Employee\DashboardResource;
use App\Models\Employee\Employee;
use App\Models\Employee\EmployeeContract;
use App\Models\Employee\EmployeeJobTitle;
use App\Models\Leave\LeaveBalance;
use App\Models\Lookup\IdentityType;
use App\Models\Lookup\JobTitle;
use App\Models\Lookup\LeaveType;

it('transforms an employee into the dashboard resource', function (): void {
    $employee = Employee::factory()->create([
        'head_id' => Employee::factory()->create()->id,
    ]);

    $contract = EmployeeContract::factory()->create([
        'employee_id' => $employee->id,
    ]);

    $jobTitle = JobTitle::factory()->create();

    EmployeeJobTitle::factory()->create([
        'employee_id' => $employee->id,
        'job_title_id' => $jobTitle->id,
        'end_date' => null,
    ]);

    LeaveType::factory()->create([
        'id' => (int) LeaveTypeEnum::ANNUAL->value,
    ]);

    LeaveBalance::factory()->create([
        'employee_id' => $employee->id,
        'leave_type_id' => (int) LeaveTypeEnum::ANNUAL->value,
        'available_days' => 18.5,
        'accrued_days' => 20,
        'used_days' => 1,
        'pending_days' => 0.5,
        'expiring_days' => 2,
        'next_expiry_date' => '2027-01-31',
    ]);

    $type = IdentityType::factory(2)->create();

    $identifications = $employee->identifications()->createMany([
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
        'jobTitle' => [
            'id' => $jobTitle->id,
            'name' => $jobTitle->name,
        ],
        'department' => $employee->department->name,
        'head' => $employee->head->name,
        'annualLeaveBalance' => [
            'availableDays' => 18.5,
            'accruedDays' => 20.0,
            'usedDays' => 1.0,
            'pendingDays' => 0.5,
            'expiringDays' => 2.0,
            'nextExpiryDate' => '2027-01-31',
        ],
        'contractEndDate' => $contract->end_date->toDateString(),
        'identifications' => [
            [
                'id' => $identifications[0]->id,
                'type' => $type[0]->name,
                'number' => 'ABC123',
                'expiryDate' => '2030-01-15',
            ],
            [
                'id' => $identifications[1]->id,
                'type' => $type[1]->name,
                'number' => 'XYZ789',
                'expiryDate' => '2031-06-20',
            ],
        ],

    ]);
});
