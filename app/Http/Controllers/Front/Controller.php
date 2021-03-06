<?php

declare(strict_types=1);

namespace App\Http\Controllers\Front;

use App\Http\Controllers\Controller as BaseController;
use App\Navigation\FrontBuilder;

class Controller extends BaseController
{
    /**
     */
    public function __construct()
    {
        parent::__construct();

        // Build the navigation menu.
        $navigationBuilder = app(FrontBuilder::class);
        $navigationBuilder->build();

    }


}
