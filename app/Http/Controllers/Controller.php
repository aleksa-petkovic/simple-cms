<?php

declare(strict_types=1);

namespace App\Http\Controllers;

use Illuminate\Foundation\Bus\DispatchesJobs;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Routing\Controller as BaseController;
use Library\ViewData\ViewData;

abstract class Controller extends BaseController
{
    use DispatchesJobs;
    use ValidatesRequests;

    /**
     * A ViewData instance.
     *
     * @var ViewData
     */
    protected $viewData;

    /**
     */
    public function __construct()
    {
        $this->viewData = app(ViewData::class);
    }
}
