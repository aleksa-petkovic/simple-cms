<?php

namespace App\Providers;

use Illuminate\Contracts\Routing\Registrar as RegistrarContract;
use Illuminate\Http\RedirectResponse;
use Illuminate\Routing\Router;
use Library\Locales\Repository as LocaleRepository;
use Library\Module\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
    }

    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        $this->registerRoutePatterns($this->app['router']);
        $this->registerHomepageRoutes($this->app['router'], $this->app[LocaleRepository::class]);
        $this->registerAdminLoginRoutes($this->app['router']);
        $this->registerAdminRoutes($this->app['router']);
    }

    /**
     * Registers default application route patterns.
     *
     * @param Router $router A router.
     *
     * @return void
     */
    private function registerRoutePatterns(Router $router): void
    {
        $anyRegex = $this->routePatternRegexes['any'];
        $slugRegex = $this->routePatternRegexes['slug'];

        $router->pattern('any', $anyRegex);
        $router->pattern('slug', $slugRegex);
    }

    /**
     * Registers the home page and the language redirect routes.
     *
     * @param RegistrarContract $router           A route registrar implementation.
     * @param LocaleRepository  $localeRepository A locale repository.
     *
     * @return void
     */
    protected function registerHomepageRoutes(RegistrarContract $router, LocaleRepository $localeRepository): void
    {
        $currentLanguage = $localeRepository->getLanguage();

        // Website homepage route.
        $attributes = [
            'middleware' => ['web'],
            'namespace' => 'App\Http\Controllers\Front',
        ];

        $router->group($attributes, static function (RegistrarContract $router) use ($currentLanguage): void {
            // Language redirection route on the root path.
            $router->get('', static function () use ($currentLanguage): RedirectResponse {
                return redirect('/' . $currentLanguage);
            });

            $router->get($currentLanguage, 'HomeController@index');
        });
    }

    /**
     * Registers routes for the admin panel login.
     *
     * @param RegistrarContract $router A route registrar implementation.
     *
     * @return void
     */
    protected function registerAdminLoginRoutes(RegistrarContract $router): void
    {
        $attributes = [
            'prefix' => 'admin',
            'middleware' => ['web', 'guest'],
            'namespace' => 'App\Http\Controllers\Admin',
        ];

        $router->group($attributes, static function (RegistrarContract $router): void {
            // Admin panel login routes.
            $router->get('login', 'LoginController@index');
            $router->post('login', 'LoginController@login');
        });
    }

    /**
     * Registers some basic admin panel routes.
     *
     * @param RegistrarContract $router A route registrar implementation.
     *
     * @return void
     */
    private function registerAdminRoutes(RegistrarContract $router): void
    {
        $attributes = [
            'prefix' => 'admin',
            'middleware' => ['web', 'auth', 'permissions'],
            'namespace' => 'App\Http\Controllers\Admin',
        ];

        $router->group($attributes, static function (RegistrarContract $router): void {
            // admin panel home page.
            $router->get('', 'HomeController@index');;

            // Admin panel logout route.
            $router->post('logout', 'LoginController@logout');
        });
    }
}
