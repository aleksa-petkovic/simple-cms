<?php

declare(strict_types=1);

namespace Library\ViewData;

use Library\ViewData\ViewData;
use Illuminate\View\View;

/**
 * This composer forwards some global view data into *all* loaded views.
 *
 * To attach data to this, use the `BaseController::viewData property`, which is
 * instantiated via `App::make('viewData')`, - since it's a singleton (as
 * defined in `Library\ViewData\ViewDataServiceProvider`), the same object will
 * be used everywhere.
 */
class Composer
{
    /**
     * A view data instance.
     *
     * @var ViewData
     */
    protected $viewData;

    /**
     * @param ViewData $viewData A ViewData instance.
     */
    public function __construct(ViewData $viewData)
    {
        $this->viewData = $viewData;
    }

    /**
     * Composes a view.
     *
     * @param View $view A View instance.
     *
     * @return void
     */
    public function compose(View $view): void
    {
        foreach ((array) $this->viewData as $key => $value) {
            if (!isset($view[$key])) {
                $view->with($key, $value);
            }
        }
    }
}
