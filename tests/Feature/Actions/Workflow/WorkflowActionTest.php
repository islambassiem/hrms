<?php

use App\Actions\Workflow\WorkflowActionCreateAction;
use App\Actions\Workflow\WorkflowActionUpdateAction;
use App\Data\Workflow\WorkflowActionData;
use App\Models\Workflow\WorkflowAction;

it('creates a workflow action', function (): void {
    $action = resolve(WorkflowActionCreateAction::class)->handle(
        WorkflowActionData::from(
            WorkflowAction::factory()->make()
        )
    );

    expect($action)->toBeInstanceOf(WorkflowAction::class);
    $this->assertDatabaseHas('workflow_actions', $action->getAttributes());
});

test('action fails when :dataset', function (array $overrides, array $fields): void {
    expectValidationError(
        fn () => resolve(WorkflowActionCreateAction::class)->handle(
            WorkflowActionData::from(
                WorkflowAction::factory()->make($overrides)
            )
        ),
        $fields
    );
})->with('Workflow Action Dataset');

it('updates a workflow action', function (): void {

    $updated = resolve(WorkflowActionUpdateAction::class)->handle(
        WorkflowAction::factory()->create(),
        WorkflowActionData::from(
            WorkflowAction::factory()->make()
        )
    );

    expect($updated)->toBeInstanceOf(WorkflowAction::class);
    $this->assertDatabaseHas('workflow_actions', $updated->getAttributes());
});

it('fails to update when :dataset', function (array $overrides, array $fields): void {
    expectValidationError(
        fn () => resolve(WorkflowActionUpdateAction::class)->handle(
            WorkflowAction::factory()->create(),
            WorkflowActionData::from(
                WorkflowAction::factory()->make($overrides)
            )
        ),
        $fields
    );
})->with('Workflow Action Dataset');

dataset('Workflow Action Dataset', [
    ...invalid('workflow_step_id')
        ->required()
        ->notInteger()
        ->build(),

    ...invalid('actionable_type')
        ->required()
        ->notString()
        ->tooLong(255)
        ->build(),

    ...invalid('actionable_id')
        ->required()
        ->notInteger()
        ->build(),

    ...invalid('actor_id')
        ->required()
        ->notInteger()
        ->build(),

    ...invalid('role_id')
        ->required()
        ->notInteger()
        ->build(),

    ...invalid('action')
        ->required()
        ->build(),

    ...invalid('comment')
        ->notString()
        ->build(),
]);
