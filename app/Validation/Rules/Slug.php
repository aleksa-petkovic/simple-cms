<?php

declare(strict_types=1);

namespace App\Validation\Rules;

use Illuminate\Support\Str;
use Illuminate\Contracts\Validation\Rule;

class Slug implements Rule
{
    /**
     * Determine if the validation rule passes.
     *
     * The constraints are mostly related to the allowed characters - a slug may
     * only have lowercase ASCII letters, numbers, and dashes, must not start or
     * end with a dash, and must not have two consecutive dashes.
     *
     * @param string $attribute The input attribute name.
     * @param mixed  $value     The input value.
     *
     * @return bool
     */
    public function passes($attribute, $value): bool
    {
        return $value === Str::slug($value);
    }

    /**
     * Get the validation error message.
     *
     * @return string
     */
    public function message(): string
    {
        return 'The passed value is not a valid slug.';
    }
}
