<?php

declare(strict_types=1);

namespace Library\Locales;

use Library\Locales\Repository as LocaleRepository;
use Illuminate\Foundation\Application;
use Illuminate\Support\ServiceProvider as BaseServiceProvider;

class ServiceProvider extends BaseServiceProvider
{
    /**
     * @inheritDoc
     */
    public function register(): void
    {
        $this->app->singleton(LocaleRepository::class, static function (Application $app): LocaleRepository {
            $availableLocales = $app['config']->get('app.locales');
            $defaultLocale = $app['config']->get('app.locale');

            return new LocaleRepository($availableLocales, $defaultLocale);
        });
    }

    /**
     * @inheritDoc
     */
    public function boot(): void
    {
        $this->setLocaleByUrl();
    }

    /**
     * Sets the application locale according to the first URL segment.
     *
     * @return void
     */
    protected function setLocaleByUrl(): void
    {
        $localeRepository = $this->app->make(LocaleRepository::class);

        $firstSegment = $this->app['request']->segment(1);

        $locale = $localeRepository->getLocaleByLanguage($firstSegment);

        if ($locale === null) {
            return;
        }

        $this->app->setLocale($locale);
        $localeRepository->setLocale($locale);
    }
}

