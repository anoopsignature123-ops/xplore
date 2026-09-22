<?php

namespace App\Providers;
use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\Schema;

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
        // Schema::defaultStringLength(191); 

        if (request()->is('api/*') || request()->is('api') || request()->is('vendor/*') || request()->is('vendor')) {
            config(['activitylog.enabled' => false]);
        }
 
        \Illuminate\Support\Facades\Event::listen(function (\Illuminate\Auth\Events\Login $event) {
            activity('auth')
                ->causedBy($event->user)
                ->log('Logged in');
        });

        \Illuminate\Support\Facades\Event::listen(function (\Illuminate\Auth\Events\Logout $event) {
            if ($event->user) {
                activity('auth')
                    ->causedBy($event->user)
                    ->log('Logged out');
            }
        });
    }
}
