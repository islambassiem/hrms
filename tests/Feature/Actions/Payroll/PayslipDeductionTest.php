<?php

use App\Actions\Payroll\PayslipDeductionCreateAction;
use App\Actions\Payroll\PayslipDeductionUpdateAction;
use App\Data\Payroll\PayslipDeductionData;
use App\Models\Payroll\PayslipDeduction;

it('creates a payslip deduction', function (): void {
    $data = PayslipDeductionData::from(PayslipDeduction::factory()->make());

    $payslipDeduction = resolve(PayslipDeductionCreateAction::class)->handle($data);

    expect($payslipDeduction)->toBeInstanceOf(PayslipDeduction::class);
    $this->assertDatabaseHas('payslip_deductions', $payslipDeduction->getAttributes());
});

test('action fails when :dataset', function (array $overrides, array $fields): void {
    expectValidationError(
        fn () => resolve(PayslipDeductionCreateAction::class)->handle(
            PayslipDeductionData::from(
                PayslipDeduction::factory()->make($overrides)
            )
        ),
        $fields
    );
})->with('Payslip Deduction Dataset');

it('updates a payslip deduction', function (): void {
    $updated = resolve(PayslipDeductionUpdateAction::class)->handle(
        PayslipDeduction::factory()->create(),
        PayslipDeductionData::from(
            PayslipDeduction::factory()->make()
        )
    );

    expect($updated)->toBeInstanceOf(PayslipDeduction::class);
    $this->assertDatabaseHas('payslip_deductions', $updated->getAttributes());
});

it('fails to update when :dataset', function (array $overrides, array $fields): void {
    expectValidationError(
        fn () => resolve(PayslipDeductionUpdateAction::class)->handle(
            PayslipDeduction::factory()->create(),
            PayslipDeductionData::from(
                PayslipDeduction::factory()->make($overrides)
            )
        ),
        $fields
    );
})->with('Payslip Deduction Dataset');

dataset('Payslip Deduction Dataset', [
    ...invalid('payslip_id')
        ->required()
        ->notInteger()
        ->build(),

    ...invalid('deduction_id')
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
