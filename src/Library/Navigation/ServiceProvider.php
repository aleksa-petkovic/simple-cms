<?php

declare(strict_types=1);

namespace Library\Navigation;

use Illuminate\Foundation\Application;
use Illuminate\Support\ServiceProvider as BaseServiceProvider;

class ServiceProvider extends BaseServiceProvider
{
    /**
     * @inheritDoc
     */
    public function register(): void
    {
        $this->app->singleton(Factory::class, static function (Application $app): Factory {
            return new Factory();
        });
    }
}
