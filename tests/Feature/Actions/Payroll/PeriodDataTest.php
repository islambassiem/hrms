<?php

use App\Actions\Payroll\PeriodCreateAction;
use App\Data\Payroll\PeriodData;
use App\Models\Payroll\PayrollPeriod;

it('creates a payroll period', function (): void {
    $data = PeriodData::from(
        PayrollPeriod::factory()->make()
    );

    $period = resolve(PeriodCreateAction::class)->handle($data);

    expect($period)->toBeInstanceOf(PayrollPeriod::class);
    $this->assertDatabaseHas('payroll_periods', [
        'id' => $period->id,
        'name' => $period->name,
        'status' => $period->status,
    ]);
});

test('action fails when :dataset', function (array $overrides, array $fields): void {
    expectValidationError(
        fn () => resolve(PeriodCreateAction::class)->handle(
            PeriodData::from(
                PayrollPeriod::factory()->make($overrides)
            )
        ),
        $fields
    );
})->with('Period Dataset');

dataset('Period Dataset', [
    ...invalid('name')
        ->required()
        ->notString()
        ->tooLong(255)
        ->build(),

    ...invalid('start_date')
        ->required()
        ->build(),

    ...invalid('end_date')
        ->required()
        ->build(),

    ...invalid('pay_date')
        ->required()
        ->build(),

    ...invalid('status')
        ->required()
        ->notString()
        ->tooLong(255)
        ->build(),
]);
