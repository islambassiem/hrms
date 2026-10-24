<?php

use App\Actions\Request\FamilyVisit\CreateFamilyVisitAction;
use App\Actions\Request\FamilyVisit\DeleteFamilyVisitAction;
use App\Actions\Request\FamilyVisit\UpdateFamilyVisitAction;
use App\Data\Request\FamilyVisitData;
use App\Enums\FamilyVisitStatusEnum;
use App\Exceptions\CannotDeleteRecord;
use App\Exceptions\CannotUpdateRecord;
use App\Models\Employee\Employee;
use App\Models\Request\FamilyVisit;

it('creates a family visit request', function (): void {
    $employee = Employee::factory()->create();
    $visit = FamilyVisit::factory()->make([
        'employee_id' => $employee->id,
    ]);

    $created = resolve(CreateFamilyVisitAction::class)->handle(
        FamilyVisitData::from($visit)
    );

    expect($created)->toBeInstanceOf(FamilyVisit::class)
        ->and($created->employee_id)->toBe($employee->id)
        ->and($created->status)->toBe(FamilyVisitStatusEnum::PENDING);
});

it('updates a visit request if it is still pending', function (): void {
    $employee = Employee::factory()->create();
    $visit = FamilyVisit::factory()->create(['status' => FamilyVisitStatusEnum::PENDING->value]);

    $payload = FamilyVisit::factory()->make([
        'employee_id' => $employee->id,
        'status' => FamilyVisitStatusEnum::PENDING->value,
    ]);

    $updated = resolve(UpdateFamilyVisitAction::class)->handle(
        $visit,
        FamilyVisitData::from($payload)
    );
    expect($updated)->toBeInstanceOf(FamilyVisit::class)
        ->and($updated->employee_id)->toBe($employee->id)
        ->and($updated->status)->toBe($payload->status);

});

it('fails to update done visits', function (): void {
    $employee = Employee::factory()->create();
    $visit = FamilyVisit::factory()->create([
        'status' => FamilyVisitStatusEnum::ATTESTED->value,
    ]);

    $payload = FamilyVisit::factory()->make([
        'employee_id' => $employee->id,
    ]);

    expect(
        fn () => resolve(UpdateFamilyVisitAction::class)->handle(
            $visit,
            FamilyVisitData::from($payload)
        ))->toThrow(CannotUpdateRecord::class);
});

it('fails to update', function (array $overrides, array $fields): void {
    expectValidationError(
        fn () => resolve(UpdateFamilyVisitAction::class)->handle(
            FamilyVisit::factory()->create(['status' => FamilyVisitStatusEnum::PENDING->value]),
            FamilyVisitData::from(
                FamilyVisit::factory()->make([
                    ...$overrides,
                    'status' => FamilyVisitStatusEnum::PENDING,
                ])
            )
        ), $fields
    );
})->with('Family visit Dataset');

it('fails to create a visit with invalid data', function (array $overrides, array $fields): void {
    expectValidationError(
        fn () => resolve(CreateFamilyVisitAction::class)->handle(
            FamilyVisitData::from(
                FamilyVisit::factory()->make($overrides)
            )
        ), $fields
    );
})->with('Family visit Dataset');

it('deletes a pending visit request', function (): void {
    $visit = FamilyVisit::factory()->create([
        'status' => FamilyVisitStatusEnum::PENDING->value,
    ]);
    resolve(DeleteFamilyVisitAction::class)->handle($visit);

    $this->assertDatabaseMissing('family_visits', $visit->getAttributes());
});

it('fails to delete a completed visit request', function (): void {
    $visit = FamilyVisit::factory()->create([
        'status' => FamilyVisitStatusEnum::ATTESTED,
    ]);

    expect(fn () => resolve(DeleteFamilyVisitAction::class)->handle($visit))
        ->toThrow(CannotDeleteRecord::class);

    $this->assertDatabaseHas('family_visits', $visit->getAttributes());
});

dataset('Family visit Dataset', [
    ...invalid('employee_id')
        ->required()
        ->notInteger()
        ->build(),

    ...invalid('number')
        ->tooLong(8)
        ->build(),
]);
