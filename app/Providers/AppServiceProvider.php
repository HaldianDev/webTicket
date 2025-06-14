<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
   use Illuminate\Support\Facades\Blade;


class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        //
    }

    /**
     * Bootstrap any application services.
     */

public function boot()
{
    Blade::directive('role', function ($role) {
        return "<?php if(auth()->check() && auth()->user()->role == $role): ?>";
    });

    Blade::directive('endrole', function () {
        return "<?php endif; ?>";
    });
}

}
