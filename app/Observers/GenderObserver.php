<?php

namespace App\Observers;

use App\Concerns\ClearsLookupCache;

class GenderObserver
{
    use ClearsLookupCache;

    protected const string CACHE_KEY = 'genders';
}
