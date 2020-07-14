<?php

declare(strict_types=1);

namespace App\Auth\Reminder;

use Library\Module\ServiceProvider as BaseServiceProvider;
use Illuminate\Contracts\Routing\Registrar as RegistrarContract;

class ServiceProvider extends BaseServiceProvider
{
    /**
     * @inheritDoc
     */
    public function boot(): void
    {
        $this->app->alias('sentinel.reminders', 'Cartalyst\Sentinel\Reminders\IlluminateReminderRepository');
        $this->registerFrontRoutes($this->app['router']);
    }

    /**
     * @inheritDoc
     */
    public function register(): void
    {
    }

    /**
     * Registers front routes.
     *
     * @param RegistrarContract $router A route registrar implementation.
     *
     * @return void
     */
    protected function registerFrontRoutes(RegistrarContract $router): void
    {
        $attributes = [
            'prefix' => 'password-reset',
            'middleware' => ['web'],
            'namespace' => 'App\Auth\Http\Controllers\Front\Reminder',
        ];

        $router->group($attributes, static function (RegistrarContract $router): void {
            $router->get('{reminderToken}', 'Controller@index');
            $router->post('', 'Controller@store');
        });
    }
}
