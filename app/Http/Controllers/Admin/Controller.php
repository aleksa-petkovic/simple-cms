<?php

declare(strict_types=1);

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller as BaseController;
use App\Navigation\AdminBuilder;

class Controller extends BaseController
{
    /**
     */
    public function __construct()
    {
        parent::__construct();

        // Build the navigation menu.
        $navigationBuilder = app(AdminBuilder::class);
        $navigationBuilder->build();
    }
}
