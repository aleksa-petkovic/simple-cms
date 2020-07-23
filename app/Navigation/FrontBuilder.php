<?php

declare(strict_types=1);

namespace App\Navigation;

use App\Content\Page\Repository as PageRepository;
use Illuminate\Support\Facades\URL;
use Library\Navigation\Factory as NavigationFactory;

class FrontBuilder implements Builder
{
    /**
     * A NavigationFactory instance.
     *
     * @var NavigationFactory
     */
    private $navigationFactory;

    /**
     * A PageRepository instance.
     *
     * @var PageRepository
     */
    private $pageRepository;

    /**
     * @param NavigationFactory $navigationFactory A NavigationFactory instance.
     * @param PageRepository    $pageRepository    A PageRepository instance.
     */
    public function __construct(NavigationFactory $navigationFactory, PageRepository $pageRepository)
    {
        $this->navigationFactory = $navigationFactory;
        $this->pageRepository = $pageRepository;
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
        $navigation = $this->navigationFactory->get('front.main');

        $navigation->addLast(
            'home',
            [
                'href' => '/',
                'label' => trans('navigation.home'),
            ],
        );

        foreach ($this->pageRepository->getAll() as $page) {
            if ($page->show_in_navigation) {
                $navigation->addLast(
                    $page->slug,
                    [
                        'href' => URL::action('App\Content\Http\Controllers\Front\Page\Controller@resolveRoute', ['any' => $page->slug]),
                        'label' => $page->title,
                        'articles' => $page->show_articles_in_navigation ? $page->articles : null,
                        'selectable_in_navigation' => $page->selectable_in_navigation,
                    ],
                );
            }
        }

        $navigation->setActive('home');
    }
}
