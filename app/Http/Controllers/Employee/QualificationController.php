<?php

namespace App\Http\Controllers\Employee;

use App\Actions\Qualification\QualificationCreateAction;
use App\Actions\Qualification\QualificationDeleteAction;
use App\Actions\Qualification\QualificationUpdateAction;
use App\Data\Qualification\QualificationData;
use App\Http\Requests\Employee\Qualification\StoreQualificationRequest;
use App\Http\Requests\Employee\Qualification\UpdateQualificationRequest;
use App\Http\Resources\Employee\QualificationResource;
use App\Http\Resources\Lookup\QualificationFormDropdown;
use App\Models\Qualifications\Qualification;
use App\Models\User;
use App\Queries\Qualification\EmployeeQualificationsQuery;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Http\RedirectResponse;
use Inertia\Inertia;
use Inertia\Response;

class QualificationController
{
    use AuthorizesRequests;

    /**
     * Display a listing of the resource.
     */
    public function index(): Response
    {
        $this->authorize('viewAny', Qualification::class);

        $authEmployee = auth()->user()?->employee;

        if (! $authEmployee) {
            return Inertia::render('employee/qualification/index', [
                'qualifications' => QualificationResource::collection([]),
                'canCreate' => false,
            ]);
        }

        $qualifications = resolve(EmployeeQualificationsQuery::class)
            ->run($authEmployee)->get();

        return Inertia::render('employee/qualification/index', [
            'qualifications' => QualificationResource::collection($qualifications),
            'canCreate' => true,
        ]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create(): Response
    {
        $this->authorize('create', Qualification::class);

        $user = auth()->user();

        abort_unless(
            $user instanceof User && $user->employee()->exists(),
            403,
        );

        return Inertia::render('employee/qualification/create', [
            'props' => resolve(QualificationFormDropdown::class)->dropdowns(),
        ]);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreQualificationRequest $request): RedirectResponse
    {
        $this->authorize('create', Qualification::class);

        resolve(QualificationCreateAction::class)->handle(
            QualificationData::from($request),
            $request->file('attachments'),
        );

        Inertia::flash('toast', [
            'type' => 'success',
            'message' => __('The qualification stored successfully'),
        ]);

        return back();
    }

    /**
     * Display the specified resource.
     */
    public function show(Qualification $qualification): Response
    {
        $this->authorize('view', $qualification);

        return Inertia::render('employee/qualification/show', [
            'qualification' => $this->qualificationResource($qualification),
        ]);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Qualification $qualification): Response
    {
        $this->authorize('view', $qualification);

        return Inertia::render('employee/qualification/edit', [
            'qualification' => $this->qualificationResource($qualification),
            'props' => resolve(QualificationFormDropdown::class)->dropdowns(),
        ]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateQualificationRequest $request, Qualification $qualification): RedirectResponse
    {
        $this->authorize('update', $qualification);

        resolve(QualificationUpdateAction::class)
            ->handle(
                $qualification,
                QualificationData::from($request)
            );

        Inertia::flash('toast', [
            'type' => 'success',
            'message' => __('Qualification updated successfully'),
        ]);

        return back();
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Qualification $qualification): RedirectResponse
    {
        $this->authorize('delete', $qualification);

        resolve(QualificationDeleteAction::class)
            ->handle($qualification);

        return back()
            ->with(
                'success',
                __('Qualification was deleted successfully')
            );
    }

    /**
     * @return array<string, mixed>
     */
    private function qualificationResource(Qualification $qualification): array
    {
        /** @var array<string, mixed> $resource */
        $resource = QualificationResource::make(
            $qualification->loadMissing(EmployeeQualificationsQuery::resourceRelations()),
        )->resolve(request());

        return $resource;
    }
}
