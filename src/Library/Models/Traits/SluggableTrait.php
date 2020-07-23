<?php

declare(strict_types=1);

namespace Library\Models\Traits;

use Illuminate\Support\Str;
use Library\Models\SluggableInterface;

trait SluggableTrait
{
    /**
     * Boots the sluggable trait.
     *
     * Hooks into the model's "saving" event, to automatically set the slug when
     * needed.
     *
     * @return void
     */
    public static function bootSluggableTrait(): void
    {
        static::saving(static function (SluggableInterface $model): bool {
            return $model->sluggify();
        });
    }

    /**
     * Returns an array of mappings where each key is the source column, and the
     * corresponding value is the target where the generated slug will be
     * stored.
     *
     * This can be overriden on a per-class basis, for custom mappings.
     *
     * @return array
     */
    protected function getSlugMappings(): array
    {
        return [
            'title' => 'slug',
        ];
    }

    /**
     * Gets the separator which should be used within the slug.
     *
     * Must return a string.
     *
     * This can be overriden on a per-class basis, for custom separator usage.
     *
     * @return string
     */
    protected function getSlugSeparator(): string
    {
        return '-';
    }

    /**
     * @inheritDoc
     */
    public function sluggify(): bool
    {
        foreach ($this->getSlugMappings() as $source => $target) {
            if (empty($this->{$target})) {
                $this->{$target} = $this->generateSlug($this->{$source});

                if (!$this->validateSlug($this->{$target})) {
                    return false;
                }
            }
        }

        return true;
    }

    /**
     * @inheritDoc
     */
    public function validateSlug(string $string): bool
    {
        return $string === $this->generateSlug($string);
    }

    /**
     * Calls the configured sluggify method, and returns the generated slug.
     *
     * @param string $string The string based on which the slug should be generated.
     *
     * @return string
     */
    public function generateSlug(string $string): string
    {
        return Str::slug($string, $this->getSlugSeparator());
    }
}
