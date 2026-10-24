<?php

declare(strict_types=1);

namespace App\Models\Request;

use App\Concerns\UserStamp;
use App\Enums\LetterStatusEnum;
use App\Models\Employee\Employee;
use Database\Factories\Request\LetterFactory;
use Illuminate\Database\Eloquent\Attributes\Fillable;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

#[Fillable([
    'employee_id',
    'title',
    'description',
    'notes',
    'include_salary',
    'attested',
    'status',
    'created_by',
    'updated_by',
])]
/**
 * @property-read LetterStatusEnum $status
 */
class Letter extends Model
{
    /** @use HasFactory<LetterFactory> */
    use HasFactory;

    use UserStamp;

    /**
     * @return array{status: 'App\\Enums\\LetterStatusEnum'}
     */
    protected function casts(): array
    {
        return [
            'status' => LetterStatusEnum::class,
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
