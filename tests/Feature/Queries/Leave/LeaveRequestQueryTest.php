<?php

use App\Data\Leave\LeaveRequestFiltersData;
use App\Models\Employee\Employee;
use App\Models\Leave\LeaveRequest;
use App\Models\Lookup\Department;
use App\Models\Lookup\Gender;
use App\Models\Lookup\LeaveType;
use App\Queries\Leave\LeaveRequestQuery;
use Carbon\CarbonImmutable;

it('returns all leave requests when no filters are provided', function (): void {
    LeaveRequest::factory()->count(3)->create();

    $filters = new LeaveRequestFiltersData;

    $results = (new LeaveRequestQuery($filters))
        ->run()
        ->get();

    expect($results)->toHaveCount(3);
});

it('filters leave requests by employees', function (): void {
    $employee1 = Employee::factory()->create();
    $employee2 = Employee::factory()->create();

    LeaveRequest::factory()->for($employee1)->create();
    LeaveRequest::factory()->for($employee2)->create();

    $filters = new LeaveRequestFiltersData(
        employeeIds: [$employee1->id],
    );

    $results = (new LeaveRequestQuery($filters))
        ->run()
        ->get();

    expect($results)
        ->toHaveCount(1)
        ->and($results->first()->employee_id)
        ->toBe($employee1->id);
});

it('filters leave requests by multiple employees', function (): void {
    $employees = Employee::factory()->count(3)->create();

    foreach ($employees as $employee) {
        LeaveRequest::factory()->for($employee)->create();
    }

    $filters = new LeaveRequestFiltersData(
        employeeIds: [
            $employees[0]->id,
            $employees[2]->id,
        ],
    );

    $results = (new LeaveRequestQuery($filters))
        ->run()
        ->get();

    expect($results)->toHaveCount(2)
        ->and($results->pluck('employee_id')->sort()->values()->all())
        ->toBe([
            $employees[0]->id,
            $employees[2]->id,
        ]);
});

it('filters leave requests by leave types', function (): void {
    $type1 = LeaveType::factory()->create();
    $type2 = LeaveType::factory()->create();

    LeaveRequest::factory()->create([
        'leave_type_id' => $type1->id,
    ]);

    LeaveRequest::factory()->create([
        'leave_type_id' => $type2->id,
    ]);

    $filters = new LeaveRequestFiltersData(
        leaveTypeIds: [$type1->id],
    );

    $results = (new LeaveRequestQuery($filters))
        ->run()
        ->get();

    expect($results)->toHaveCount(1)
        ->and($results->first()->leave_type_id)
        ->toBe($type1->id);
});

it('filters leave requests by department', function (): void {
    $department1 = Department::factory()->create();
    $department2 = Department::factory()->create();

    $employee1 = Employee::factory()->create([
        'department_id' => $department1->id,
    ]);

    $employee2 = Employee::factory()->create([
        'department_id' => $department2->id,
    ]);

    LeaveRequest::factory()->for($employee1)->create();
    LeaveRequest::factory()->for($employee2)->create();

    $filters = new LeaveRequestFiltersData(
        departmentIds: [$department1->id],
    );

    $results = (new LeaveRequestQuery($filters))
        ->run()
        ->get();

    expect($results)->toHaveCount(1)
        ->and($results->first()->employee_id)
        ->toBe($employee1->id);
});

it('filters leave requests by gender', function (): void {
    Gender::factory(2)->create();
    $male = Employee::factory()->create([
        'gender_id' => 1,
    ]);

    $female = Employee::factory()->create([
        'gender_id' => 2,
    ]);

    LeaveRequest::factory()->for($male)->create();
    LeaveRequest::factory()->for($female)->create();

    $filters = new LeaveRequestFiltersData(
        genderIds: [2],
    );

    $results = (new LeaveRequestQuery($filters))
        ->run()
        ->get();

    expect($results)->toHaveCount(1)
        ->and($results->first()->employee_id)
        ->toBe($female->id);
});

it('filters leave requests by multiple statuses', function (): void {
    $pending = LeaveRequest::factory()->create([
        'status' => 'pending',
    ]);

    LeaveRequest::factory()->create([
        'status' => 'approved',
    ]);

    LeaveRequest::factory()->create([
        'status' => 'rejected',
    ]);

    $filters = new LeaveRequestFiltersData(
        statuses: ['pending', 'approved'],
    );

    $results = (new LeaveRequestQuery($filters))
        ->run()
        ->get();

    expect($results)->toHaveCount(2)
        ->and($results->pluck('status')->sort()->values()->all())
        ->toBe([
            'approved',
            'pending',
        ]);
});

it('filters leave requests from a start date', function (): void {
    LeaveRequest::factory()->create([
        'start_date' => '2026-01-01',
    ]);

    $matching = LeaveRequest::factory()->create([
        'start_date' => '2026-02-01',
    ]);

    $filters = new LeaveRequestFiltersData(
        startDate: CarbonImmutable::parse('2026-02-01'),
    );

    $results = (new LeaveRequestQuery($filters))
        ->run()
        ->get();

    expect($results)->toHaveCount(1)
        ->and($results->first()->id)
        ->toBe($matching->id);

    expect($results->first()->start_date->is($matching->start_date))
        ->toBeTrue();
});

it('filters leave requests until an end date', function (): void {
    $matching = LeaveRequest::factory()->create([
        'end_date' => '2026-02-28',
    ]);

    LeaveRequest::factory()->create([
        'end_date' => '2026-03-01',
    ]);

    $filters = new LeaveRequestFiltersData(
        endDate: CarbonImmutable::parse('2026-02-28'),
    );

    $results = (new LeaveRequestQuery($filters))
        ->run()
        ->get();

    expect($results->first()->end_date->is($matching->end_date))
        ->toBeTrue();

    expect($results)->toHaveCount(1)
        ->and($results->first()->id)
        ->toBe($matching->id);
});

it('combines multiple filters', function (): void {
    $department = Department::factory()->create();
    $gender = Gender::factory()->create();

    $employee = Employee::factory()->create([
        'department_id' => $department->id,
        'gender_id' => $gender->id,
    ]);

    $matching = LeaveRequest::factory()->for($employee)->create([
        'status' => 'approved',
        'start_date' => '2026-02-01',
        'end_date' => '2026-02-05',
    ]);

    // Same department, but wrong status
    LeaveRequest::factory()->for($employee)->create([
        'status' => 'pending',
        'start_date' => '2026-02-01',
        'end_date' => '2026-02-05',
    ]);

    // Correct status, but different employee/department
    $otherEmployee = Employee::factory()->create();

    LeaveRequest::factory()->for($otherEmployee)->create([
        'status' => 'approved',
        'start_date' => '2026-02-01',
        'end_date' => '2026-02-05',
    ]);

    $filters = new LeaveRequestFiltersData(
        departmentIds: [$department->id],
        genderIds: [1],
        statuses: ['approved'],
        startDate: CarbonImmutable::parse('2026-01-01'),
        endDate: CarbonImmutable::parse('2026-12-31'),
    );

    $results = (new LeaveRequestQuery($filters))
        ->run()
        ->get();

    expect($results)
        ->toHaveCount(1)
        ->and($results->first()->id)
        ->toBe($matching->id);
});

it('orders leave requests by newest first', function (): void {
    $old = LeaveRequest::factory()->create([
        'created_at' => '2026-01-01 10:00:00',
    ]);

    $new = LeaveRequest::factory()->create([
        'created_at' => '2026-02-01 10:00:00',
    ]);

    $results = (new LeaveRequestQuery(
        new LeaveRequestFiltersData
    ))
        ->run()
        ->get();

    expect($results->pluck('id')->all())
        ->toBe([$new->id, $old->id]);
});
