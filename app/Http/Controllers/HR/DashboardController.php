<?php

declare(strict_types=1);

namespace App\Http\Controllers\HR;

use Inertia\Inertia;
use Inertia\Response;

final class DashboardController
{
    public function index(): Response
    {
        return Inertia::render('hr/dashboard', [
            'hrDashboard' => null,
        ]);
    }
}
