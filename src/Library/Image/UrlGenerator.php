<?php

declare(strict_types=1);

namespace Library\Image;

use Illuminate\Contracts\Filesystem\Filesystem;

class UrlGenerator
{
    /**
     * A Filesystem instance.
     *
     * @var Filesystem
     */
    private $filesystem;

    /**
     * @param Filesystem $filesystem A Filesystem instance.
     */
    public function __construct(Filesystem $filesystem)
    {
        $this->filesystem = $filesystem;
    }

    /**
     * Generates the URL for the image.
     *
     * @param string $filename The image filename.
     *
     * @return string
     */
    public function generate(string $filename): string
    {
        return $this->filesystem->url($filename);
    }
}
