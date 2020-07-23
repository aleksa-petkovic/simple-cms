<?php

declare(strict_types=1);

namespace Library\Image;

use Illuminate\Contracts\Filesystem\Filesystem;
use Illuminate\Http\UploadedFile;
use Library\Image\Uploader\FilenameManager;

class Uploader
{
    /**
     * A Filesystem instance.
     *
     * @var Filesystem
     */
    private $filesystem;

    /**
     * A FilenameManager instance.
     *
     * @var FilenameManager
     */
    private $filenameManager;

    /**
     * @param Filesystem      $filesystem      A Filesystem instance.
     * @param FilenameManager $filenameManager A FilenameManager instance.
     */
    public function __construct(
        Filesystem $filesystem,
        FilenameManager $filenameManager
    ) {
        $this->filesystem = $filesystem;
        $this->filenameManager = $filenameManager;
    }

    /**
     * Uploads an image and returns the path.
     *
     * @param UploadedFile  $file                 The uploaded file.
     * @param string        $version              The image version.
     * @param string        $prefix               A prefix for the filename.
     *
     * @return string
     */
    public function upload(
        UploadedFile $file,
        string $version,
        string $prefix
    ): string {
        $targetFilename = $this->filenameManager->compileNewFilename(
            $prefix,
            $this->filenameManager->generateRandomFilename(),
            $version,
            $file->getClientOriginalExtension(),
        );

        $this->filesystem->put($targetFilename, file_get_contents($file->getRealPath()));

        return $targetFilename;
    }
}
