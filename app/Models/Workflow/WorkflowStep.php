<?php

declare(strict_types=1);

namespace App\Models\Workflow;

use App\Concerns\UserStamp;
use Database\Factories\Workflow\WorkflowStepFactory;
use Illuminate\Database\Eloquent\Attributes\Fillable;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

#[Fillable([
    'workflow_id',
    'name_en',
    'name_ar',
    'code',
    'description',
    'step_order',
    'role_id',
    'created_by',
    'updated_by',
])]
class WorkflowStep extends Model
{
    /** @use HasFactory<WorkflowStepFactory> */
    use HasFactory;

    use UserStamp;
}
