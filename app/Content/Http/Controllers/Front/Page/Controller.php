<?php

declare(strict_types=1);

namespace App\Content\Http\Controllers\Front\Page;

use App\Content\Article;
use App\Content\Page;
use App\Content\Article\Repository as ArticleRepository;
use App\Content\Page\Repository as PageRepository;
use App\Http\Controllers\Front\Controller as BaseController;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Http\Request;
use Illuminate\View\View;
use Symfony\Component\HttpFoundation\Response;

class Controller extends BaseController
{
    /**
     * The current Request instance.
     *
     * @var Request
     */
    protected $request;

    /**
     * An Article model instance.
     *
     * @var Article
     */
    protected $articleModel;

    /**
     * @param Request $request      The current request instance.
     * @param Article $articleModel An article model instance.
     */
    public function __construct(Request $request, Article $articleModel)
    {
        parent::__construct();

        $this->request = $request;
        $this->articleModel = $articleModel;

    }

    /**
     * Resolves a dynamic website route.
     *
     * Throws a `ModelNotFoundException` if the route cannot be resolved.
     *
     * @param string            $route             The route to be resolved.
     * @param PageRepository    $pageRepository    A PageRepository instance.
     * @param ArticleRepository $articleRepository A ArticleRepository instance.
     *
     * @throws ModelNotFoundException
     *
     * @return Response
     */
    public function resolveRoute(string $route, PageRepository $pageRepository, ArticleRepository $articleRepository ): Response
    {
        $path = explode('/', $route);

        $lastSlug = array_pop($path);

        $page = $pageRepository->findBySlug($lastSlug);

        if (empty($path)) {

            if ($page === null) {
                throw new ModelNotFoundException();
            }

            return response($this->handlePage($page));
        }

        $article = $articleRepository->findBySlug($lastSlug);

        if ($article !== null) {

            return response($this->handleArticle($article));
        }
    }

    /**
     * Handles displaying a page in the appropriate template.
     *
     * @param Page $page The page to display.
     *
     * @return View
     */
    protected function handlePage(Page $page): View
    {
        $this->viewData->navigation->get('front.main')->setActive($page->slug);

        $data = $this->getPageViewData($page);

        return view('templates.pages.' . $page->template, $data);
    }

    /**
     * Handles displaying an article in the appropriate template.
     *
     * @param Article $article The article to display.
     *
     * @return View
     */
    protected function handleArticle(Article $article): View
    {
        $this->viewData->navigation->get('front.main')->setActive($article->page->slug);

        return view('templates.articles.' . $article->template, ['article' => $article]);
    }

    /**
     * Gets page view data.
     *
     * @param Page $page The page.
     *
     * @return array
     */
    protected function getPageViewData(Page $page): array
    {
        if ($page->articles_per_page === 0) {
            return [
                'page' => $page,
                'articles' => $page->articles,
            ];
        }

        $articles = $page->articles()->get();

        return [
            'page' => $page,
            'articles' => $articles,
        ];
    }
}
