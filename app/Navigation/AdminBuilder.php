<?php

declare(strict_types=1);

namespace App\Navigation;

use App\Navigation\Builder;
use Library\Navigation\Factory as NavigationFactory;
use Illuminate\Support\Facades\URL;

class AdminBuilder implements Builder
{
    /**
     * A NavigationFactory instance.
     *
     * @var NavigationFactory
     */
    private $navigationFactory;

    /**
     * @param NavigationFactory $navigationFactory A NavigationFactory instance.
     */
    public function __construct(NavigationFactory $navigationFactory)
    {
        $this->navigationFactory = $navigationFactory;
    }

    /**
     * @inheritDoc
     */
    public function build(): void
    {
        $this->buildMain();
    }

    /**
     * Builds the main admin panel navigation.
     *
     * @return void
     */
    private function buildMain(): void
    {
        $navigation = $this->navigationFactory->get('admin.main');

        $navigation->addLast(
            'home',
            [
                'href' => URL::action('App\Http\Controllers\Admin\HomeController@index'),
                'icon' => 'home',
                'label' => trans('admin/navigation.home'),
            ],
        );

        $navigation->addLast(
            'users',
            [
                'href' => URL::action('App\Auth\Http\Controllers\Admin\User\Controller@index'),
                'icon' => 'users',
                'label' => trans('admin/navigation.users'),
            ],
        );

        $navigation->addLast(
            'pages',
            [
                'href' => URL::action('App\Content\Http\Controllers\Admin\Page\Controller@index'),
                'icon' => 'users',
                'label' => trans('admin/navigation.pages'),
            ],
        );

        $navigation->setActive('home');

    }
}
