<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use App\Models\Category;
use Illuminate\Pagination\Paginator;

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

        #sempre vai existir a variavel listaDeCategorias
        view()->composer('*', function ($view) {
            $view->with('categoryListOfAllViews', Category::orderBy('name_category', 'ASC')->paginate());
        });

        view()->composer('*', function ($view) {
            $contCategory = 0;
            $view->with('contCategory', $contCategory);
        });
    }
}
