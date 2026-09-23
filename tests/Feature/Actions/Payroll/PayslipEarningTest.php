<?php

use App\Actions\Payroll\PayslipEarningCreateAction;
use App\Actions\Payroll\PayslipEarningUpdateAction;
use App\Data\Payroll\PayslipEarningData;
use App\Models\Payroll\PayslipEarning;

it('creates a payslip earning', function (): void {
    $payslipEarning = resolve(PayslipEarningCreateAction::class)->handle(
        PayslipEarningData::from(
            PayslipEarning::factory()->make()
        )
    );

    expect($payslipEarning)->toBeInstanceOf(PayslipEarning::class);
    $this->assertDatabaseHas('payslip_earnings', $payslipEarning->getAttributes());
});

test('action fails when :dataset', function (array $overrides, array $fields): void {
    expectValidationError(
        fn () => resolve(PayslipEarningCreateAction::class)->handle(
            PayslipEarningData::from(
                PayslipEarning::factory()->make($overrides)
            )
        ),
        $fields
    );
})->with('Payslip Earning Dataset');

it('updates a payslip earning', function (): void {
    $updated = resolve(PayslipEarningUpdateAction::class)->handle(
        PayslipEarning::factory()->create(),
        PayslipEarningData::from(
            PayslipEarning::factory()->make()
        )
    );

    expect($updated)->toBeInstanceOf(PayslipEarning::class);
    $this->assertDatabaseHas('payslip_earnings', $updated->getAttributes());
});

it('fails to update when :dataset', function (array $overrides, array $fields): void {
    expectValidationError(
        fn () => resolve(PayslipEarningUpdateAction::class)->handle(
            PayslipEarning::factory()->create(),
            PayslipEarningData::from(
                PayslipEarning::factory()->make($overrides)
            )
        ),
        $fields
    );
})->with('Payslip Earning Dataset');

dataset('Payslip Earning Dataset', [
    ...invalid('payslip_id')
        ->required()
        ->notInteger()
        ->build(),

    ...invalid('earning_id')
        ->required()
        ->notInteger()
        ->build(),

    ...invalid('amount')
        ->required()
        ->belowMin(0)
        ->build(),

    ...invalid('description')
        ->notString()
        ->build(),
]);
