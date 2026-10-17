<?php

namespace App\Http\Controllers\Employee;

use App\Actions\AttachMediaAction;
use App\Actions\DeleteMediaAction;
use App\Http\Requests\Employee\Qualification\QualificationAttachmentRequest;
use App\Models\Media;
use App\Models\Qualifications\Qualification;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Http\RedirectResponse;

class QualificationAttachmentController
{
    use AuthorizesRequests;

    public function store(QualificationAttachmentRequest $request, Qualification $qualification): RedirectResponse
    {
        // TODO : authorize

        resolve(AttachMediaAction::class)->handle(
            $qualification, $request->file('attachments'));

        return back()
            ->with('success', __('Attachment uploaded successfully'));
    }

    public function destroy(Media $media): RedirectResponse
    {
        // TODO : authorize

        resolve(DeleteMediaAction::class)->handle($media);

        return back()
            ->with('success', __('Attachment delted successfully'));
    }
}
