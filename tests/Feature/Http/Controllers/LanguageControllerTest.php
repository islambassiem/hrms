<?php

declare(strict_types=1);

use App\Enums\PermissionEnum;
use App\Models\User;
use Inertia\Testing\AssertableInertia as Assert;
use Spatie\Permission\Models\Permission;

it('stores the selected locale in the session and redirects back', function (string $locale): void {
    $user = User::factory()->create();

    $this->actingAs($user)
        ->from(route('dashboard'))
        ->post(route('locale.update', $locale))
        ->assertRedirect(route('dashboard'));

    expect(session('locale'))->toBe($locale);
})->with(['ar', 'en']);

it('rejects an unsupported locale with a 400', function (): void {
    $this->from(route('home'))
        ->post(route('locale.update', 'fr'))
        ->assertBadRequest();

    expect(session('locale'))->toBeNull();
});

it('shares the selected locale on later inertia visits', function (): void {
    $user = User::factory()->create();

    $this->actingAs($user)
        ->from(route('dashboard'))
        ->post(route('locale.update', 'ar'));

    $this->actingAs($user)
        ->get(route('dashboard'))
        ->assertOk()
        ->assertInertia(fn (Assert $page): Assert => $page
            ->where('locale', 'ar')
            ->where('spaces.0.name', 'مساحة الموظف')
        );
});

it('keeps the selected locale when visiting another space', function (): void {
    $user = User::factory()->create();
    Permission::findOrCreate(PermissionEnum::HR_PAGE->value, 'web');
    $user->givePermissionTo(PermissionEnum::HR_PAGE->value);

    $this->actingAs($user)
        ->from(route('dashboard'))
        ->post(route('locale.update', 'ar'));

    $this->actingAs($user)
        ->get(route('hr.dashboard'))
        ->assertOk()
        ->assertInertia(fn (Assert $page): Assert => $page
            ->where('locale', 'ar')
            ->where('spaces.1.name', 'مساحة الموارد البشرية')
        );
});
