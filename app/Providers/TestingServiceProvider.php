<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use PHPUnit\Framework\Assert as PHPUnit;
use Inertia\Testing\AssertableInertia as Assert;
use Illuminate\Http\Resources\Json\ResourceCollection;
use Illuminate\Http\Resources\Json\JsonResource;
use Illuminate\Testing\TestResponse;


class TestingServiceProvider extends ServiceProvider
{
    /**
     * Register services.
     */
    public function register(): void
    {
        //
    }

    /**
     * Bootstrap services.
     */
    public function boot(): void
    {
        if (!$this->app->runningUnitTests()) {
            return;
        }
        
        // Check if the posts are passed as a resource
        Assert::macro('hasResource', function (string $key, JsonResource $resource) {
            $compiledResource = $resource->response()->getData(true);
            PHPUnit::assertArrayHasKey($key, $this->prop());
            PHPUnit::assertEquals($this->prop($key), $compiledResource);
        
            return $this;
        });

        // Check if the posts are passed as a paginated resource
        Assert::macro('hasPaginateResource', function (string $key, ResourceCollection $resource) {
            $compiledResource = $resource->response()->getData(true);
            PHPUnit::assertArrayHasKey($key, $this->prop());
            foreach (['links', 'data', 'meta'] as $data) {
                PHPUnit::assertArrayHasKey($data , $this->prop($key));
            }
            PHPUnit::assertEquals($this->prop($key)['data'], $compiledResource);
      
            return $this;
        });

        TestResponse::macro('assertPaginatedResource', function (string $key, ResourceCollection $resource) {
            return $this->assertInertia(fn (Assert $inertia) => $inertia->hasPaginateResource($key, $resource));
        });

        TestResponse::macro('assertHasResource', function (string $key, JsonResource $resource) {
            return $this->assertInertia(fn (Assert $inertia) => $inertia->hasResource($key, $resource));
        });

        TestResponse::macro('assertComponent', function (string $component) {
            return $this->assertInertia(fn (Assert $inertia) => $inertia->component($component, true));
        });
    }
}
