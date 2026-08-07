<?php

namespace App\Providers;

use Illuminate\Support\Facades\Route;
use Illuminate\Foundation\Support\Providers\RouteServiceProvider as ServiceProvider;

class RouteServiceProvider extends ServiceProvider
{
    /**
     * Chemin de redirection après login/register
     */
    public const HOME = '/voitures';

    /**
     * Définir les bindings et autres configurations de routes
     */
    public function boot(): void
    {
        $this->routes(function () {
          
            Route::middleware('web')
                ->group(base_path('routes/web.php'));

          
            Route::middleware('api')
                ->prefix('api')
                ->group(base_path('routes/api.php'));
        });
    }
}
