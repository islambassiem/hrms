<?php

namespace App\Concerns;

use Illuminate\Support\Facades\Cache;

trait ClearsLookupCache
{
    protected function clearCache(): void
    {
        Cache::forget(static::CACHE_KEY);
    }

    public function created(): void
    {
        $this->clearCache();
    }

    public function updated(): void
    {
        $this->clearCache();
    }

    public function deleted(): void
    {
        $this->clearCache();
    }
}
