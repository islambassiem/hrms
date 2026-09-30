<?php

declare(strict_types=1);

namespace App\Http\Middleware;

use App\Enums\PermissionEnum;
use App\Http\Resources\AuthResource;
use App\Models\User;
use Illuminate\Http\Request;
use Inertia\Middleware;

final class HandleInertiaRequests extends Middleware
{
    /**
     * The root template that's loaded on the first page visit.
     *
     * @see https://inertiajs.com/server-side-setup#root-template
     *
     * @var string
     */
    public $rootView = 'app';

    /**
     * Determines the current asset version.
     *
     * @see https://inertiajs.com/asset-versioning
     */
    public function version(Request $request): ?string
    {
        return parent::version($request);
    }

    /**
     * Define the props that are shared by default.
     *
     * @see https://inertiajs.com/shared-data
     *
     * @return array<string, mixed>
     */
    public function share(Request $request): array
    {
        $user = $request->user();

        return [
            ...parent::share($request),
            'name' => config('app.name'),
            'auth' => [
                'user' => $user ? AuthResource::make($request->user()) : null,
            ],
            'spaces' => fn (): array => $this->spacesFor($user),
            'currentSpace' => fn (): string => match (true) {
                $request->is('hr', 'hr/*') => 'hr',
                $request->is('head', 'head/*') => 'head',
                default => 'employee',
            },
            'sidebarOpen' => ! $request->hasCookie('sidebar_state') || $request->cookie('sidebar_state') === 'true',
        ];
    }

    /**
     * @return array<int, array{
     *     key: string,
     *     name: string,
     *     description: string,
     *     href: string
     * }>
     */
    private function spacesFor(?User $user): array
    {
        if (! $user instanceof User) {
            return [];
        }

        $spaces = [
            [
                'key' => 'employee',
                'name' => 'Employee Space',
                'description' => 'My work & requests',
                'href' => '/dashboard',
                'permission' => null,
            ],
            [
                'key' => 'hr',
                'name' => 'HR Space',
                'description' => 'People & policies',
                'href' => '/hr',
                'permission' => PermissionEnum::HR_PAGE->value,
            ],
            [
                'key' => 'head',
                'name' => 'Head Space',
                'description' => 'Manage subordinates',
                'href' => '/head',
                'permission' => PermissionEnum::HEAD_PAGE->value,
            ],
        ];

        return array_values(array_map(
            fn (array $space): array => [
                'key' => $space['key'],
                'name' => $space['name'],
                'description' => $space['description'],
                'href' => $space['href'],
            ],
            array_filter(
                $spaces,
                fn (array $space): bool => $space['permission'] === null || $user->can($space['permission'])
            )
        ));
    }
}
