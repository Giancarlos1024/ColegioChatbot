<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Inertia\Inertia;
use Illuminate\Support\Facades\Auth;

class InertiaServiceProvider extends ServiceProvider
{
    public function boot(): void
    {
        Inertia::share([
            'auth' => function () {
                $user = Auth::user();

                return [
                    'user' => $user ? [
                        'id' => $user->id,
                        'name' => $user->name,
                        'email' => $user->email,
                        'username' => $user->username,
                        'dni' => $user->dni,
                        'role' => $user->role,
                        'status' => $user->status,
                        'permissions' => $user->getPermissionsViaRoles()->pluck('name')->toArray()
                    ] : null
                ];
            },
        ]);
    }
}
