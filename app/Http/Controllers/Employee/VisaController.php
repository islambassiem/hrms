<?php

namespace App\Http\Controllers\Employee;

use App\Actions\Request\Visa\CreateVisaAction;
use App\Actions\Request\Visa\DeleteVisaAction;
use App\Actions\Request\Visa\UpdateVisaAction;
use App\Data\Request\VisaData;
use App\Exceptions\CannotDeleteRecord;
use App\Exceptions\CannotUpdateRecord;
use App\Http\Requests\Employee\Request\Visa\StoreVisaRequest;
use App\Http\Requests\Employee\Request\Visa\UpdateVisaRequest;
use App\Http\Resources\Employee\VisaResource;
use App\Models\Request\Visa;
use App\Queries\Request\Visa\EmployeeVisaQuery;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Http\RedirectResponse;
use Inertia\Inertia;
use Inertia\Response;

class VisaController
{
    use AuthorizesRequests;

    /**
     * Display a listing of the resource.
     */
    public function index(): Response
    {
        $this->authorize('viewAny', Visa::class);

        $visas = VisaResource::collection(resolve(EmployeeVisaQuery::class)
            ->run(auth()->user()?->employee)
            ->paginate());

        return Inertia::render('employee/request/visa/index', [
            'visas' => $visas,
        ]);

    }

    /**
     * Show the form for creating a new resource.
     */
    public function create(): Response
    {
        $this->authorize('create', Visa::class);

        return Inertia::render('employee/request/visa/create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreVisaRequest $request): RedirectResponse
    {
        $this->authorize('create', Visa::class);

        resolve(CreateVisaAction::class)->handle(
            VisaData::from($request->validated())
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
    public function show(Visa $visa): Response
    {
        $this->authorize('view', $visa);
        

        return Inertia::render('employee/request/visa/show', [
            'letter' => VisaResource::make($visa),
        ]);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Visa $visa): Response
    {
        $this->authorize('update', $visa);

        return Inertia::render('employee/request/visa/edit', [
            'visa' => VisaResource::make($visa),
        ]);
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
                    VisaData::from($request)
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
}
