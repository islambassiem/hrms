<?php

namespace App\Http\Controllers\Employee;

use App\Actions\Leave\LeaveRequestCreateAction;
use App\Actions\Leave\LeaveRequestDeleteAction;
use App\Data\Leave\LeaveRequestData;
use App\Http\Requests\Employee\Leave\StoreLeaveRequest;
use App\Models\Leave\LeaveRequest;
use Inertia\Inertia;
use Inertia\Response;

class LeaveController
{
    public function index(): Response
    {
        return Inertia::render('employee/leave/index');
    }

    public function store(StoreLeaveRequest $request): Response
    {
        $data = LeaveRequestData::from($request);

        resolve(LeaveRequestCreateAction::class)->handle($data, $request->file('attachments'));

        return Inertia::flash('success', __('You applied for a leave successfully'))
            ->render('employee/leave/index');
    }

    public function destroy(LeaveRequest $leave): Response
    {
        resolve(LeaveRequestDeleteAction::class)->handle($leave);

        return Inertia::flash('success', __('You deleted the leave successfully'))
            ->render('employee/leave/index');
    }
}
