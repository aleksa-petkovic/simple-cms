<?php

declare(strict_types=1);

namespace App\Navigation;

interface Builder
{
    /**
     * Builds the needed navigation(s).
     *
     * @return void
     */
    public function build(): void;
}
