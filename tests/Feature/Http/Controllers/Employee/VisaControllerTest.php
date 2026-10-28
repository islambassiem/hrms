<?php

use App\Enums\VisaPayerEnum;
use App\Enums\VisaPaymentEnum;
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
            ->where('initialForm.mode', null)
            ->where('initialForm.visa', null)
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
            ->has('visas.data.0.for_year')
            ->has('visas.data.0.start_date')
            ->has('visas.data.0.end_date')
            ->has('visas.links')
            ->has('visas.meta')
        );
});

test('users without an employee record cannot view Visa requests', function (): void {
    $user = User::factory()->create();

    Visa::factory()->create();

    $this
        ->actingAs($user)
        ->get(route('visas.index'))
        ->assertForbidden();
});

it('redirects the create route to the index with an open create Sheet state', function (): void {
    $this
        ->actingAs($this->user)
        ->get(route('visas.create'))
        ->assertRedirect(route('visas.index', ['form' => 'create']));

    $this
        ->actingAs($this->user)
        ->get(route('visas.index', ['form' => 'create']))
        ->assertOk()
        ->assertInertia(fn (Assert $page): Assert => $page
            ->component('employee/request/visa/index')
            ->where('initialForm.mode', 'create')
            ->where('initialForm.visa', null)
        );
});

it('redirects the edit route to the index with an authorized edit Sheet state', function (): void {
    $visa = Visa::factory()->create([
        'employee_id' => $this->employee->id,
        'status' => VisaStatusEnum::PENDING,
    ]);

    $this
        ->actingAs($this->user)
        ->get(route('visas.edit', $visa))
        ->assertRedirect(route('visas.index', ['edit' => $visa->id]));

    $this
        ->actingAs($this->user)
        ->get(route('visas.index', ['edit' => $visa->id]))
        ->assertOk()
        ->assertInertia(fn (Assert $page): Assert => $page
            ->component('employee/request/visa/index')
            ->where('initialForm.mode', 'edit')
            ->where('initialForm.visa.id', $visa->id)
        );
});

it('does not open the edit Sheet for a non-pending Visa', function (): void {
    $visa = Visa::factory()->create([
        'employee_id' => $this->employee->id,
        'status' => VisaStatusEnum::PROCESSING,
    ]);

    $this
        ->actingAs($this->user)
        ->get(route('visas.edit', $visa))
        ->assertForbidden();
});

it('redirects the show route to the employee Visa index', function (): void {
    $visa = Visa::factory()->create([
        'employee_id' => $this->employee->id,
    ]);

    $this
        ->actingAs($this->user)
        ->get(route('visas.show', $visa))
        ->assertRedirect(route('visas.index'));
});

it('stores browser date values for the authenticated employee and ignores workflow values', function (): void {
    $otherEmployee = Employee::factory()->create();

    $this
        ->actingAs($this->user)
        ->post(
            route('visas.store'),
            [
                'employee_id' => $otherEmployee->id,
                'end_date' => '2026-11-15',
                'for_year' => '2026',
                'payment' => VisaPaymentEnum::PAID->value,
                'payer' => VisaPayerEnum::EMPLOYEE->value,
                'start_date' => '2026-10-31',
                'status' => VisaStatusEnum::ISSUED->value,
            ]
        )
        ->assertRedirectBack()
        ->assertInertiaFlash('toast.type', 'success')
        ->assertInertiaFlash(
            'toast.message',
            __('The visa is stored successfully')
        );

    $visa = Visa::query()->latest('id')->firstOrFail();

    expect($visa->employee_id)->toBe($this->employee->id)
        ->and($visa->start_date->toDateString())->toBe('2026-10-31')
        ->and($visa->end_date->toDateString())->toBe('2026-11-15')
        ->and($visa->status)->toBe(VisaStatusEnum::PENDING)
        ->and($visa->payment)->toBe(VisaPaymentEnum::PENDING)
        ->and($visa->payer)->toBe(VisaPayerEnum::COMPANY);
});

it('does not store a Visa request when the authenticated user has no employee record', function (): void {
    $user = User::factory()->create();

    $this
        ->actingAs($user)
        ->post(route('visas.store'), Visa::factory()->make()->toArray())
        ->assertForbidden();
});

it('updates a pending Visa without changing employee or workflow values', function (): void {
    $otherEmployee = Employee::factory()->create();

    $visa = Visa::factory()->create([
        'employee_id' => $this->employee->id,
        'payment' => VisaPaymentEnum::PENDING,
        'payer' => VisaPayerEnum::COMPANY,
        'status' => VisaStatusEnum::PENDING->value,
    ]);

    $this
        ->actingAs($this->user)
        ->put(
            route('visas.update', $visa),
            [
                'employee_id' => $otherEmployee->id,
                'end_date' => '2026-11-15',
                'for_year' => '2026',
                'payment' => VisaPaymentEnum::PAID->value,
                'payer' => VisaPayerEnum::EMPLOYEE->value,
                'start_date' => '2026-10-31',
                'status' => VisaStatusEnum::ISSUED->value,
            ]
        )
        ->assertRedirectBack()
        ->assertInertiaFlash('toast.type', 'success')
        ->assertInertiaFlash('toast.message', __('The visa updated successfully'));

    expect($visa->refresh()->employee_id)->toBe($this->employee->id)
        ->and($visa->status)->toBe(VisaStatusEnum::PENDING)
        ->and($visa->payment)->toBe(VisaPaymentEnum::PENDING)
        ->and($visa->payer)->toBe(VisaPayerEnum::COMPANY);
});

it('fails to update a processing Visa', function (): void {
    $visa = Visa::factory()->create([
        'employee_id' => $this->employee->id,
        'status' => VisaStatusEnum::PROCESSING->value,
    ]);

    $this
        ->actingAs($this->user)
        ->put(
            route('visas.update', $visa),
            [
                'employee_id' => $visa->employee_id,
                'end_date' => '2026-11-15',
                'for_year' => '2026',
                'start_date' => '2026-10-31',
            ]
        )
        ->assertRedirectBack()
        ->assertInertiaFlash('toast.type', 'error')
        ->assertInertiaFlash('toast.message', __('Cannot update a visa unless it is pending'));
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

it('fails to delete a processing Visa', function (): void {
    $visa = Visa::factory()->create([
        'employee_id' => $this->employee->id,
        'status' => VisaStatusEnum::PROCESSING->value,
    ]);

    $this
        ->actingAs($this->user)
        ->delete(route('visas.destroy', $visa))
        ->assertRedirectBack()
        ->assertInertiaFlash('toast.type', 'error')
        ->assertInertiaFlash('toast.message', __('Cannot delete a visa unless it is pending'));
});
