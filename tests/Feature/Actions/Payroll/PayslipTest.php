<?php

use App\Actions\Payroll\PayslipCreateAction;
use App\Actions\Payroll\PayslipUpdateAction;
use App\Data\Payroll\PayslipData;
use App\Models\Payroll\PayrollPayslip;

it('creates a payslip', function (): void {
    $data = PayslipData::from(PayrollPayslip::factory()->make());
    $payslip = resolve(PayslipCreateAction::class)->handle($data);

    expect($payslip)->toBeInstanceOf(PayrollPayslip::class);
    $this->assertDatabaseHas('payroll_payslips', $payslip->getAttributes());
});

test('action fails when employee already has a payslip in the same run', function (): void {
    $existingPayslip = PayrollPayslip::factory()->create();

    $data = PayslipData::from(
        PayrollPayslip::factory()->make([
            'run_id' => $existingPayslip->run_id,
            'employee_id' => $existingPayslip->employee_id,
        ])
    );

    expectValidationError(
        fn () => resolve(PayslipCreateAction::class)->handle($data),
        ['employee_id'],
    );
});

test('action fails when :dataset', function (array $overrides, array $fields): void {
    expectValidationError(
        fn () => resolve(PayslipCreateAction::class)->handle(
            PayslipData::from(
                PayrollPayslip::factory()->make($overrides)
            )
        ), $fields
    );
})->with('Payslip Dataset');

it('updates a payslip', function (): void {
    $payslip = PayrollPayslip::factory()->create();
    $data = PayslipData::from(PayrollPayslip::factory()->make());
    $updatedPayslip = resolve(PayslipUpdateAction::class)
        ->handle($payslip, $data);

    expect($updatedPayslip->status)->toBe($data->status);
    $this->assertDatabaseHas('payroll_payslips', $updatedPayslip->getAttributes());
});

it('fails to update when :dataset', function (array $overrides, array $fields): void {
    $payslip = PayrollPayslip::factory()->create();
    expectValidationError(
        fn () => resolve(PayslipUpdateAction::class)->handle(
            $payslip,
            PayslipData::from(
                PayrollPayslip::factory()->make($overrides)
            )
        ), $fields
    );
})->with('Payslip Dataset');

dataset('Payslip Dataset', [
    ...invalid('run_id')
        ->required()
        ->notInteger()
        ->build(),

    ...invalid('employee_id')
        ->required()
        ->notInteger()
        ->build(),

    ...invalid('salary_revision_id')
        ->required()
        ->notInteger()
        ->build(),

    ...invalid('days_worked')
        ->notInteger()
        ->build(),

    ...invalid('gross_earnings')
        ->belowMin(0)
        ->build(),

    ...invalid('total_deductions')
        ->belowMin(0)
        ->build(),

    ...invalid('net_pay')
        ->belowMin(0)
        ->build(),

    ...invalid('status')
        ->required()
        ->notString()
        ->tooLong(255)
        ->build(),

    ...invalid('remarks')
        ->notString()
        ->tooLong(255)
        ->build(),
]);
