<?php

declare(strict_types=1);

namespace Library\Module;

use Illuminate\Support\ServiceProvider as BaseServiceProvider;

abstract class ServiceProvider extends BaseServiceProvider
{
    /**
     * Various regexes for use in route patterns.
     */
    protected $routePatternRegexes = [
        // A generic ID pattern which can be used in pattern definitions.
        'id' => '[1-9][0-9]*',

        // A pattern for a single URL segment, usually also called a "slug" or
        // "permalink".
        //
        // Note that a slug that starts or ends with a dash, or that contains
        // multiple consecutive dashes, is invalid within our system, but for
        // simplicity's sake, we're allowing that to be matched - as it won't
        // match any other route either way, so we'll still end up with a 404.
        'slug' => '[A-Za-z0-9\\-]+',

        // A pattern that matches anything (multiple segments).
        'any' => '[A-Za-z0-9/\\-]+',
    ];
}
