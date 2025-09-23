<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use App\Models\General;

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
    public function boot(): void
    {
        try {

            $general = General::first();
            if ($general && $general->timezone) {
                config(['app.timezone' => $general->timezone]);
                date_default_timezone_set($general->timezone);
            }
        } catch (\Illuminate\Database\QueryException $e) {
            $general = collect(); // tabla no existe
            $timezone='America/Mazatlan';
            config(['app.timezone' => $timezone]);
            date_default_timezone_set($timezone);

        }
    }
}
