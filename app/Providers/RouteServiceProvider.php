<?php

namespace App\Providers;

use Illuminate\Foundation\Support\Providers\RouteServiceProvider as ServiceProvider;
use Illuminate\Support\Facades\Route;

class RouteServiceProvider extends ServiceProvider
{
    // jangan pernah fallback ke /home
    public const HOME = '/login';

    public function boot()
    {
        $this->routes(function () {
            Route::middleware('api')
                ->prefix('api')
                ->group(base_path('routes/api.php'));

            Route::middleware('web')
                ->group(base_path('routes/web.php'));
        });
    }

    public static function dashboardRouteForRole(?string $role): string
    {
        return match($role) {
            'admin'   => 'admin.dashboard.index',
            'company' => 'company.dashboard.index',
            'user'    => 'user.dashboard.index',
            default   => 'login',
        };
    }
}