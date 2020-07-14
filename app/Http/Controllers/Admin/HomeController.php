<?php

declare(strict_types=1);

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Admin\Controller;
use Illuminate\View\View;

class HomeController extends Controller
{
    /**
     */
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Gets the admin panel homepage.
     *
     * @return View
     */
    public function index(): View
    {
        return view('admin.home');
    }
}
