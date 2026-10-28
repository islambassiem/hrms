<?php

namespace App\Models\Request;

use App\Concerns\UserStamp;
use App\Enums\VisaPayerEnum;
use App\Enums\VisaPaymentEnum;
use App\Enums\VisaStatusEnum;
use App\Models\Employee\Employee;
use Database\Factories\Request\VisaFactory;
use Illuminate\Database\Eloquent\Attributes\Fillable;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

#[Fillable([
    'employee_id',
    'start_date',
    'end_date',
    'for_year',
    'status',
    'payment',
    'payer',
    'created_by',
    'updated_by',
])]
class Visa extends Model
{
    /** @use HasFactory<VisaFactory> */
    use HasFactory;

    use UserStamp;

    /**
     * @return array{
     *  "start_date": string,
     *  "end_date": string,
     *  payer: 'App\\Enums\\VisaPayerEnum',
     *  payment: 'App\\Enums\\VisaPaymentEnum',
     *  status: 'App\\Enums\\VisaStatusEnum',
     * }
     */
    protected function casts(): array
    {
        return [
            'start_date' => 'immutable_date',
            'end_date' => 'immutable_date',
            'status' => VisaStatusEnum::class,
            'payment' => VisaPaymentEnum::class,
            'payer' => VisaPayerEnum::class,
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
