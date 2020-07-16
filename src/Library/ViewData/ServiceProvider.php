<?php

declare(strict_types=1);

namespace Library\ViewData;

use Library\ViewData\ViewData;
use Illuminate\Support\ServiceProvider as BaseServiceProvider;

class ServiceProvider extends BaseServiceProvider
{
    /**
     * @inheritDoc
     */
    public function register(): void
    {
        $this->app->singleton(ViewData::class, static function (): ViewData {
            return new ViewData();
        });

        $this->app['view']->composer('*', 'Library\ViewData\Composer');
    }
}
