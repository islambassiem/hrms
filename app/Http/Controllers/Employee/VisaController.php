<?php

namespace App\Http\Controllers\Employee;

use App\Actions\Request\Visa\CreateVisaAction;
use App\Actions\Request\Visa\DeleteVisaAction;
use App\Actions\Request\Visa\UpdateVisaAction;
use App\Data\Request\VisaData;
use App\Enums\VisaStatusEnum;
use App\Exceptions\CannotDeleteRecord;
use App\Exceptions\CannotUpdateRecord;
use App\Http\Requests\Employee\Request\Visa\StoreVisaRequest;
use App\Http\Requests\Employee\Request\Visa\UpdateVisaRequest;
use App\Http\Resources\Employee\VisaResource;
use App\Models\Employee\Employee;
use App\Models\Request\Visa;
use App\Models\User;
use App\Queries\Request\Visa\EmployeeVisaQuery;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Inertia\Inertia;
use Inertia\Response;

class VisaController
{
    use AuthorizesRequests;

    /**
     * Display a listing of the resource.
     */
    public function index(Request $request): Response
    {
        $this->authorize('viewAny', Visa::class);

        $employee = $this->authenticatedEmployee($request);

        $editingVisa = $this->editingVisa($request, $employee);

        $visas = VisaResource::collection(
            resolve(EmployeeVisaQuery::class)
                ->run($employee)
                ->paginate()
        );

        return Inertia::render('employee/request/visa/index', [
            'initialForm' => [
                'mode' => $editingVisa instanceof Visa
                    ? 'edit'
                    : ($request->input('form') === 'create' ? 'create' : null),
                'visa' => $editingVisa instanceof Visa
                    ? VisaResource::make($editingVisa->load('employee'))->resolve($request)
                    : null,
            ],
            'visas' => $visas,
        ]);

    }

    /**
     * Show the form for creating a new resource.
     */
    public function create(Request $request): RedirectResponse
    {
        $this->authorize('create', Visa::class);

        $this->authenticatedEmployee($request);

        return to_route('visas.index', ['form' => 'create']);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreVisaRequest $request): RedirectResponse
    {
        $this->authorize('create', Visa::class);

        $employee = $this->authenticatedEmployee($request);

        resolve(CreateVisaAction::class)->handle(
            VisaData::from([
                ...$request->validated(),
                'employee_id' => $employee->id,
                'status' => null,
                'payment' => null,
                'payer' => null,
            ])
        );

        Inertia::flash('toast', [
            'type' => 'success',
            'message' => __('The visa is stored successfully'),
        ]);

        return back();
    }

    /**
     * Display the specified resource.
     */
    public function show(Visa $visa): RedirectResponse
    {
        $this->authorize('view', $visa);

        return to_route('visas.index');
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Visa $visa): RedirectResponse
    {
        $this->authorize('update', $visa);

        abort_unless($visa->status === VisaStatusEnum::PENDING, 403);

        return to_route('visas.index', ['edit' => $visa->id]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateVisaRequest $request, Visa $visa): RedirectResponse
    {
        $this->authorize('update', $visa);

        try {
            resolve(UpdateVisaAction::class)
                ->handle(
                    $visa,
                    VisaData::from([
                        ...$request->validated(),
                        'employee_id' => $visa->employee_id,
                        'status' => $visa->status,
                        'payment' => $visa->payment,
                        'payer' => $visa->payer,
                    ])
                );
        } catch (CannotUpdateRecord $cannotUpdateRecord) {
            Inertia::flash('toast', [
                'type' => 'error',
                'message' => $cannotUpdateRecord->getMessage(),
            ]);

            return back();
        }

        Inertia::flash('toast', [
            'type' => 'success',
            'message' => __('The visa updated successfully'),
        ]);

        return back();
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Visa $visa): RedirectResponse
    {
        $this->authorize('delete', $visa);

        try {
            resolve(DeleteVisaAction::class)
                ->handle($visa);
        } catch (CannotDeleteRecord $cannotDeleteRecord) {

            Inertia::flash('toast', [
                'type' => 'error',
                'message' => $cannotDeleteRecord->getMessage(),
            ]);

            return back();
        }

        Inertia::flash('toast', [
            'type' => 'success',
            'message' => __('Visa was deleted successfully'),
        ]);

        return back();
    }

    private function authenticatedEmployee(Request $request): Employee
    {
        $user = $request->user();

        abort_unless($user instanceof User, 403);

        $employee = $user->employee;

        abort_unless($employee instanceof Employee, 403);

        return $employee;
    }

    private function editingVisa(Request $request, Employee $employee): ?Visa
    {
        $visaId = $request->integer('edit');

        if ($visaId === 0) {
            return null;
        }

        $visa = Visa::query()
            ->where('employee_id', $employee->id)
            ->findOrFail($visaId);

        $this->authorize('update', $visa);

        abort_unless($visa->status === VisaStatusEnum::PENDING, 403);

        return $visa;
    }
}
