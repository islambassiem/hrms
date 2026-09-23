<?php

use App\Actions\Workflow\WorkflowStepCreateAction;
use App\Actions\Workflow\WorkflowStepUpdateAction;
use App\Data\Workflow\WorkflowStepData;
use App\Models\Workflow\WorkflowStep;

it('creates a workflow step', function (): void {
    $step = resolve(WorkflowStepCreateAction::class)->handle(
        WorkflowStepData::from(
            WorkflowStep::factory()->make()
        )
    );

    expect($step)->toBeInstanceOf(WorkflowStep::class);
    $this->assertDatabaseHas('workflow_steps', $step->getAttributes());
});

test('action fails when :dataset', function (array $overrides, array $fields): void {
    expectValidationError(
        fn () => resolve(WorkflowStepCreateAction::class)->handle(
            WorkflowStepData::from(
                WorkflowStep::factory()->make($overrides)
            )
        ),
        $fields
    );
})->with('Workflow Step Dataset');

it('updates a workflow step', function (): void {
    $updated = resolve(WorkflowStepUpdateAction::class)->handle(
        WorkflowStep::factory()->create(),
        WorkflowStepData::from(
            WorkflowStep::factory()->make()
        ));

    expect($updated)->toBeInstanceOf(WorkflowStep::class);
    $this->assertDatabaseHas('workflow_steps', $updated->getAttributes());
});

it('fails to update when :dataset', function (array $overrides, array $fields): void {
    expectValidationError(
        fn () => resolve(WorkflowStepUpdateAction::class)->handle(
            WorkflowStep::factory()->create(),
            WorkflowStepData::from(
                WorkflowStep::factory()->make($overrides)
            )
        ),
        $fields
    );
})->with('Workflow Step Dataset');

dataset('Workflow Step Dataset', [
    ...invalid('workflow_id')
        ->required()
        ->notInteger()
        ->build(),

    ...invalid('name_en')
        ->required()
        ->notString()
        ->tooLong(255)
        ->build(),

    ...invalid('name_ar')
        ->required()
        ->notString()
        ->tooLong(255)
        ->build(),

    ...invalid('code')
        ->notString()
        ->tooLong(255)
        ->build(),

    ...invalid('description')
        ->notString()
        ->build(),

    ...invalid('step_order')
        ->required()
        ->notInteger()
        ->build(),

    ...invalid('role_id')
        ->required()
        ->notInteger()
        ->build(),
]);
