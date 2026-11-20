<?php

declare(strict_types=1);

use App\Enums\PermissionEnum;
use App\Models\User;
use Inertia\Testing\AssertableInertia as Assert;
use Spatie\Permission\Models\Permission;

test('guests are redirected from the HR dashboard', function (): void {
    $this->get(route('hr.dashboard'))
        ->assertRedirect(route('login'));
});

test('users without the HR permission cannot open the HR dashboard', function (): void {
    $user = User::factory()->create();

    $this->actingAs($user)
        ->get(route('hr.dashboard'))
        ->assertForbidden();
});

test('HR-authorized users receive the unavailable HR dashboard contract', function (): void {
    $user = User::factory()->create();
    $user->givePermissionTo(Permission::findOrCreate(PermissionEnum::HR_PAGE->value, 'web'));

    $this->actingAs($user)
        ->get(route('hr.dashboard'))
        ->assertOk()
        ->assertInertia(fn (Assert $page): Assert => $page
            ->component('hr/dashboard')
            ->where('hrDashboard', null),
        );
});
