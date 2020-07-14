<?php

declare(strict_types=1);

namespace App\Auth\Role;

class Repository
{
    /**
     * Gets the available role options.
     *
     * Currently just pulls them from the appropriate language file.
     *
     * @return array
     */
    public function getOptions(): array
    {
        return trans('roles');
    }
}
