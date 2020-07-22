<?php

declare(strict_types=1);

namespace Library\Image;

use Illuminate\Foundation\Application;
use Illuminate\Support\ServiceProvider as BaseServiceProvider;
use Library\Image\Uploader\FilenameManager;

class ServiceProvider extends BaseServiceProvider
{
    /**
     * Register the service provider.
     *
     * @return void
     */
    public function register(): void
    {
        $this->registerImageUploader();
        $this->registerUrlGenerator();
    }

    /**
     * Registers the image uploader instance.
     *
     * @return void
     */
    protected function registerImageUploader(): void
    {
        $this->app->singleton(Uploader::class, static function (Application $app): Uploader {
            $disk = $app['config']->get('filesystems.disks.uploads.images.disk');

            return new Uploader(
                $app['filesystem']->disk($disk),
                $app[FilenameManager::class],
            );
        });
    }

    /**
     * Registers the image URL generator.
     *
     * @return void
     */
    protected function registerUrlGenerator(): void
    {
        $this->app->singleton(UrlGenerator::class, static function (Application $app): UrlGenerator {
            $disk = $app['config']->get('filesystems.disks.uploads.images.disk');

            return new UrlGenerator($app['filesystem']->disk($disk),);
        });
    }
}
