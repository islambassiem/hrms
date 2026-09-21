<?php

declare(strict_types=1);

use App\Actions\ShortLeave\ShortLeaveRequestCreateAction;
use App\Actions\ShortLeave\ShortLeaveRequestUpdateAction;
use App\Data\ShortLeave\ShortLeaveRequestData;
use App\Models\Employee\Employee;
use App\Models\Lookup\ShortLeaveType;
use App\Models\ShortLeave\ShortLeaveRequest;
use App\Models\User;
use Carbon\CarbonImmutable;
use Illuminate\Validation\ValidationException;

it('creates and updates a short leave request', function (): void {
    $employee = Employee::factory()->create();
    $type = ShortLeaveType::factory()->create();
    $request = (new ShortLeaveRequestCreateAction)->handle(
        new ShortLeaveRequestData($employee->id, $type->id, CarbonImmutable::parse('2026-10-01'), '09:00:00', '11:00:00')
    );
    $updated = (new ShortLeaveRequestUpdateAction)->handle(
        $request,
        new ShortLeaveRequestData($employee->id, $type->id, CarbonImmutable::parse('2026-10-01'), '10:00:00', '12:00:00', 'approved')
    );

    expect($request)->toBeInstanceOf(ShortLeaveRequest::class)
        ->and($updated)->toBeInstanceOf(ShortLeaveRequest::class)
        ->and($updated->status)->toBe('approved');
});

it('rejects an invalid short leave time range', function (): void {
    $employee = Employee::factory()->create();
    $type = ShortLeaveType::factory()->create();
    (new ShortLeaveRequestCreateAction)->handle(
        new ShortLeaveRequestData($employee->id, $type->id, CarbonImmutable::parse('2026-10-01'), '11:00:00', '09:00:00')
    );
})->throws(ValidationException::class);

it('sets audit fields when authenticated user creates and updates a short leave request', function (): void {
    $user = User::factory()->create();
    $this->actingAs($user);

    $employee = Employee::factory()->create();
    $type = ShortLeaveType::factory()->create();

    $request = (new ShortLeaveRequestCreateAction)->handle(
        new ShortLeaveRequestData($employee->id, $type->id, CarbonImmutable::parse('2026-10-01'), '08:00:00', '10:00:00')
    );

    expect($request->created_by)->toBe($user->id)
        ->and($request->updated_by)->toBe($user->id);

    $updated = (new ShortLeaveRequestUpdateAction)->handle(
        $request,
        new ShortLeaveRequestData($employee->id, $type->id, CarbonImmutable::parse('2026-10-01'), '08:30:00', '10:30:00', 'approved')
    );

    expect($updated->updated_by)->toBe($user->id);
});
