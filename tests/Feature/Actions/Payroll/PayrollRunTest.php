<?php

use App\Actions\Payroll\PayrollRunCreateAction;
use App\Actions\Payroll\PayrollRunUpdateAction;
use App\Data\Payroll\PayrollRunData;
use App\Models\Employee\Employee;
use App\Models\Payroll\PayrollRun;

it('creates a payroll run', function (): void {
    $data = PayrollRunData::from(
        PayrollRun::factory()->make()
    );

    $run = resolve(PayrollRunCreateAction::class)->handle($data);

    expect($run)->toBeInstanceOf(PayrollRun::class);
    $this->assertDatabaseHas('payroll_runs', $run->getAttributes());
});

test('action fails when :dataset', function (array $overrides, array $fields): void {
    expectValidationError(
        fn () => resolve(PayrollRunCreateAction::class)->handle(
            PayrollRunData::from(PayrollRun::factory()->make($overrides))
        ),
        $fields
    );
})->with('Payroll Run Dataset');

it('updates a payroll run', function (): void {
    $newApprover = Employee::factory()->create();

    $updatedRun = resolve(PayrollRunUpdateAction::class)->handle(
        PayrollRun::factory()->create(),
        PayrollRunData::from(PayrollRun::factory()->make())
    );

    expect($updatedRun)->toBeInstanceOf(PayrollRun::class);
    $this->assertDatabaseHas('payroll_runs', $updatedRun->getAttributes());
});

it('fails to update when :dataset', function (array $overrides, array $fields): void {
    expectValidationError(
        fn () => resolve(PayrollRunUpdateAction::class)->handle(
            PayrollRun::factory()->create(),
            PayrollRunData::from(PayrollRun::factory()->make($overrides))
        ),
        $fields
    );
})->with('Payroll Run Dataset');

dataset('Payroll Run Dataset', [
    ...invalid('period_id')
        ->required()
        ->notInteger()
        ->build(),

    ...invalid('run_type')
        ->required()
        ->notString()
        ->tooLong(255)
        ->build(),

    ...invalid('run_date')
        ->required()
        ->build(),

    ...invalid('status')
        ->required()
        ->notString()
        ->tooLong(255)
        ->build(),

    ...invalid('processed_by')
        ->required()
        ->notInteger()
        ->build(),

    ...invalid('approved_by')
        ->required()
        ->notInteger()
        ->build(),

    ...invalid('approved_at')
        ->required()
        ->build(),

    ...invalid('total_gross')
        ->belowMin(0)
        ->build(),

    ...invalid('total_deductions')
        ->belowMin(0)
        ->build(),

    ...invalid('total_net')
        ->belowMin(0)
        ->build(),
]);
