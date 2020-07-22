<?php

declare(strict_types=1);

namespace Library\Image\Facades;

use Library\Image\Uploader;
use Illuminate\Support\Facades\Facade;

class ImageUploader extends Facade
{
    /**
     * @inheritDoc
     */
    protected static function getFacadeAccessor(): string
    {
        return Uploader::class;
    }
}
