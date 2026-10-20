<?php

declare(strict_types=1);

namespace App\Http\Controllers\Employee;

use App\Actions\AttachMediaAction;
use App\Actions\DeleteMediaAction;
use App\Http\Requests\Employee\Qualification\QualificationAttachmentRequest;
use App\Models\Media;
use App\Models\Qualifications\Qualification;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\UploadedFile;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;

class QualificationAttachmentController
{
    use AuthorizesRequests;

    public function store(QualificationAttachmentRequest $request, Qualification $qualification): RedirectResponse
    {
        $this->authorize('update', $qualification);

        $attachments = $request->file('attachments');

        if (! is_array($attachments)) {
            throw new \UnexpectedValueException('Qualification attachments must be uploaded as an array.');
        }

        /** @var array<int, UploadedFile> $attachments */
        resolve(AttachMediaAction::class)->handle($qualification, $attachments);

        return back()
            ->with('success', __('Attachment uploaded successfully'));
    }

    public function destroy(
        Qualification $qualification,
        Media $media,
    ): RedirectResponse {
        $this->authorize('update', $qualification);

        if (! $this->belongsToQualification($media, $qualification)) {
            throw new NotFoundHttpException;
        }

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
