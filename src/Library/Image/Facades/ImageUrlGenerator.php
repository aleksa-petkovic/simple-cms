<?php

declare(strict_types=1);

namespace Library\Image\Facades;

use Library\Image\UrlGenerator;
use Illuminate\Support\Facades\Facade;

class ImageUrlGenerator extends Facade
{
    /**
     * @inheritDoc
     */
    protected static function getFacadeAccessor(): string
    {
        return UrlGenerator::class;
    }
}
