<?php

use App\Enums\FamilyVisitStatusEnum;
use App\Models\Employee\Employee;
use App\Models\Request\FamilyVisit;
use App\Models\User;
use Inertia\Testing\AssertableInertia as Assert;

beforeEach(function (): void {
    /** @var object{user: User, employee: Employee} $this */
    $this->user = User::factory()->create();
    $this->employee = Employee::factory()->create([
        'user_id' => $this->user->id,
    ]);
});

test('guests are redirected from the Employee Leave page', function (): void {
    $this->get(route('family-visits.index'))
        ->assertRedirect(route('login'));
});

test('authenticated users see visits index page', function (): void {
    $this->actingAs($this->user)
        ->get(route('family-visits.index'))
        ->assertOk()
        ->assertInertia(fn (Assert $page): Assert => $page
            ->component('employee/request/family-visit/index')
            ->missing('data')
        );
});

test('authenticated users see own visits paginated index page with visits data', function (): void {
    FamilyVisit::factory(5)->create([
        'employee_id' => $this->employee->id,
    ]);

    FamilyVisit::factory(10)->create();

    $this->actingAs($this->user)
        ->get(route('family-visits.index'))
        ->assertOk()
        ->assertInertia(fn (Assert $page): Assert => $page
            ->component('employee/request/family-visit/index')
            ->has('visits.data', 5)
            ->where('visits.data.0.employee.id', $this->employee->id)
            ->has('visits.links')
            ->has('visits.meta')
        );
});

it('renders create page', function (): void {
    $this
        ->actingAs($this->user)
        ->get(route('family-visits.create'))
        ->assertOk()
        ->assertInertia(fn (Assert $page): Assert => $page
            ->component('employee/request/family-visit/create')
        );
});

it('stores a visit', function (): void {
    $this
        ->actingAs($this->user)
        ->post(
            route('family-visits.store'),
            FamilyVisit::factory()->make()->toArray()
        )
        ->assertRedirectBack()
        ->assertInertiaFlash('toast.type', 'success')
        ->assertInertiaFlash(
            'toast.message',
            __('The visit stored successfully')
        );
});

it('updates a pending visit', function (): void {
    $familyVisit = FamilyVisit::factory()->create([
        'employee_id' => $this->employee->id,
        'status' => FamilyVisitStatusEnum::PENDING->value,
    ]);

    $this
        ->actingAs($this->user)
        ->put(
            route('family-visits.update', $familyVisit),
            FamilyVisit::factory()->make([
                'employee_id' => $familyVisit->employee_id,
            ])->toArray())
        ->assertRedirectBack()
        ->assertInertiaFlash('toast.type', 'success')
        ->assertInertiaFlash('toast.message', __('The visit updated successfully'));
});

it('fails to update an attested visit', function (): void {
    $familyVisit = FamilyVisit::factory()->create([
        'employee_id' => $this->employee->id,
        'status' => FamilyVisitStatusEnum::ATTESTED->value,
    ]);

    $this
        ->actingAs($this->user)
        ->put(
            route('family-visits.update', $familyVisit),
            FamilyVisit::factory()->make([
                'employee_id' => $familyVisit->employee_id,
            ])->toArray())
        ->assertRedirectBack()
        ->assertInertiaFlash('toast.type', 'error')
        ->assertInertiaFlash('toast.message', __('Cannot update the family visit after attestation'));
});

it('delets a visit', function (): void {
    $familyVisit = FamilyVisit::factory()->create([
        'employee_id' => $this->employee->id,
        'status' => FamilyVisitStatusEnum::PENDING->value,
    ]);

    $this
        ->actingAs($this->user)
        ->delete(route('family-visits.destroy', $familyVisit))
        ->assertRedirectBack()
        ->assertInertiaFlash('toast.type', 'success')
        ->assertInertiaFlash('toast.message', __('Family visit was deleted successfully'));
});

it('fails to delete a done letter', function (): void {
    $letter = FamilyVisit::factory()->create([
        'employee_id' => $this->employee->id,
        'status' => FamilyVisitStatusEnum::ATTESTED->value,
    ]);

    $this
        ->actingAs($this->user)
        ->delete(route('family-visits.destroy', $letter))
        ->assertRedirectBack()
        ->assertInertiaFlash('toast.type', 'error')
        ->assertInertiaFlash('toast.message', __('The visit is attested already; you cannot delete it'));
});
