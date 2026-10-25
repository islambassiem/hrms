<?php

namespace App\Http\Controllers\Employee;

use App\Actions\Request\FamilyVisit\CreateFamilyVisitAction;
use App\Actions\Request\FamilyVisit\DeleteFamilyVisitAction;
use App\Actions\Request\FamilyVisit\UpdateFamilyVisitAction;
use App\Data\Request\FamilyVisitData;
use App\Enums\FamilyVisitStatusEnum;
use App\Exceptions\CannotDeleteRecord;
use App\Exceptions\CannotUpdateRecord;
use App\Http\Requests\Employee\Request\FamilyVisit\StoreFamilyVisitRequest;
use App\Http\Requests\Employee\Request\FamilyVisit\UpdateFamilyVisitRequest;
use App\Http\Resources\Employee\FamilyVisitResource;
use App\Models\Employee\Employee;
use App\Models\Request\FamilyVisit;
use App\Models\User;
use App\Queries\Request\FamilyVisit\FamilyVisitQuery;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Inertia\Inertia;
use Inertia\Response;

class FamilyVisitController
{
    use AuthorizesRequests;

    /**
     * Display a listing of the resource.
     */
    public function index(Request $request): Response
    {
        $this->authorize('viewAny', FamilyVisit::class);

        $employee = $this->authenticatedEmployee($request);

        $visits = FamilyVisitResource::collection(
            resolve(FamilyVisitQuery::class)
                ->run(
                    $employee
                )->paginate()
        );

        return Inertia::render('employee/request/family-visit/index', [
            'visits' => $visits,
        ]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create(Request $request): Response
    {
        $this->authorize('create', FamilyVisit::class);

        $this->authenticatedEmployee($request);

        return Inertia::render('employee/request/family-visit/create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreFamilyVisitRequest $request): RedirectResponse
    {
        $this->authorize('create', FamilyVisit::class);

        $employee = $this->authenticatedEmployee($request);

        resolve(CreateFamilyVisitAction::class)
            ->handle(
                FamilyVisitData::from([
                    ...$request->validated(),
                    'employee_id' => $employee->id,
                    'status' => FamilyVisitStatusEnum::PENDING,
                ])
            );

        Inertia::flash('toast', [
            'type' => 'success',
            'message' => __('The visit stored successfully'),
        ]);

        return back();
    }

    /**
     * Display the specified resource.
     */
    public function show(FamilyVisit $familyVisit): Response
    {
        $this->authorize('view', $familyVisit);

        return Inertia::render('employee/request/family-visit/show', [
            'visit' => FamilyVisitResource::make($familyVisit),
        ]);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(FamilyVisit $familyVisit): Response
    {
        $this->authorize('update', $familyVisit);

        return Inertia::render('employee/request/family-visit/edit');
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateFamilyVisitRequest $request, FamilyVisit $familyVisit): RedirectResponse
    {
        $this->authorize('update', $familyVisit);

        try {
            resolve(UpdateFamilyVisitAction::class)
                ->handle(
                    $familyVisit,
                    FamilyVisitData::from([
                        ...$request->validated(),
                        'employee_id' => $familyVisit->employee_id,
                        'status' => $familyVisit->status,
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
            'message' => __('The visit updated successfully'),
        ]);

        return back();
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(FamilyVisit $familyVisit): RedirectResponse
    {
        $this->authorize('delete', $familyVisit);

        try {
            resolve(DeleteFamilyVisitAction::class)
                ->handle($familyVisit);
        } catch (CannotDeleteRecord $cannotDeleteRecord) {

            Inertia::flash('toast', [
                'type' => 'error',
                'message' => $cannotDeleteRecord->getMessage(),
            ]);

            return back();
        }

        Inertia::flash('toast', [
            'type' => 'success',
            'message' => __('Family visit was deleted successfully'),
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
}
