<?php

declare(strict_types=1);

namespace App\Http\Controllers\Employee;

use App\Actions\AttachMediaAction;
use App\Actions\DeleteMediaAction;
use App\Http\Requests\Employee\Qualification\QualificationAttachmentRequest;
use App\Models\Media;
use App\Models\Qualifications\Qualification;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Gate;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;
use UnexpectedValueException;

class QualificationAttachmentController
{
    public function store(QualificationAttachmentRequest $request, Qualification $qualification): RedirectResponse
    {
        Gate::authorize('update', $qualification);

        $attachments = $request->file('attachments');

        throw_unless(\is_array($attachments), UnexpectedValueException::class, 'Qualification attachments must be uploaded as an array.');

        /** @var array<int, UploadedFile> $attachments */
        resolve(AttachMediaAction::class)->handle($qualification, $attachments);

        return back()
            ->with('success', __('Attachment uploaded successfully'));
    }

    public function destroy(
        Qualification $qualification,
        Media $media,
    ): RedirectResponse {
        Gate::authorize('update', $qualification);

        throw_unless($this->belongsToQualification($media, $qualification), NotFoundHttpException::class);

        resolve(DeleteMediaAction::class)->handle($media);

        return back()
            ->with('success', __('Attachment deleted successfully'));
    }

    private function belongsToQualification(
        Media $media,
        Qualification $qualification,
    ): bool {
        return $media->model_type === $qualification->getMorphClass()
            && (int) $media->model_id === $qualification->getKey();
    }
}
