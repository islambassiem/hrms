<?php

use App\Actions\Request\Letter\CreateLetterAction;
use App\Actions\Request\Letter\DeleteLetterAction;
use App\Actions\Request\Letter\UpdateLetterAction;
use App\Data\Request\Letter\LetterData;
use App\Enums\LetterStatusEnum;
use App\Exceptions\CannotDeleteRecord;
use App\Exceptions\CannotUpdateRecord;
use App\Models\Employee\Employee;
use App\Models\Request\Letter;

it('creates a letter request', function (): void {
    $employee = Employee::factory()->create();
    $letter = Letter::factory()->make([
        'employee_id' => $employee->id,
    ]);

    $created = resolve(CreateLetterAction::class)->handle(
        LetterData::from($letter)
    );

    expect($created)->toBeInstanceOf(Letter::class)
        ->and($created->employee_id)->toBe($employee->id)
        ->and($created->status)->toBe(LetterStatusEnum::PENDING);
});

it('updates a letter request if it is still pending', function (): void {
    $employee = Employee::factory()->create();
    $letter = Letter::factory()->create(['status' => LetterStatusEnum::PENDING->value]);

    $payload = Letter::factory()->make([
        'employee_id' => $employee->id,
        'status' => LetterStatusEnum::PENDING->value,
    ]);

    $updated = resolve(UpdateLetterAction::class)->handle(
        $letter,
        LetterData::from($payload)
    );
    expect($updated)->toBeInstanceOf(Letter::class)
        ->and($updated->employee_id)->toBe($employee->id)
        ->and($updated->status)->toBe($payload->status);

});

it('fails to update done letters', function (): void {
    $employee = Employee::factory()->create();
    $letter = Letter::factory()->create([
        'status' => LetterStatusEnum::DONE->value,
    ]);

    $payload = Letter::factory()->make([
        'employee_id' => $employee->id,
    ]);

    expect(
        fn () => resolve(UpdateLetterAction::class)->handle(
            $letter,
            LetterData::from($payload)
        ))->toThrow(CannotUpdateRecord::class);
});

it('fails to update', function (array $overrides, array $fields): void {
    expectValidationError(
        fn () => resolve(UpdateLetterAction::class)->handle(
            Letter::factory()->create(['status' => LetterStatusEnum::PENDING->value]),
            LetterData::from(
                Letter::factory()->make([
                    ...$overrides,
                    'status' => LetterStatusEnum::PENDING,
                ])
            )
        ), $fields
    );
})->with('Letter Dataset');

it('fails to create a letter with invalid data', function (array $overrides, array $fields): void {
    expectValidationError(
        fn () => resolve(CreateLetterAction::class)->handle(
            LetterData::from(
                Letter::factory()->make($overrides)
            )
        ), $fields
    );
})->with('Letter Dataset');

it('deletes a pending letter request', function (): void {
    $letter = Letter::factory()->create([
        'status' => LetterStatusEnum::PENDING->value,
    ]);
    resolve(DeleteLetterAction::class)->handle($letter);

    $this->assertDatabaseMissing('letters', $letter->getAttributes());
});

it('fails to delete a completed letter request', function (): void {
    $letter = Letter::factory()->create([
        'status' => LetterStatusEnum::DONE,
    ]);

    expect(fn () => resolve(DeleteLetterAction::class)->handle($letter))
        ->toThrow(CannotDeleteRecord::class);

    $this->assertDatabaseHas('letters', $letter->getAttributes());
});

dataset('Letter Dataset', [
    ...invalid('employee_id')
        ->required()
        ->notInteger()
        ->build(),

    ...invalid('title')
        ->notString()
        ->tooLong(255)
        ->build(),

    ...invalid('description')
        ->tooLong(1000)
        ->build(),

    ...invalid('notes')
        ->tooLong(1000)
        ->build(),

    ...invalid('include_salary')
        ->notBoolean()
        ->build(),

    ...invalid('attested')
        ->required()
        ->notBoolean()
        ->build(),
]);
