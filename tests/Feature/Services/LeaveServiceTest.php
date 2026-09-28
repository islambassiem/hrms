<?php

use App\Enums\WorkflowActionEnum;
use App\Models\Employee\Employee;
use App\Models\Leave\EmployeeLeavePolicy;
use App\Models\Leave\LeaveBalance;
use App\Models\Leave\LeavePolicy;
use App\Models\Leave\LeaveRequest;
use App\Models\Lookup\LeaveType;
use App\Services\Leave\LeaveService;
use Carbon\CarbonImmutable;
use Illuminate\Database\Eloquent\Factories\Sequence;

it('calculates the correct leave balance', function (): void {
    $employee = Employee::factory()->create();
    $type = LeaveType::factory()->create();
    $policy = LeavePolicy::factory()->create([
        'leave_type_id' => $type->id,
        'days_per_year' => 30,
    ]);
    EmployeeLeavePolicy::factory()->create([
        'employee_id' => $employee->id,
        'leave_policy_id' => $policy->id,
        'end_date' => null,
    ]);

    $requests = LeaveRequest::factory()
        ->count(5)
        ->state(new Sequence(
            [
                'start_date' => CarbonImmutable::parse('2026-10-01'),
                'end_date' => CarbonImmutable::parse('2026-10-10'),
                'no_of_days' => 10,
                'status' => WorkflowActionEnum::PENDING->value,
            ],
            [
                'start_date' => CarbonImmutable::parse('2026-11-02'),
                'end_date' => CarbonImmutable::parse('2026-11-02'),
                'no_of_days' => 1,
                'status' => WorkflowActionEnum::PENDING->value,
            ],
            [
                'start_date' => CarbonImmutable::parse('2026-12-03'),
                'end_date' => CarbonImmutable::parse('2026-12-03'),
                'no_of_days' => 1,
                'status' => WorkflowActionEnum::REJECTED->value,
            ],
            [
                'start_date' => CarbonImmutable::parse('2026-09-04'),
                'end_date' => CarbonImmutable::parse('2026-09-04'),
                'no_of_days' => 1,
                'status' => WorkflowActionEnum::APPROVED->value,
            ],
            [
                'start_date' => CarbonImmutable::parse('2026-12-01'),
                'end_date' => CarbonImmutable::parse('2026-12-05'),
                'no_of_days' => 5,
                'status' => WorkflowActionEnum::PENDING->value,
            ],
        ))
        ->create([
            'employee_id' => $employee->id,
            'leave_type_id' => $type->id,
        ]);

    $balance = LeaveBalance::factory()->create([
        'employee_id' => $employee->id,
        'leave_type_id' => $type->id,
        'available_days' => 24,
    ]);

    $pending = $requests->filter(
        fn ($request): bool => $request->status === WorkflowActionEnum::PENDING->value
    )->reduce(
        fn ($carry, $request): float|int|array => $carry + $request->no_of_days
    );

    $startDate = CarbonImmutable::today();
    $endDate = CarbonImmutable::parse('2026-12-31');
    $difference = $startDate->diffInDays($endDate);
    $accrue = (int) ceil($policy->days_per_year * $difference / 12 / 30);

    $annualLeaveBalance = resolve(LeaveService::class)
        ->getAnnualLeaveBalance($employee, $endDate);

    expect($annualLeaveBalance)->toBe($balance->available_days + $accrue - $pending);
});

it('gets the leave policies for an employee', function (): void {
    $employee = Employee::factory()->create();
    $type = LeaveType::factory()->create();
    $policy = LeavePolicy::factory()->create([
        'leave_type_id' => $type->id,
        'days_per_year' => 21,
    ]);
    $storedEmployeePolicy = EmployeeLeavePolicy::factory()->create([
        'employee_id' => $employee->id,
        'leave_policy_id' => $policy->id,
        'end_date' => null,
    ]);

    $employeePolicy = resolve(LeaveService::class)
        ->getEmployeeCurrentAnnualLeavePolicy($employee);

    expect($storedEmployeePolicy->is($employeePolicy))->toBeTrue();
    expect($employeePolicy->policy->days_per_year)->toBe(21);
});
