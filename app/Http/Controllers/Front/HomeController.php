<?php

declare(strict_types=1);

namespace App\Http\Controllers\Front;

use App\Http\Controllers\Front\Controller;
use Illuminate\View\View;

class HomeController extends Controller
{
    /**
     * Displays the website home page.
     *
     * @return View
     */
    public function index(): View
    {
        $data = [];

        return view('home', $data);
    }
}
