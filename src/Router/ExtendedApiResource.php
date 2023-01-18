<?php

namespace  Matteomeloni\Foundation\Router;

use Illuminate\Support\Facades\Route;
use Illuminate\Routing\Router;
use Illuminate\Support\Str;

class ExtendedApiResource extends Router
{
    /**
     * @param string $routeName
     * @param string $controllerPath
     * @param null $routeBindModel
     * @param array $parameters
     */
    public function extendedApiResource(string $routeName, string $controllerPath, $routeBindModel = null, array $parameters = [])
    {
        $model = $this->getModelName($routeName);

        $routeBindNameTrashed = $this->getRouteBindNameTrashed($model, $parameters);

        Route::bind($routeBindNameTrashed, function ($modelId) use ($routeBindModel) {
            return app($routeBindModel)->newQuery()->onlyTrashed()->findOrFail($modelId);
        });

        //Bulk operations
        Route::delete("$routeName/bulk", "{$controllerPath}@bulkDestroy")->name("{$model}.bulk.destroy");
        Route::delete("$routeName/bulk/force", "{$controllerPath}@bulkForceDestroy")->name("{$model}.bulk.force-destroy");
        Route::put("$routeName/bulk/restore", "{$controllerPath}@bulkRestore")->name("{$model}.bulk.restore");

        //Trash operations
        Route::put("$routeName/{{$routeBindNameTrashed}}/restore", "{$controllerPath}@restore")->name("{$model}.restore");
        Route::delete("$routeName/{{$routeBindNameTrashed}}/force", "{$controllerPath}@forceDestroy")->name("{$model}.force-destroy");
        Route::get("$routeName/trash", "{$controllerPath}@trash")->name("{$model}.trash");

        //Api resource routes
        Route::apiResource($routeName, $controllerPath)->parameters($parameters);
    }

    /**
     * @param string $routeName
     * @return mixed
     */
    private function getModelName(string $routeName): mixed
    {
        return last(explode('/', $routeName));
    }

    /**
     * @param mixed $model
     * @param array $parameters
     * @return string
     */
    private function getRouteBindNameTrashed(mixed $model, array $parameters): string
    {
        $routeBindNameTrashed = 'trashed_' . str_replace('-', '_', Str::singular($model));

        if (!empty($parameters)) {
            $routeBindNameTrashed = 'trashed_' . last($parameters);
        }

        return $routeBindNameTrashed;
    }
}
