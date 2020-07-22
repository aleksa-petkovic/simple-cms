<?php

declare(strict_types=1);

namespace App\Content\Article;

use App\Content\Article;
use App\Content\Article\Repository as ArticleRepository;
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
     * @param Router    $router    A router.
     * @param Container $container A dependency container.
     *
     * @return void
     */
    protected function registerRoutePatterns(Router $router, Container $container): void
    {
        $idRegex = $this->routePatternRegexes['id'];

        $router->pattern('article', $idRegex);

        $router->bind('article', static function (string $value) use ($container): Article {
            return $container->make(ArticleRepository::class)->findOrFail((int) $value);
        });
    }

    /**
     * Registers admin panel routes.
     *
     * @param RegistrarContract $router A route registrar implementation.
     *
     * @return void
     */
    protected function registerAdminRoutes(RegistrarContract $router): void
    {
        $attributes = [
            'prefix' => 'admin/articles',
            'middleware' => ['web', 'auth', 'permissions'],
            'namespace' => 'App\Content\Http\Controllers\Admin\Article',
        ];

        $router->group($attributes, static function (RegistrarContract $router): void {
            $router->get('{article}/edit', 'Controller@edit');
            $router->put('{article}', 'Controller@update');

            $router->get('{article}/delete', 'Controller@confirmDelete');
            $router->delete('{article}', 'Controller@delete');
        });
    }
}
