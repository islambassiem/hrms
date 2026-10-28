<?php

use App\Actions\Request\Visa\CreateVisaAction;
use App\Actions\Request\Visa\DeleteVisaAction;
use App\Actions\Request\Visa\UpdateVisaAction;
use App\Data\Request\VisaData;
use App\Enums\VisaPayerEnum;
use App\Enums\VisaPaymentEnum;
use App\Enums\VisaStatusEnum;
use App\Exceptions\CannotDeleteRecord;
use App\Exceptions\CannotUpdateRecord;
use App\Models\Employee\Employee;
use App\Models\Request\Visa;

it('creates a visa request paid by the company for the first time', function (): void {
    $employee = Employee::factory()->create();
    $visa = Visa::factory()->make([
        'employee_id' => $employee->id,
    ]);

    $created = resolve(CreateVisaAction::class)->handle(
        VisaData::from($visa)
    );

    expect($created)->toBeInstanceOf(Visa::class)
        ->and($created->employee_id)->toBe($employee->id)
        ->and($created->payment)->toBe(VisaPaymentEnum::PENDING)
        ->and($created->status)->toBe(VisaStatusEnum::PENDING)
        ->and($created->payer)->toBe(VisaPayerEnum::COMPANY);
});

it('creates a visa request paid by the employee for the second time', function (): void {
    $employee = Employee::factory()->create();
    Visa::factory()->create([
        'employee_id' => $employee->id,
        'for_year' => now()->year,
        'payment' => VisaPaymentEnum::PAID->value,
        'status' => VisaStatusEnum::ISSUED->value,
        'payer' => VisaPayerEnum::COMPANY->value,
    ]);

    $visa = Visa::factory()->make([
        'employee_id' => $employee->id,
        'for_year' => now()->year,
    ]);

    $created = resolve(CreateVisaAction::class)->handle(
        VisaData::from($visa)
    );

    expect($created)->toBeInstanceOf(Visa::class)
        ->and($created->employee_id)->toBe($employee->id)
        ->and($created->payment)->toBe(VisaPaymentEnum::PENDING)
        ->and($created->status)->toBe(VisaStatusEnum::PENDING)
        ->and($created->payer)->toBe(VisaPayerEnum::EMPLOYEE);
});

it('updates a pending visa without changing its workflow fields', function (): void {
    $employee = Employee::factory()->create();
    $visa = Visa::factory()->create([
        'employee_id' => $employee->id,
        'payment' => VisaPaymentEnum::PENDING,
        'payer' => VisaPayerEnum::COMPANY,
        'status' => VisaStatusEnum::PENDING,
    ]);

    $payload = Visa::factory()->make([
        'employee_id' => $employee->id,
        'payment' => VisaPaymentEnum::PAID,
        'payer' => VisaPayerEnum::EMPLOYEE,
        'status' => VisaStatusEnum::ISSUED,
    ]);

    $updated = resolve(UpdateVisaAction::class)->handle(
        $visa,
        VisaData::from($payload)
    );
    expect($updated)->toBeInstanceOf(Visa::class)
        ->and($updated->employee_id)->toBe($employee->id)
        ->and($updated->status)->toBe(VisaStatusEnum::PENDING)
        ->and($updated->payment)->toBe(VisaPaymentEnum::PENDING)
        ->and($updated->payer)->toBe(VisaPayerEnum::COMPANY);

});

it('fails to update a non-pending visa', function (VisaStatusEnum $status): void {
    $employee = Employee::factory()->create();
    $visa = Visa::factory()->create([
        'status' => $status,
    ]);

    $payload = Visa::factory()->make([
        'employee_id' => $employee->id,
    ]);

    expect(
        fn () => resolve(UpdateVisaAction::class)->handle(
            $visa,
            VisaData::from($payload)
        ))->toThrow(CannotUpdateRecord::class);
})->with([
    VisaStatusEnum::PROCESSING,
    VisaStatusEnum::ISSUED,
]);

it('deletes a pending visa request', function (): void {
    $visa = Visa::factory()->create([
        'status' => VisaStatusEnum::PENDING->value,
    ]);
    resolve(DeleteVisaAction::class)->handle($visa);

    $this->assertDatabaseMissing('visas', $visa->getAttributes());
});

it('fails to delete a non-pending visa', function (VisaStatusEnum $status): void {
    $visa = Visa::factory()->create([
        'status' => $status,
    ]);

    expect(fn () => resolve(DeleteVisaAction::class)->handle($visa))
        ->toThrow(CannotDeleteRecord::class);

    $this->assertDatabaseHas('visas', $visa->getAttributes());
})->with([
    VisaStatusEnum::PROCESSING,
    VisaStatusEnum::ISSUED,
]);

it('fails creation with', function (array $overrides, array $fields): void {
    expectValidationError(
        fn () => resolve(CreateVisaAction::class)->handle(
            VisaData::from(
                Visa::factory()->make($overrides)
            )
        ), $fields
    );
})->with('Visa Creation Dataset');

it('fails to update with', function (array $overrides, array $fields): void {
    expectValidationError(
        fn () => resolve(UpdateVisaAction::class)->handle(
            Visa::factory()->create(['status' => VisaStatusEnum::PENDING->value]),
            VisaData::from(
                Visa::factory()->make([...$overrides])
            )
        ), $fields
    );
})->with('Visa Update Dataset');

dataset('Visa Creation Dataset', [

    ...invalid('employee_id')
        ->required()
        ->notInteger()
        ->build(),

    ...invalid('for_year')
        ->required()
        ->notInteger()
        ->build(),

    ...invalid('start_date')
        ->required()
        ->build(),

    ...invalid('end_date')
        ->required()
        ->invalidDateOrder('start_date', 'end_date')
        ->build(),

]);

dataset('Visa Update Dataset', [

    ...invalid('for_year')
        ->required()
        ->notInteger()
        ->build(),

    ...invalid('start_date')
        ->required()
        ->build(),

    ...invalid('end_date')
        ->required()
        ->invalidDateOrder('start_date', 'end_date')
        ->build(),

]);
