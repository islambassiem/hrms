<?php

declare(strict_types=1);

use App\Actions\Leave\EmployeeLeavePolicyCreateAction;
use App\Actions\Leave\EmployeeLeavePolicyUpdateAction;
use App\Actions\Leave\EmployeeSickLeaveCycleCreateAction;
use App\Actions\Leave\EmployeeSickLeaveCycleUpdateAction;
use App\Actions\Leave\LeaveBalanceCreateAction;
use App\Actions\Leave\LeaveBalanceUpdateAction;
use App\Actions\Leave\LeaveEntitlementCreateAction;
use App\Actions\Leave\LeaveEntitlementUpdateAction;
use App\Actions\Leave\LeavePolicyCreateAction;
use App\Actions\Leave\LeavePolicyUpdateAction;
use App\Data\Leave\EmployeeLeavePolicyData;
use App\Data\Leave\EmployeeSickLeaveCycleData;
use App\Data\Leave\LeaveBalanceData;
use App\Data\Leave\LeaveEntitlementData;
use App\Data\Leave\LeavePolicyData;
use App\Models\Employee\Employee;
use App\Models\Leave\LeaveBalance;
use App\Models\Leave\LeaveEntitlement;
use App\Models\Leave\LeavePeriod;
use App\Models\Leave\LeavePolicy;
use App\Models\Lookup\LeaveType;
use Carbon\CarbonImmutable;
use Illuminate\Validation\ValidationException;

function leaveRecordDependencies(): array
{
    $employee = Employee::factory()->create();
    $leaveType = LeaveType::factory()->create();
    $period = LeavePeriod::query()->create(['name_en' => 'Period', 'name_ar' => 'فترة', 'code' => 'PERIOD-'.fake()->unique()->numerify('####'), 'type' => 'calendar_year', 'start_date' => '2026-01-01', 'end_date' => '2026-12-31', 'is_closed' => false]);
    $policy = (new LeavePolicyCreateAction)->handle(new LeavePolicyData($leaveType->id, 'Policy', 'سياسة', 21.0));

    return [$employee, $leaveType, $period, $policy];
}

it('creates and updates a leave policy', function (): void {
    $type = LeaveType::factory()->create();
    $policy = (new LeavePolicyCreateAction)->handle(new LeavePolicyData($type->id, 'Annual', 'سنوية', 21.0));
    $updated = (new LeavePolicyUpdateAction)->handle($policy, new LeavePolicyData($type->id, 'Annual Revised', 'سنوية معدلة', 30.0));
    expect($updated)->toBeInstanceOf(LeavePolicy::class)->and($updated->days_per_year)->toBe(30);
});

it('creates and updates an employee leave policy assignment', function (): void {
    [$employee, $type, $period, $policy] = leaveRecordDependencies();
    $assignment = (new EmployeeLeavePolicyCreateAction)->handle(new EmployeeLeavePolicyData($employee->id, $policy->id, CarbonImmutable::parse('2026-01-01')));
    $updated = (new EmployeeLeavePolicyUpdateAction)->handle($assignment, new EmployeeLeavePolicyData($employee->id, $policy->id, CarbonImmutable::parse('2026-01-01'), CarbonImmutable::parse('2026-12-31')));
    expect($updated->end_date)->toBe('2026-12-31T00:00:00+00:00');
});

it('creates and updates an employee sick leave cycle', function (): void {
    $employee = Employee::factory()->create();
    $cycle = (new EmployeeSickLeaveCycleCreateAction)->handle(new EmployeeSickLeaveCycleData($employee->id, CarbonImmutable::parse('2026-01-01')));
    $updated = (new EmployeeSickLeaveCycleUpdateAction)->handle($cycle, new EmployeeSickLeaveCycleData($employee->id, CarbonImmutable::parse('2026-01-01'), CarbonImmutable::parse('2026-12-31'), 5));
    expect($updated->used_days)->toBe(5);
});

it('creates and updates a leave entitlement', function (): void {
    [$employee, $type, $period, $policy] = leaveRecordDependencies();
    $entitlement = (new LeaveEntitlementCreateAction)->handle(new LeaveEntitlementData($employee->id, $type->id, $policy->id, $period->id, 21.0));
    $updated = (new LeaveEntitlementUpdateAction)->handle($entitlement, new LeaveEntitlementData($employee->id, $type->id, $policy->id, $period->id, 21.0, 10.0));
    expect($entitlement)->toBeInstanceOf(LeaveEntitlement::class)->and($updated->accrued_days)->toBe(10);
});

it('rejects a negative leave balance', function (): void {
    $employee = Employee::factory()->create();
    $type = LeaveType::factory()->create();
    (new LeaveBalanceCreateAction)->handle(new LeaveBalanceData($employee->id, $type->id, -1.0));
})->throws(ValidationException::class);

it('creates and updates a leave balance', function (): void {
    $employee = Employee::factory()->create();
    $type = LeaveType::factory()->create();
    $balance = (new LeaveBalanceCreateAction)->handle(new LeaveBalanceData($employee->id, $type->id, 21.0, 21.0));
    $updated = (new LeaveBalanceUpdateAction)->handle($balance, new LeaveBalanceData($employee->id, $type->id, 18.0, 21.0, 3.0));
    expect($balance)->toBeInstanceOf(LeaveBalance::class)->and($updated->available_days)->toBe(18);
});
