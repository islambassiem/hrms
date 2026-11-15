<?php

namespace App\Lookups;

use App\Models\Lookup\Gender;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Support\Facades\Cache;

class GenderLookup
{
    /**
     * @return Collection<int, Gender>
     */
    public function get(): Collection
    {
        return Cache::rememberForever(
            'genders',
            fn () => Gender::query()
                ->orderBy('sort_order')
                ->orderBy('id')
                ->get(['id', 'name_en', 'name_ar']),
        );
    }
}
