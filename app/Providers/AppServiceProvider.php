<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;

use Yajra\DataTables\Html\Builder;
class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        //
    }

    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        // Builder::useVite();
    }
}
