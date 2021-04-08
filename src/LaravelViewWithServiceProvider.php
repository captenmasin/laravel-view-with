<?php

namespace Captenmasin\LaravelViewWith;

use Captenmasin\LaravelViewWith\Services\GenerateViewRoute;
use Illuminate\Support\Facades\Route;
use Spatie\LaravelPackageTools\Package;
use Spatie\LaravelPackageTools\PackageServiceProvider;

class LaravelViewWithServiceProvider extends PackageServiceProvider
{
    public function boot()
    {
        $this->loadViewsFrom(__DIR__.'/../resources/views', 'viewwith');

        if (! Route::hasMacro('viewWith')) {
            Route::macro('viewWith', function ($route, $view, $data) {
                return Route::get($route, function () use ($route, $view, $data) {
                    $bindings = app()->router->binders;
                    $renderer = new GenerateViewRoute($route, $data, $bindings);
                    dd($renderer->render($view));
                });
            });
        }
    }

    public function configurePackage(Package $package): void
    {
        $package
            ->name('laravel-view-with')
            ->hasConfigFile();
    }
}
