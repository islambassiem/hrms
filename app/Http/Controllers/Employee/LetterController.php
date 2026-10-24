<?php

namespace App\Http\Controllers\Employee;

use App\Actions\Request\Letter\CreateLetterAction;
use App\Actions\Request\Letter\DeleteLetterAction;
use App\Actions\Request\Letter\UpdateLetterAction;
use App\Data\Request\Letter\LetterData;
use App\Exceptions\CannotDeleteRecord;
use App\Exceptions\CannotUpdateRecord;
use App\Http\Requests\Employee\Request\Letter\StoreLetterRequest;
use App\Http\Requests\Employee\Request\Letter\UpdateLetterRequest;
use App\Http\Resources\Employee\LetterResource;
use App\Models\Request\Letter;
use App\Queries\Request\Letter\EmployeeLetterQuery;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Http\RedirectResponse;
use Inertia\Inertia;
use Inertia\Response;

class LetterController
{
    use AuthorizesRequests;

    /**
     * Display a listing of the resource.
     */
    public function index(): Response
    {
        $this->authorize('viewAny', Letter::class);

        $letters = LetterResource::collection(
            resolve(EmployeeLetterQuery::class)
                ->run(
                    auth()->user()?->employee
                )->paginate()
        );

        return Inertia::render('employee/request/letter/index', [
            'letters' => $letters,
        ]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create(): Response
    {
        return Inertia::render('employee/request/letter/create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreLetterRequest $request): RedirectResponse
    {
        $this->authorize('create', Letter::class);

        resolve(CreateLetterAction::class)
            ->handle(
                LetterData::from($request)
            );

        Inertia::flash('toast', [
            'type' => 'success',
            'message' => __('The letter stored successfully'),
        ]);

        return back();
    }

    /**
     * Display the specified resource.
     */
    public function show(Letter $letter): Response
    {
        $this->authorize('view', $letter);

        return Inertia::render('employee/request/letter/show', [
            'letter' => LetterResource::make($letter),
        ]);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Letter $letter): Response
    {
        return Inertia::render('employee/request/letter/edit');
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateLetterRequest $request, Letter $letter): RedirectResponse
    {
        $this->authorize('update', $letter);
        try {
            resolve(UpdateLetterAction::class)
                ->handle(
                    $letter,
                    LetterData::from($request)
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
            'message' => __('The letter updated successfully'),
        ]);

        return back();
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Letter $letter): RedirectResponse
    {
        $this->authorize('delete', $letter);

        try {
            resolve(DeleteLetterAction::class)
                ->handle($letter);
        } catch (CannotDeleteRecord $cannotDeleteRecord) {

            Inertia::flash('toast', [
                'type' => 'error',
                'message' => $cannotDeleteRecord->getMessage(),
            ]);

            return back();
        }

        Inertia::flash('toast', [
            'type' => 'success',
            'message' => __('Letter was deleted successfully'),
        ]);

        return back();
    }
}
