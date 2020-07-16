<?php

declare(strict_types=1);

namespace App\Providers;

use Library\Locales\Repository as LocaleRepository;
use Library\Navigation\Factory as NavigationFactory;
use Library\ViewData\ViewData;
use Illuminate\Support\ServiceProvider;

class ViewDataServiceProvider extends ServiceProvider
{
    /**
     * @inheritDoc
     */
    public function boot(): void
    {
        $this->configureViewData($this->app[ViewData::class]);
    }

    /**
     * @inheritDoc
     */
    public function register(): void
    {
    }

    /**
     * Configures all the basic view data properties.
     *
     * @param ViewData $viewData A view data instance.
     *
     * @return void
     */
    protected function configureViewData(ViewData $viewData): void
    {
        $viewData->currentLanguage = $this->app[LocaleRepository::class]->getLanguage();
        $viewData->currentLocale = $this->app->getLocale();
        $viewData->currentLocaleProperties = $this->app[LocaleRepository::class]->getLocaleProperties();

        $viewData->navigation = $this->app[NavigationFactory::class];
    }
}
