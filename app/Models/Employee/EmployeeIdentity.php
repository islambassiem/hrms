<?php

declare(strict_types=1);

namespace App\Models\Employee;

use App\Concerns\UserStamp;
use App\Models\Lookup\IdentityType;
use Database\Factories\Employee\EmployeeIdentityFactory;
use Illuminate\Database\Eloquent\Attributes\Fillable;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

#[Fillable([
    'employee_id',
    'identity_type_id',
    'identity_number',
    'place_of_issue',
    'issue_date',
    'expiry_date',
    'created_by',
    'updated_by',
])]
/**
 * @property-read CarbonImmutable|null $issue_date
 * @property-read CarbonImmutable|null $expiry_date
 */
final class EmployeeIdentity extends Model
{
    /** @use HasFactory<EmployeeIdentityFactory> */
    use HasFactory;

    use UserStamp;

    /**
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            'issue_date' => 'immutable_date',
            'expiry_date' => 'immutable_date',
        ];
    }

    /**
     * @return BelongsTo<IdentityType, $this>
     */
    public function type(): BelongsTo
    {
        return $this->belongsTo(IdentityType::class, 'identity_type_id');
    }
}
