<?php

use App\Concerns\HasLocalizedName;

arch()->preset()->php();
arch()->preset()->security();
arch()->preset()->laravel();

arch('lookup models use HasLocalizedName trait')
    ->expect(fn (): string => "\App\Models\Lookup")
    ->toUseTrait(HasLocalizedName::class);
