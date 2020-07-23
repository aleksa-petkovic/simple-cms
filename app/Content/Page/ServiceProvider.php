<?php

declare(strict_types=1);

namespace App\Content\Page;

use App\Content\Page;
use App\Content\Page\Repository as PageRepository;
use Library\Locales\Repository as LocaleRepository;
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
        $this->registerFrontRoutes($this->app['router']);
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

        $router->pattern('page', $idRegex);

        $router->bind('page', static function (string $value) use ($container): Page {
            return $container->make(PageRepository::class)->findOrFail((int) $value);
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
            'prefix' => 'admin/pages',
            'middleware' => ['web', 'auth', 'permissions'],
            'namespace' => 'App\Content\Http\Controllers\Admin',
        ];

        $router->group($attributes, static function (RegistrarContract $router): void {
            $router->get('', 'Page\Controller@index');

            $router->get('create', 'Page\Controller@create');
            $router->post('', 'Page\Controller@store');

            $router->get('{page}/edit', 'Page\Controller@edit');
            $router->put('{page}', 'Page\Controller@update');

            $router->get('{page}/delete', 'Page\Controller@confirmDelete');
            $router->delete('{page}', 'Page\Controller@delete');

            /*
             * Articles.
             */
            $router->get('{page}/articles', 'Article\Controller@index');
            $router->get('{page}/articles/create', 'Article\Controller@create');
            $router->post('{page}/articles', 'Article\Controller@store');
        });
    }

    /**
     * Registers front panel routes.
     *
     * @param RegistrarContract $router A route registrar implementation.
     *
     * @return void
     */
    protected function registerFrontRoutes(RegistrarContract $router): void
    {
        $localeRepository = $this->app[LocaleRepository::class];
        $currentLanguage = $localeRepository->getLanguage();

        $anyRegex = $this->routePatternRegexes['any'];
        $router->pattern('any', $anyRegex);

        $attributes = [
            'prefix' => $currentLanguage,
            'middleware' => ['web'],
            'namespace' => 'App\Content\Http\Controllers\Front\Page',
        ];

        $router->group($attributes, static function (RegistrarContract $router): void {
            $router->get('{any}', 'Controller@resolveRoute');
        });
    }
}
