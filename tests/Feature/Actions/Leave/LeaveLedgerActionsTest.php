<?php

declare(strict_types=1);

use App\Actions\Leave\LeaveCarryoverCreateAction;
use App\Actions\Leave\LeaveCarryoverUpdateAction;
use App\Actions\Leave\LeaveEncashmentCreateAction;
use App\Actions\Leave\LeaveEncashmentUpdateAction;
use App\Actions\Leave\LeaveTransactionCreateAction;
use App\Actions\Leave\LeaveTransactionUpdateAction;
use App\Data\Leave\LeaveCarryoverData;
use App\Data\Leave\LeaveEncashmentData;
use App\Data\Leave\LeaveTransactionData;
use App\Models\Employee\Employee;
use App\Models\Leave\LeaveEntitlement;
use App\Models\Leave\LeavePeriod;
use App\Models\Leave\LeavePolicy;
use App\Models\Lookup\LeaveType;
use Carbon\CarbonImmutable;
use Illuminate\Validation\ValidationException;

function leaveLedgerDependencies(): array
{
    $employee = Employee::factory()->create();
    $type = LeaveType::factory()->create();
    $from = LeavePeriod::query()->create(['name_en' => 'From', 'name_ar' => 'من', 'code' => 'FROM-'.fake()->unique()->numerify('####'), 'type' => 'calendar_year', 'start_date' => '2025-01-01', 'end_date' => '2025-12-31', 'is_closed' => false]);
    $to = LeavePeriod::query()->create(['name_en' => 'To', 'name_ar' => 'إلى', 'code' => 'TO-'.fake()->unique()->numerify('####'), 'type' => 'calendar_year', 'start_date' => '2026-01-01', 'end_date' => '2026-12-31', 'is_closed' => false]);
    $policy = LeavePolicy::query()->create(['leave_type_id' => $type->id, 'name_en' => 'Policy', 'name_ar' => 'سياسة', 'days_per_year' => 21, 'is_default' => false, 'accrual_frequency' => 'monthly', 'period_type' => 'calendar_year', 'allow_accumulation' => false, 'accumulation_periods' => 1, 'allow_management_carryover' => false, 'expire_unused' => true, 'encash_on_termination' => true]);
    $entitlement = LeaveEntitlement::query()->create(['employee_id' => $employee->id, 'leave_type_id' => $type->id, 'leave_policy_id' => $policy->id, 'leave_period_id' => $from->id, 'entitled_days' => 21, 'accrued_days' => 21, 'used_days' => 0, 'expired_days' => 0, 'encashed_days' => 0, 'status' => 'active']);

    return [$employee, $type, $from, $to, $entitlement];
}

it('creates and updates a leave carryover', function (): void {
    [$employee, $type, $from, $to, $entitlement] = leaveLedgerDependencies();
    $carryover = (new LeaveCarryoverCreateAction)->handle(new LeaveCarryoverData($employee->id, $type->id, $from->id, $to->id, $entitlement->id, null, 5.0));
    $updated = (new LeaveCarryoverUpdateAction)->handle($carryover, new LeaveCarryoverData($employee->id, $type->id, $from->id, $to->id, $entitlement->id, null, 5.0, 3.0, 'approved'));

    expect($updated->status)->toBe('approved');
});

it('creates and updates a leave encashment', function (): void {
    [$employee, $type, $from, $to, $entitlement] = leaveLedgerDependencies();
    $encashment = (new LeaveEncashmentCreateAction)->handle(new LeaveEncashmentData($employee->id, $type->id, $entitlement->id, 2.0, 100.0, 200.0));
    $updated = (new LeaveEncashmentUpdateAction)->handle($encashment, new LeaveEncashmentData($employee->id, $type->id, $entitlement->id, 2.0, 100.0, 200.0, 'approved'));

    expect($updated->status)->toBe('approved');
});

it('creates and updates a leave transaction', function (): void {
    [$employee, $type, $from, $to, $entitlement] = leaveLedgerDependencies();
    $transaction = (new LeaveTransactionCreateAction)->handle(new LeaveTransactionData($employee->id, $type->id, $entitlement->id, null, 'accrual', 2.0, CarbonImmutable::parse('2026-01-01')));
    $updated = (new LeaveTransactionUpdateAction)->handle($transaction, new LeaveTransactionData($employee->id, $type->id, $entitlement->id, null, 'leave_taken', -1.0, CarbonImmutable::parse('2026-01-02')));

    expect($updated->transaction_type)->toBe('leave_taken')->and($updated->days)->toBe(-1);
});

it('rejects a carryover to the same period', function (): void {
    [$employee, $type, $from, $to, $entitlement] = leaveLedgerDependencies();
    (new LeaveCarryoverCreateAction)->handle(new LeaveCarryoverData($employee->id, $type->id, $from->id, $from->id, $entitlement->id, null, 5.0));
})->throws(ValidationException::class);
