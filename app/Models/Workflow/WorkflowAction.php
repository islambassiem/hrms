<?php

declare(strict_types=1);

namespace App\Models\Workflow;

use App\Concerns\UserStamp;
use App\Enums\WorkflowActionEnum;
use Database\Factories\Workflow\WorkflowActionFactory;
use Illuminate\Database\Eloquent\Attributes\Fillable;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

#[Fillable([
    'workflow_step_id',
    'actionable_type',
    'actionable_id',
    'actor_id',
    'role_id',
    'action',
    'comment',
    'created_by',
    'updated_by',
])]
final class WorkflowAction extends Model
{
    /** @use HasFactory<WorkflowActionFactory> */
    use HasFactory;

    use UserStamp;

    protected function casts()
    {
        return [
            'action' => WorkflowActionEnum::class,
        ];
    }
}
