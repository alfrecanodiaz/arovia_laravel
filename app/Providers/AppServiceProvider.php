<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        view()->composer('*', function($view)
        {
            $request = app(\Illuminate\Http\Request::class);
            $menu = str_replace('/', '', $request->route()->getPrefix());
//            $item = route($request->route()->getName());
            $view->with('menu', $menu);
//            $view->with('item', $item);
        });
    }

    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        //
    }
}
