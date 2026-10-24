<?php

namespace App\Models\Request;

use App\Enums\FamilyVisitStatusEnum;
use App\Models\Employee\Employee;
use Database\Factories\Request\FamilyVisitFactory;
use Illuminate\Database\Eloquent\Attributes\Fillable;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

#[Fillable([
    'employee_id',
    'number',
    'status',
    'created_by',
    'updated_by',
])]

class FamilyVisit extends Model
{
    /** @use HasFactory<FamilyVisitFactory> */
    use HasFactory;

    /**
     * @return array{status: 'App\\Enums\\FamilyVisitStatusEnum'}
     */
    protected function casts(): array
    {
        return [
            'status' => FamilyVisitStatusEnum::class,
        ];
    }

    /**
     * @return BelongsTo<Employee, $this>
     */
    public function employee(): BelongsTo
    {
        return $this->belongsTo(Employee::class);
    }
}
