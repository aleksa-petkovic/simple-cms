<?php

declare(strict_types=1);

namespace Library\Models\Traits;

use Exception;
use Illuminate\Http\UploadedFile;
use Library\Image\Facades\ImageUploader;
use Library\Image\Facades\ImageUrlGenerator;

trait ImageableTrait
{
    abstract public function getImageConfiguration(): array;

    /**
     * Gets an image of a specified version.
     *
     * @param string $version The image version.
     *
     * @return string|null
     */
    public function getImage(string $version): ?string
    {
        $imageVersion = "image_{$version}";

        if (isset($this->$imageVersion) && $this->$imageVersion) {
            return ImageUrlGenerator::generate($this->{$imageVersion});
        }

        return null;
    }

    /**
     * Checks whether the model has an image of the specified version.
     *
     * @param string $version The image version.
     *
     * @return bool
     */
    public function hasImage(string $version): bool
    {
        $imageVersion = "image_{$version}";

        return isset($this->$imageVersion) && $this->$imageVersion;
    }

    /**
     * Uploads an image, and sets the relevant properties on the instance.
     *
     * @param UploadedFile  $file    The image file (in any of the allowed formats).
     * @param string $version The image version.
     *
     * @throws Exception
     *
     * @return bool
     */
    public function uploadImage(UploadedFile $file, string $version): bool
    {
        if (!$this->imageVersionConfigured($version)) {
            throw new Exception('Image version ' . $version . ' not configured in model: ' . get_called_class());
        }

        $prefix = $this->getImagePrefix();

        $data = ImageUploader::upload($file, $version, $prefix);

        if (!$data) {
            return false;
        }

        $imageProperty = "image_{$version}";
        $this->{$imageProperty} = $data;

        return true;
    }

    /**
     * Deletes this model's images of a specified version.
     *
     * @param string $version The image version.
     *
     * @throws Exception
     *
     * @return void
     */
    public function deleteImage(string $version): void
    {
        if (!$this->imageVersionConfigured($version)) {
            throw new Exception('Image version ' . $version . ' not configured in model: ' . get_called_class());
        }

        $imageProperty = "image_{$version}";
        $this->{$imageProperty} = null;
    }

    /**
     * Gets the configured image prefix.
     *
     * @return string
     */
    public function getImagePrefix(): string
    {
        $classTree = explode('\\', get_called_class());

        return end($classTree);
    }

    /**
     * Checks whether this model contains configuration for the passed image
     * version.
     *
     * @param string $version The image version.
     *
     * @return bool
     */
    public function imageVersionConfigured(string $version): bool
    {
        $imageConfiguration = $this->getImageConfiguration();

        return in_array($version, $imageConfiguration['versions']);
    }
}
