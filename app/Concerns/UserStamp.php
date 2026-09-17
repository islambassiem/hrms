<?php

declare(strict_types=1);

namespace App\Concerns;

use App\Models\User;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Support\Facades\Auth;

/**
 * @property int|null $created_by
 * @property int|null $updated_by
 * @property-read User|null $creator
 * @property-read User|null $editor
 */
trait UserStamp
{
    public static function bootUserStamp(): void
    {
        static::creating(function (self $model): void {
            if (! $model->isDirty('created_by')) {
                $model->created_by = (int) Auth::id() ?: null;
            }

            if (! $model->isDirty('updated_by')) {
                $model->updated_by = (int) Auth::id() ?: null;
            }
        });

        static::updating(function (self $model): void {
            if (! $model->isDirty('updated_by')) {
                $model->updated_by = (int) Auth::id() ?: null;
            }
        });
    }

    /**
     * @return BelongsTo<User, $this>
     */
    public function creator(): BelongsTo
    {
        return $this->belongsTo(User::class, 'created_by');
    }

    /**
     * @return BelongsTo<User, $this>
     */
    public function editor()
    {
        return $this->belongsTo(User::class, 'updated_by');
    }
}
