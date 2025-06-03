<?php

namespace App\Providers;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Http\Resources\Json\JsonResource;
use Illuminate\Support\ServiceProvider;
use Illuminate\Database\Eloquent\Relations\Relation;
use App\Models\Post;
use App\Models\Comment;

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

        // Enforce morph map for likes
        Relation::enforceMorphMap([
            'post' => Post::class,
            'comment' => Comment::class,
        ]);
    }
}
