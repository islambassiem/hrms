<?php

declare(strict_types=1);

namespace App\Concerns;

use Illuminate\Database\Eloquent\Casts\Attribute;

trait HasLocalizedName
{
    /**
     * @return Attribute<string, never>
     */
    protected function name(): Attribute
    {
        return Attribute::make(
            get: fn () => match (app()->getLocale()) {
                'ar' => $this->name_ar,
                default => $this->name_en,
            },
        );
    }
}
