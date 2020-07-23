<?php

declare(strict_types=1);

namespace App\Content\Http\Controllers\Admin\Article;

use App\Content\Article;
use App\Content\Article\Repository as ArticleRepository;
use App\Content\Http\Requests\Admin\Article\StoreRequest;
use App\Content\Http\Requests\Admin\Article\UpdateRequest;
use App\Content\Page;
use App\Http\Controllers\Admin\Controller as AbstractBaseController;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\URL;
use Illuminate\Support\MessageBag;
use Illuminate\View\View;

class Controller extends AbstractBaseController
{
    /**
     */
    public function __construct()
    {
        parent::__construct();

        $this->viewData->navigation->get('admin.main')->setActive('pages');
    }

    /**
     * Shows all articles belonging to a page.
     *
     * @param Page $page The page whose articles to show.
     *
     * @return View
     */
    public function index(Page $page): View
    {
        $data = [
            'page' => $page,
        ];

        return view('admin.articles.index', $data);
    }

    /**
     * Displays the article create form.
     *
     * @param Page              $page              The page within which the article is being created.
     * @param ArticleRepository $articleRepository An article repository instance.
     *
     * @return View
     */
    public function create(Page $page, ArticleRepository $articleRepository): View
    {
        $data = [
            'templateOptions' => $articleRepository->getTemplateOptions(),
            'defaultTemplateOption' => 'default',
            'page' => $page,
        ];

        return view('admin.articles.create', $data);
    }

    /**
     * Saves a new article.
     *
     * @param StoreRequest      $request           An article store request.
     * @param Page              $page              The page within which the article is being created.
     * @param ArticleRepository $articleRepository An article repository instance.
     *
     * @return RedirectResponse
     */
    public function store(StoreRequest $request, Page $page, ArticleRepository $articleRepository): RedirectResponse
    {
        $inputData = [
            'title' => $request->has('title') ? $request->get('title') : null,
            'slug' => $request->has('slug') ? $request->get('slug') : null,
            'template' => $request->has('template') ? $request->get('template') : null,
            'content' => $request->has('content') ? $request->get('content') : null,
            'lead' => $request->has('lead') ? $request->get('lead') : null,
            'image_main' => $request->hasFile('image_main') ? $request->file('image_main') : null,
        ];

        $inputData['page'] = $page;

        $article = $articleRepository->create($inputData);

        $successMessage = trans(
            'admin/articles.successMessages.create',
            [
                'createUrl' => URL::action(static::class . '@create', ['page' => $page->id]),
            ],
        );

        return Redirect::action(static::class . '@edit', ['article' => $article->id])
            ->with('successMessages', new MessageBag([$successMessage]));
    }

    /**
     * Shows the specified article.
     *
     * @param Article           $article           The article to show.
     * @param ArticleRepository $articleRepository An article repository instance.
     *
     * @return View
     */
    public function edit(Article $article, ArticleRepository $articleRepository): View
    {
        $data = [
            'article' => $article,
            'templateOptions' => $articleRepository->getTemplateOptions(),
        ];

        return view('admin.articles.edit', $data);
    }

    /**
     * Updates the specified article.
     *
     * @param UpdateRequest     $request           An article update request.
     * @param Article           $article           The article to update.
     * @param ArticleRepository $articleRepository An article repository instance.
     *
     * @return RedirectResponse
     */
    public function update(UpdateRequest $request, Article $article, ArticleRepository $articleRepository): RedirectResponse
    {
        $updatedData = [
            'title' => $request->has('title') ? $request->get('title') : null,
            'slug' => $request->has('slug') ? $request->get('slug') : null,
            'template' => $request->has('template') ? $request->get('template') : null,
            'content' => $request->has('content') ? $request->get('content') : null,
            'lead' => $request->has('lead') ? $request->get('lead') : null,
            'image_main' => $request->hasFile('image_main') ? $request->file('image_main') : null,
            'image_main_delete' => $request->has('image_main_delete') ? $request->get('image_main_delete') : null,
        ];

        $articleRepository->update($article, $updatedData);

        $successMessage = trans('admin/articles.successMessages.edit');

        return Redirect::action(static::class . '@edit', ['article' => $article->id])
            ->with('successMessages', new MessageBag([$successMessage]));
    }

    /**
     * Displays the article deletion confirmation form.
     *
     * @param Article $article The article to delete.
     *
     * @return View
     */
    public function confirmDelete(Article $article): View
    {
        $data = [
            'article' => $article,
        ];

        return view('admin.articles.delete', $data);
    }

    /**
     * Deletes an article.
     *
     * @param Request           $request           The current request.
     * @param Article           $article           The article to delete.
     * @param ArticleRepository $articleRepository An article repository instance.
     *
     * @return RedirectResponse
     */
    public function delete(Request $request, Article $article, ArticleRepository $articleRepository): RedirectResponse
    {
        if ($request->get('action') !== 'confirm') {
            return Redirect::action(static::class . '@index');
        }

        $articleRepository->delete($article);

        $successMessage = trans('admin/articles.successMessages.delete', ['title' => $article->title]);

        return Redirect::action(static::class . '@index', ['page' => $article->page->id])
            ->with('successMessages', new MessageBag([$successMessage]));
    }
}
