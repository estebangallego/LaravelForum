<?php

namespace App\Providers;

use Illuminate\Http\Resources\Json\JsonResource;
use Illuminate\Support\ServiceProvider;
use Illuminate\Database\Eloquent\Model;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        //
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        // Remove data wrapper from JSON responses
        JsonResource::withoutWrapping();
        // Prevent Eloquent from eagerly loading relationships or n+1 queries
        Model::preventLazyLoading();
    }
}
