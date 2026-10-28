<?php

use App\Enums\VisaStatusEnum;
use App\Models\Employee\Employee;
use App\Models\Request\Visa;
use App\Models\User;
use Inertia\Testing\AssertableInertia as Assert;

beforeEach(function (): void {
    /** @var object{user: User, employee: Employee} $this */
    $this->user = User::factory()->create();
    $this->employee = Employee::factory()->create([
        'user_id' => $this->user->id,
    ]);
});

test('guests are redirected to login page', function (): void {
    $this->get(route('visas.index'))
        ->assertRedirect(route('login'));
});

test('authenticated users see visas index page', function (): void {
    $this->actingAs($this->user)
        ->get(route('visas.index'))
        ->assertOk()
        ->assertInertia(fn (Assert $page): Assert => $page
            ->component('employee/request/visa/index')
            ->missing('data')
        );
});

test('authenticated users see own visas paginated index page with visa data', function (): void {
    Visa::factory(6)->create([
        'employee_id' => $this->employee->id,
    ]);

    Visa::factory(10)->create();

    $this->actingAs($this->user)
        ->get(route('visas.index'))
        ->assertOk()
        ->assertInertia(fn (Assert $page): Assert => $page
            ->component('employee/request/visa/index')
            ->has('visas.data', 6)
            ->where('visas.data.0.employee.employee_code', $this->employee->employee_code)
            ->has('visas.links')
            ->has('visas.meta')
        );
});

it('renders create page', function (): void {
    $this
        ->actingAs($this->user)
        ->get(route('visas.create'))
        ->assertOk()
        ->assertInertia(fn (Assert $page): Assert => $page
            ->component('employee/request/visa/create')
        );
});

it('stores a vids', function (): void {
    $this
        ->actingAs($this->user)
        ->post(
            route('visas.store'),
            Visa::factory()->make()->toArray()
        )
        ->assertRedirectBack()
        ->assertInertiaFlash('toast.type', 'success')
        ->assertInertiaFlash(
            'toast.message',
            __('The visa is stored successfully')
        );
});

it('updates a pending visa', function (): void {
    $visa = Visa::factory()->create([
        'employee_id' => $this->employee->id,
        'status' => VisaStatusEnum::PENDING->value,
    ]);

    $this
        ->actingAs($this->user)
        ->put(
            route('visas.update', $visa),
            Visa::factory()->make([
                'employee_id' => $visa->employee_id,
            ])->toArray())
        ->assertRedirectBack()
        ->assertInertiaFlash('toast.type', 'success')
        ->assertInertiaFlash('toast.message', __('The visa updated successfully'));
});

it('fails to update an issued visa', function (): void {
    $visa = Visa::factory()->create([
        'employee_id' => $this->employee->id,
        'status' => VisaStatusEnum::ISSUED->value,
    ]);

    $this
        ->actingAs($this->user)
        ->put(
            route('visas.update', $visa),
            Visa::factory()->make([
                'employee_id' => $visa->employee_id,
            ])->toArray())
        ->assertRedirectBack()
        ->assertInertiaFlash('toast.type', 'error')
        ->assertInertiaFlash('toast.message', __('Cannot update the visa after issuing'));
});

it('delets a visa', function (): void {
    $visa = Visa::factory()->create([
        'employee_id' => $this->employee->id,
        'status' => VisaStatusEnum::PENDING->value,
    ]);

    $this
        ->actingAs($this->user)
        ->delete(route('visas.destroy', $visa))
        ->assertRedirectBack()
        ->assertInertiaFlash('toast.type', 'success')
        ->assertInertiaFlash('toast.message', __('Visa was deleted successfully'));
});

it('fails to delete an issued visa', function (): void {
    $visa = Visa::factory()->create([
        'employee_id' => $this->employee->id,
        'status' => VisaStatusEnum::ISSUED->value,
    ]);

    $this
        ->actingAs($this->user)
        ->delete(route('visas.destroy', $visa))
        ->assertRedirectBack()
        ->assertInertiaFlash('toast.type', 'error')
        ->assertInertiaFlash('toast.message', __('Cannot delete the visa after issuing'));
});
