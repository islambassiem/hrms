<?php

declare(strict_types=1);

namespace App\Http\Controllers\Employee;

use App\Actions\ShortLeave\ShortLeaveRequestCreateAction;
use App\Actions\ShortLeave\ShortLeaveRequestDeleteAction;
use App\Actions\ShortLeave\ShortLeaveRequestUpdateAction;
use App\Data\ShortLeave\ShortLeaveRequestData;
use App\Data\ShortLeave\ShortLeaveRequestFiltersData;
use App\Exceptions\CannotDeleteRecord;
use App\Exceptions\CannotUpdateRecord;
use App\Http\Requests\Employee\ShortLeave\StoreShortLeaveRequest;
use App\Http\Requests\Employee\ShortLeave\UpdateShortLeaveRequest;
use App\Http\Resources\Employee\ShortLeaveRequestResource;
use App\Http\Resources\Lookup\IdNameResource;
use App\Models\Employee\Employee;
use App\Models\Lookup\ShortLeaveType;
use App\Models\ShortLeave\ShortLeaveRequest;
use App\Models\User;
use App\Queries\ShortLeave\ShortLeaveRequestQuery;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;
use Inertia\Inertia;
use Inertia\Response;

final class ShortLeaveController
{
    use AuthorizesRequests;

    public function index(Request $request): Response
    {
        $this->authorize('viewAny', ShortLeaveRequest::class);

        $employee = $this->authenticatedEmployee($request);
        $filters = $this->filters($request, $employee);
        $editingShortLeave = $this->editingShortLeave($request, $employee);
        $shortLeaveTypes = ShortLeaveType::query()
            ->orderBy('sort_order')
            ->orderBy('id')
            ->get();

        return Inertia::render('employee/short-leave/index', [
            'initialForm' => [
                'mode' => $editingShortLeave instanceof ShortLeaveRequest
                    ? 'edit'
                    : ($shortLeaveTypes->isNotEmpty()
                        && $request->string('form')->value() === 'create'
                        ? 'create'
                        : null),
                'shortLeave' => $editingShortLeave instanceof ShortLeaveRequest
                    ? ShortLeaveRequestResource::make(
                        $editingShortLeave->load('shortLeaveType'),
                    )->resolve($request)
                    : null,
            ],
            'filters' => [
                'fromDate' => $filters->fromDate?->toDateString(),
                'shortLeaveTypeId' => $filters->shortLeaveTypeId,
                'toDate' => $filters->toDate?->toDateString(),
            ],
            'shortLeaveRequests' => ShortLeaveRequestResource::collection(
                (new ShortLeaveRequestQuery($filters))
                    ->run()
                    ->paginate()
                    ->withQueryString(),
            ),
            'shortLeaveTypes' => IdNameResource::collection($shortLeaveTypes)
                ->resolve($request),
        ]);
    }

    public function create(Request $request): RedirectResponse
    {
        $this->authorize('create', ShortLeaveRequest::class);

        $this->authenticatedEmployee($request);

        return to_route('short-leaves.index', ['form' => 'create']);
    }

    public function store(StoreShortLeaveRequest $request): RedirectResponse
    {
        $this->authorize('create', ShortLeaveRequest::class);

        resolve(ShortLeaveRequestCreateAction::class)->handle(
            ShortLeaveRequestData::from($request->validated()),
        );

        Inertia::flash('toast', [
            'type' => 'success',
            'message' => __('The Short Leave request was created successfully.'),
        ]);

        return back();
    }

    public function show(ShortLeaveRequest $shortLeave): RedirectResponse
    {
        $this->authorize('view', $shortLeave);

        return to_route('short-leaves.index');
    }

    public function edit(ShortLeaveRequest $shortLeave): RedirectResponse
    {
        $this->authorize('update', $shortLeave);

        return to_route('short-leaves.index', ['edit' => $shortLeave->id]);
    }

    public function update(
        UpdateShortLeaveRequest $request,
        ShortLeaveRequest $shortLeave,
    ): RedirectResponse {
        $this->authorize('update', $shortLeave);

        try {
            resolve(ShortLeaveRequestUpdateAction::class)->handle(
                $shortLeave,
                ShortLeaveRequestData::from($request->validated()),
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
            'message' => __('The Short Leave request was updated successfully.'),
        ]);

        return back();
    }

    public function destroy(ShortLeaveRequest $shortLeave): RedirectResponse
    {
        $this->authorize('delete', $shortLeave);

        try {
            resolve(ShortLeaveRequestDeleteAction::class)->handle($shortLeave);
        } catch (CannotDeleteRecord $cannotDeleteRecord) {
            Inertia::flash('toast', [
                'type' => 'error',
                'message' => $cannotDeleteRecord->getMessage(),
            ]);

            return back();
        }

        Inertia::flash('toast', [
            'type' => 'success',
            'message' => __('The Short Leave request was deleted successfully.'),
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

    private function editingShortLeave(
        Request $request,
        Employee $employee,
    ): ?ShortLeaveRequest {
        $shortLeaveId = $request->integer('edit');

        if ($shortLeaveId === 0) {
            return null;
        }

        $shortLeave = ShortLeaveRequest::query()
            ->where('employee_id', $employee->id)
            ->findOrFail($shortLeaveId);

        $this->authorize('update', $shortLeave);

        return $shortLeave;
    }

    private function filters(
        Request $request,
        Employee $employee,
    ): ShortLeaveRequestFiltersData {
        /** @var array{from_date?: string, short_leave_type_id?: int, to_date?: string} $validated */
        $validated = $request->validate([
            'from_date' => ['nullable', 'date'],
            'short_leave_type_id' => [
                'nullable',
                'integer',
                Rule::exists('lookup_short_leave_types', 'id'),
            ],
            'to_date' => ['nullable', 'date', 'after_or_equal:from_date'],
        ]);

        return ShortLeaveRequestFiltersData::from([
            'employeeId' => $employee->id,
            'fromDate' => $validated['from_date'] ?? null,
            'shortLeaveTypeId' => $validated['short_leave_type_id'] ?? null,
            'toDate' => $validated['to_date'] ?? null,
        ]);
    }
}
