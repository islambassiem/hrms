<?php

declare(strict_types=1);

namespace App\Http\Controllers;

use Illuminate\Http\RedirectResponse;

final class LanguageController
{
    /**
     * Persist the selected locale for subsequent requests.
     */
    public function update(string $locale): RedirectResponse
    {
        abort_unless(\in_array($locale, ['en', 'ar'], true), 400);

        session()->put('locale', $locale);

        return back();
    }
}
