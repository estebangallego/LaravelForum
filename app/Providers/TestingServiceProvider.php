<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use PHPUnit\Framework\Assert as PHPUnit;
use Inertia\Testing\AssertableInertia as Assert;
use Illuminate\Http\Resources\Json\ResourceCollection;
use Illuminate\Http\Resources\Json\JsonResource;

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
            $props = $this->toArray()['props'];
            $compiledResource = $resource->response()->getData(true);
            PHPUnit::assertArrayHasKey($key, $props, "Key \"{$key}\" not passed as a property to Inertia.");
            PHPUnit::assertEquals($props[$key], $compiledResource, "The value for key \"{$key}\" does not match the expected resource.");
        
            return $this;
        });

        // Check if the posts are passed as a paginated resource
        Assert::macro('hasPaginateResource', function (string $key, ResourceCollection $resource) {
            $props = $this->toArray()['props'];
            $compiledResource = $resource->response()->getData(true);
            PHPUnit::assertArrayHasKey($key, $props);
            foreach (['links', 'data', 'meta'] as $data) {
                PHPUnit::assertArrayHasKey($data , $props[$key]);
            }
            PHPUnit::assertEquals($props[$key]['data'], $compiledResource, "The value for key \"{$key}\" does not match the expected resource.");
      
            return $this;
        });
    }
}
