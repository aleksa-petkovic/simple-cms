<?php

declare(strict_types=1);

namespace App\Auth\User;

use App\Auth\User;
use App\Auth\User\Repository as UserRepository;
use Library\Module\ServiceProvider as BaseServiceProvider;
use Illuminate\Contracts\Container\Container;
use Illuminate\Contracts\Routing\Registrar as RegistrarContract;
use Illuminate\Routing\Router;

class ServiceProvider extends BaseServiceProvider
{
    /**
     * @inheritDoc
     */
    public function boot(): void
    {
        $this->registerRoutePatterns($this->app['router'], $this->app);
        $this->registerAdminRoutes($this->app['router']);
    }

    /**
     * @inheritDoc
     */
    public function register(): void
    {
    }

    /**
     * Registers the route patterns.
     *
     * @param Router    $router    A router instance.
     * @param Container $container A dependency container implementation.
     *
     * @return void
     */
    private function registerRoutePatterns(Router $router, Container $container): void
    {
        $idRegex = $this->routePatternRegexes['id'];

        $router->pattern('user', $idRegex);

        $router->bind('user', static function (string $value) use ($container): User {
            return $container->make(UserRepository::class)->findOrFail((int) $value);
        });
    }

    /**
     * Registers admin panel routes.
     *
     * @param RegistrarContract $router A route registrar implementation.
     *
     * @return void
     */
    private function registerAdminRoutes(RegistrarContract $router): void
    {
        $attributes = [
            'prefix' => 'admin/users',
            'middleware' => ['web', 'auth', 'permissions'],
            'namespace' => 'App\Auth\Http\Controllers\Admin\User',
        ];

        $router->group($attributes, static function (RegistrarContract $router): void {
            $router->get('', 'Controller@index');

            $router->get('create', 'Controller@create');
            $router->post('', 'Controller@store');

            $router->get('{user}/edit', 'Controller@edit');
            $router->put('{user}', 'Controller@update');

            $router->get('{user}/delete', 'Controller@confirmDelete');
            $router->delete('{user}', 'Controller@delete');
        });
    }
}
