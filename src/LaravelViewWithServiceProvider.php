<?php

namespace Captenmasin\LaravelViewWith;

use Illuminate\Support\Facades\Route;
use Illuminate\Support\Str;
use Spatie\LaravelPackageTools\Package;
use Spatie\LaravelPackageTools\PackageServiceProvider;

class LaravelViewWithServiceProvider extends PackageServiceProvider
{
    public function boot()
    {
        $this->loadViewsFrom(__DIR__.'/../resources/views', 'routedata');

        if (! Route::hasMacro('viewWith')) {
            Route::macro('viewWith', function ($route, $view, $data) {
                $routeParamsMap = [];

                //TODO - Maybe shouldn't rely on request() function?
                $currentPath = explode('/', request()->path());
                $routeItems = explode('/', $route);

                $i = 0;
                foreach ($routeItems as $routeItem) {
                    if (isset($currentPath[$i])) {
                        $routeItem = str_replace(['{', '}'], '', $routeItem);
                        $routeParamsMap[$routeItem] = $currentPath[$i];
                    }
                    $i++;
                }

                foreach ($data as $dataKey => $dataValue) {
                    if ($dataValue instanceof Closure) {
                        $modelKey = Str::after($dataKey, ':') ?? null;
                        $modelName = Str::before($dataKey, ':');

                        $reflectionParams = collect((new \ReflectionFunction($dataValue))->getParameters())->first();
                        $routeKey = $reflectionParams->getName();

                        $modelBindings = app()->router->binders;

                        if (isset($modelBindings[$routeKey])) {
                            $binding = $modelBindings[$routeKey];

                            $data[$dataKey] = $binding($routeParamsMap[$modelName]);
                        } else {
                            $model = app($reflectionParams->getType()->getName());
                            $dbColumn = $modelKey ? $modelKey : $model->getKeyName();
                            $dbValue = $routeParamsMap[$modelName];

                            $data[$dataKey] = $model::where($dbColumn, $dbValue)->firstOrFail();
                        }
                    } else {
                        $data[$dataKey] = $dataValue;
                    }
                }

                return Route::view($route, $view, $data);
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
