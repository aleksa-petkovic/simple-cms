<?php

declare(strict_types=1);

namespace Library\Models;

interface SluggableInterface
{
    /**
     * Automatically performs the sluggification.
     *
     * Returns `true` on success, or `false` on failure.
     *
     * @return bool
     */
    public function sluggify(): bool;

    /**
     * Validates whether the passed string is a valid slug.
     *
     * @param string $slug The string to use as a slug.
     *
     * @return bool
     */
    public function validateSlug(string $slug): bool;
}
