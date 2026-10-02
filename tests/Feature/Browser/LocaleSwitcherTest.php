<?php

use App\Models\User;

it('allows an authenticated user to switch from English to Arabic', function (): void {
    $user = User::factory()->create();

    $page = visit('/login');

    $page
        ->fill('input[name="email"]', $user->email)
        ->fill('input[name="password"]', 'password')
        ->click('button[type="submit"]')
        ->assertPathIs('/dashboard');

    $page->assertVisible('html[lang="en"][dir="ltr"]');

    $page->click('[aria-label="Switch to Arabic"]');

    $page->assertVisible('html[lang="ar"][dir="rtl"]');
});

it('allows an authenticated user to switch from Arabic to English', function (): void {
    $user = User::factory()->create();

    $page = visit('/login');

    $page
        ->fill('input[name="email"]', $user->email)
        ->fill('input[name="password"]', 'password')
        ->click('button[type="submit"]')
        ->assertPathIs('/dashboard');

    $page->assertVisible('html[lang="en"][dir="ltr"]');

    $page->click('[aria-label="Switch to Arabic"]');

    $page->assertVisible('html[lang="ar"][dir="rtl"]');

    $page->click('[aria-label="Switch to English"]');

    $page->assertVisible('html[lang="en"][dir="ltr"]');
});

it('persists the selected locale after reloading the dashboard', function (): void {
    $user = User::factory()->create();

    $page = visit('/login');

    $page
        ->fill('input[name="email"]', $user->email)
        ->fill('input[name="password"]', 'password')
        ->click('button[type="submit"]')
        ->assertPathIs('/dashboard');

    $page->click('[aria-label="Switch to Arabic"]');

    $page->assertVisible('html[lang="ar"][dir="rtl"]');

    $page->refresh();

    $page->assertVisible('html[lang="ar"][dir="rtl"]');

    $page->click('[aria-label="Switch to English"]');

    $page->assertVisible('html[lang="en"][dir="ltr"]');

    $page->refresh();

    $page->assertVisible('html[lang="en"][dir="ltr"]');
});
