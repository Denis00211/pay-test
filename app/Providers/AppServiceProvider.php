<?php

namespace App\Providers;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Pagination\Paginator;
use Illuminate\Support\ServiceProvider;

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
        Paginator::useBootstrap();
        $this->app->resolving(FormRequest::class, function ($request, $app) {
            $request->merge($request->route()->parameters());
        });
    }
}
