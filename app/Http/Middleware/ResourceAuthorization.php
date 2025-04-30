<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Support\Facades\Gate;

class ResourceAuthorization
{
    public function handle($request, Closure $next, $modelClass)
    {
        $action = $request->route()->getActionMethod();

        // Define a mapping between controller actions and policy methods
        $policyMethods = [
            'index' => 'viewAny',
            'show' => 'view',
            'create' => 'create',
            'store' => 'create',
            'edit' => 'update',
            'update' => 'update',
            'destroy' => 'delete',
        ];

        if (isset($policyMethods[$action])) {
            $method = $policyMethods[$action];
            $model = $request->route($modelClass) ?? $modelClass;

            if (Gate::denies($method, $model)) {
                abort(403, "Unauthorized action: {$method}");
            }
        }

        return $next($request);
    }
}
