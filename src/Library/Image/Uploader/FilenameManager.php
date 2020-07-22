<?php

declare(strict_types=1);

namespace Library\Image\Uploader;

class FilenameManager
{
    /**
     * Generates a random filename (useful for unique filenames). It includes
     * both the current timestamp, and a random part.
     *
     * @param int $maxLength The maximum length of the filename.
     *
     * @return string
     */
    public function generateRandomFilename(int $maxLength = 16): string
    {
        $filename = time() . '.' . md5(time() . mt_rand());

        return substr($filename, 0, $maxLength);
    }

    /**
     * Compiles a filename based on the passed parts.
     *
     * @param string $prefix    The filename prefix.
     * @param string $name      The filename.
     * @param string $version   The image version.
     * @param string $extension The extension.
     *
     * @return string
     */
    public function compileNewFilename(
        string $prefix = 'image',
        string $name = 'no-name',
        string $version = '',
        string $extension = 'png'
    ): string {
        $parts = [];

        $parts[] = $prefix;
        $parts[] = $name;
        $parts[] = $version;

        $path = implode('/', $parts);

        if ($extension) {
            return "{$path}.{$extension}";
        }

        return $path;
    }
}
