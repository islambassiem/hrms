<?php

use App\Enums\LetterStatusEnum;
use App\Models\Employee\Employee;
use App\Models\Request\Letter;
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
    $this->get(route('letters.index'))
        ->assertRedirect(route('login'));
});

test('authenticated users see letters index page', function (): void {
    $this->actingAs($this->user)
        ->get(route('letters.index'))
        ->assertOk()
        ->assertInertia(fn (Assert $page): Assert => $page
            ->component('employee/request/letter/index')
            ->missing('data')
        );
});

test('authenticated users see own letters paginated index page with letters data', function (): void {
    Letter::factory(5)->create([
        'employee_id' => $this->employee->id,
    ]);

    Letter::factory(10)->create();

    $this->actingAs($this->user)
        ->get(route('letters.index'))
        ->assertOk()
        ->assertInertia(fn (Assert $page): Assert => $page
            ->component('employee/request/letter/index')
            ->has('letters.data', 5)
            ->where('letters.data.0.id', $this->employee->id)
            ->has('letters.links')
            ->has('letters.meta')
        );
});

it('renders create page', function (): void {
    $this
        ->actingAs($this->user)
        ->get(route('letters.create'))
        ->assertOk()
        ->assertInertia(fn (Assert $page): Assert => $page
            ->component('employee/request/letter/create')
        );
});

it('stores a letter', function (): void {
    $this
        ->actingAs($this->user)
        ->post(
            route('letters.store'),
            Letter::factory()->make()->toArray()
        )
        ->assertRedirectBack()
        ->assertInertiaFlash('toast.type', 'success')
        ->assertInertiaFlash(
            'toast.message',
            __('The letter stored successfully')
        );
});

it('updates a pending letter', function (): void {
    $letter = Letter::factory()->create([
        'employee_id' => $this->employee->id,
        'status' => LetterStatusEnum::PENDING->value,
    ]);

    $this
        ->actingAs($this->user)
        ->put(
            route('letters.update', $letter),
            Letter::factory()->make([
                'employee_id' => $letter->employee_id,
            ])->toArray())
        ->assertRedirectBack()
        ->assertInertiaFlash('toast.type', 'success')
        ->assertInertiaFlash('toast.message', __('The letter updated successfully'));
});

it('fails to update a done letter', function (): void {
    $letter = Letter::factory()->create([
        'employee_id' => $this->employee->id,
        'status' => LetterStatusEnum::DONE->value,
    ]);

    $this
        ->actingAs($this->user)
        ->put(
            route('letters.update', $letter),
            Letter::factory()->make([
                'employee_id' => $letter->employee_id,
            ])->toArray())
        ->assertRedirectBack()
        ->assertInertiaFlash('toast.type', 'error')
        ->assertInertiaFlash('toast.message', __('Cannot update the letter after issuing'));
});

it('delets a letter', function (): void {
    $letter = Letter::factory()->create([
        'employee_id' => $this->employee->id,
        'status' => LetterStatusEnum::PENDING->value,
    ]);

    $this
        ->actingAs($this->user)
        ->delete(route('letters.destroy', $letter))
        ->assertRedirectBack()
        ->assertInertiaFlash('toast.type', 'success')
        ->assertInertiaFlash('toast.message', __('Letter was deleted successfully'));
});

it('fails to delete a done letter', function (): void {
    $letter = Letter::factory()->create([
        'employee_id' => $this->employee->id,
        'status' => LetterStatusEnum::DONE->value,
    ]);

    $this
        ->actingAs($this->user)
        ->delete(route('letters.destroy', $letter))
        ->assertRedirectBack()
        ->assertInertiaFlash('toast.type', 'error')
        ->assertInertiaFlash('toast.message', __('The letter is issued already; you cannot delete it'));
});
