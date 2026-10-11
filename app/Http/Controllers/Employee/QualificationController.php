<?php

namespace App\Http\Controllers\Employee;

use App\Actions\Qualification\QualificationCreateAction;
use App\Actions\Qualification\QualificationDeleteAction;
use App\Actions\Qualification\QualificationUpdateAction;
use App\Data\Qualification\QualificationData;
use App\Http\Requests\Employee\Qualification\StoreQualificationRequest;
use App\Http\Requests\Employee\Qualification\UpdateQualificationRequest;
use App\Models\Qualifications\Qualification;
use App\Queries\Qualification\EmployeeQualificationsQuery;
use App\Services\Employee\QualificationFormData;
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

        // TODO return a resource instead
        $qualifications = resolve(EmployeeQualificationsQuery::class)
            ->run(auth()->user()?->employee)->get();

        return Inertia::render('employee/qualification/index', [
            'qualifications' => $qualifications,
        ]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create(): Response
    {
        $this->authorize('create', Qualification::class);

        // TODO returns the data for dropdowns
        return Inertia::render('employee/qualification/create', [
            ...resolve(QualificationFormData::class)->dropdowns(),
        ]);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreQualificationRequest $request): RedirectResponse
    {
        $this->authorize('create', Qualification::class);

        resolve(QualificationCreateAction::class)->handle(
            QualificationData::from($request)
        );

        return back()
            ->with('success', __('The qualification stored successfully'));
    }

    /**
     * Display the specified resource.
     */
    public function show(Qualification $qualification): Response
    {
        $this->authorize('view', $qualification);

        return Inertia::render('employee/qualification/show', [
            'qualification' => $qualification,
        ]);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Qualification $qualification): Response
    {
        $this->authorize('view', $qualification);

        // TODO returns the data for dropdowns
        return Inertia::render('employee/qualification/edit', [
            'qualification' => $qualification,
            ...resolve(QualificationFormData::class)->dropdowns(),
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

        return back()
            ->with('success', __('Qualification updated successfully'));
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
}
