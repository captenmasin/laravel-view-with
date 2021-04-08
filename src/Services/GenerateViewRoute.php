<?php

namespace Captenmasin\LaravelViewWith\Services;

use Illuminate\Support\Str;

class GenerateViewRoute
{
    public array $finalData = [];

    public function __construct(public $route, public $data, public $modelBindings)
    {
        $this->generate();
    }

    public function generate()
    {
        $data = [];
        $routeParamsMap = [];

        //TODO - Maybe shouldn't rely on request() function?
        $currentPath = explode('/', request()->path());
        $routeItems = explode('/', $this->route);

        $i = 0;
        foreach ($routeItems as $routeItem) {
            if (isset($currentPath[$i])) {
                $routeItem = str_replace(['{', '}'], '', $routeItem);
                $routeParamsMap[$routeItem] = $currentPath[$i];
            }
            $i++;
        }

        foreach ($this->data as $dataKey => $dataValue) {
            if (is_callable($dataValue)) {
                $modelKey = Str::after($dataKey, ':') ?? null;
                $modelName = Str::before($dataKey, ':');

                $reflectionParams = collect((new \ReflectionFunction($dataValue))->getParameters())->first();
                $routeKey = $reflectionParams->getName();

                if (isset($this->modelBindings[$routeKey])) {
                    $binding = $this->modelBindings[$routeKey];

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

        $this->finalData = $data;
    }

    public function render($view): string
    {
        return view($view)->with($this->finalData)->render();
    }
}
