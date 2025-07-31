<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;

use Illuminate\Support\Facades\Auth;
class CurrentUserServiceProvider extends ServiceProvider
{
    /**
     * Register services.
     */
    public function register(): void
    {
        //
    }

    /**
     * Bootstrap services.
     */
    public function boot(): void
    {
     /**   view()->composer('*', function ($view) {
            $user = Auth::guard('web')->user();

            $view->with('user', $user);
        }); **/

        view()->composer('*', function ($view) {
            $user = null;

            try {
                $user = Auth::guard('web')->user();
            } catch (\Throwable $e) {
                // Silence for artisan CLI calls
            }

            $view->with('user', $user);
        });
    }
}
