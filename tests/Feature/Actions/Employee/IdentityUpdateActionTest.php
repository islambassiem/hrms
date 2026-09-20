<?php

declare(strict_types=1);

use App\Actions\Employee\IdentityUpdateAction;
use App\Data\Employee\IdentityData;
use App\Models\Employee\EmployeeIdentity;
use App\Models\User;
use Illuminate\Validation\ValidationException;

it('updates an identity with authenticated user', function (): void {
    $user = User::factory()->create();
    $identity = EmployeeIdentity::factory()->create(['place_of_issue' => 'Riyadh']);

    $this->actingAs($user);

    $data = IdentityData::from([
        ...$identity->toArray(),
        'place_of_issue' => 'Jeddah',
    ]);

    $action = new IdentityUpdateAction;
    $updatedIdentity = $action->handle($identity, $data);

    expect($updatedIdentity->place_of_issue)->toBe('Jeddah');

    $this->assertDatabaseHas('employee_identities', [
        'id' => $identity->id,
        'place_of_issue' => 'Jeddah',
        'updated_by' => $user->id,
    ]);
});

it('allows keeping the same identity_number when updating', function (): void {
    $identity = EmployeeIdentity::factory()->create(['identity_number' => '1010101010']);

    $data = IdentityData::from([
        ...$identity->toArray(),
        'identity_number' => '1010101010',
        'place_of_issue' => 'Dammam',
    ]);

    $action = new IdentityUpdateAction;
    $updatedIdentity = $action->handle($identity, $data);

    expect($updatedIdentity->place_of_issue)->toBe('Dammam');
});

it('fails validation when updating with an identity_number assigned to another identity', function (): void {
    $identity1 = EmployeeIdentity::factory()->create(['identity_number' => '1111111111']);
    $identity2 = EmployeeIdentity::factory()->create(['identity_number' => '2222222222']);

    $data = IdentityData::from([
        ...$identity2->toArray(),
        'identity_number' => '1111111111',
    ]);

    $action = new IdentityUpdateAction;
    $action->handle($identity2, $data);
})->throws(ValidationException::class);
