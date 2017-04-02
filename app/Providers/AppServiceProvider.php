<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\Schema;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        // if ($this->app->environment() !== 'production') {
        //     \DB::listen(function($sql, $bindings, $time) {
        //         \Log::info('[SQL]'.$sql." with: ".join(',', $bindings));
        //     });
        // }

        Schema::defaultStringLength(191); // Solved by increasing StringLength

    }

    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        // if ($this->app->environment() !== 'production') {
        //     $this->app->register('Barryvdh\Debugbar\ServiceProvider');
        // }
    }
}
