<?php

declare(strict_types=1);

use App\Models\Lookup\JobTitle;
use Illuminate\Support\Facades\App;

it('returns the localized name', function (string $locale, string $expected): void {
    $jobTitle = JobTitle::factory()->create([
        'name_en' => 'Software Engineer',
        'name_ar' => 'مهندس برمجيات',
    ]);
    App::setLocale($locale);

    expect($jobTitle->name)->toBe($expected);
})->with([
    ['en', 'Software Engineer'],
    ['fr', 'Software Engineer'],
    ['ar', 'مهندس برمجيات'],
]);
