<?php

declare(strict_types=1);

namespace App\Content\Http\Controllers\Admin\Page;

use App\Content\Http\Requests\Admin\Page\StoreRequest;
use App\Content\Http\Requests\Admin\Page\UpdateRequest;
use App\Content\Page;
use App\Content\Page\Repository as PageRepository;
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
     * Shows all pages.
     *
     * @param PageRepository $pageRepository A page repository instance.
     *
     * @return View
     */
    public function index(PageRepository $pageRepository): View
    {
        $data = [
            'pages' => $pageRepository->getAll(),
        ];

        return view('admin.pages.index', $data);
    }

    /**
     * Displays the page create form.
     *
     * @param PageRepository $pageRepository A page repository instance.
     *
     * @return View
     */
    public function create(PageRepository $pageRepository): View
    {
        $data = [
            'templateOptions' => $pageRepository->getTemplateOptions(),
            'defaultTemplateOption' => 'default',
            'defaultPageOption' => 0,
        ];

        return view('admin.pages.create', $data);
    }

    /**
     * Saves a new page.
     *
     * @param StoreRequest   $request        A page store request.
     * @param PageRepository $pageRepository A page repository instance.
     *
     * @return RedirectResponse
     */
    public function store(StoreRequest $request, PageRepository $pageRepository): RedirectResponse
    {
        $inputData = [
            'title' => $request->has('title') ? $request->get('title') : null,
            'slug' => $request->has('slug') ? $request->get('slug') : null,
            'template' => $request->has('template') ? $request->get('template') : null,
            'content' => $request->has('content') ? $request->get('content') : null,
            'lead' => $request->has('lead') ? $request->get('lead') : null,
            'image_main' => $request->hasFile('image_main') ? $request->file('image_main') : null,
            'show_in_navigation' => $request->has('show_in_navigation') ? $request->get('show_in_navigation') : null,
            'selectable_in_navigation' => $request->has('selectable_in_navigation') ? $request->get('selectable_in_navigation') : null,
            'show_articles_in_navigation' => $request->has('show_articles_in_navigation') ? $request->get('show_articles_in_navigation') : null,
            'articles_per_page' => $request->has('articles_per_page') ? $request->get('articles_per_page') : null,
        ];

        $page = $pageRepository->create($inputData);

        $successMessage = trans(
            'admin/pages.successMessages.create',
            [
                'createUrl' => URL::action(static::class . '@create'),
            ],
        );

        return Redirect::action(static::class . '@edit', ['page' => $page->id])
            ->with('successMessages', new MessageBag([$successMessage]));
    }

    /**
     * Shows the specified page.
     *
     * @param Page           $page           The page to show.
     * @param PageRepository $pageRepository A page repository instance.
     *
     * @return View
     */
    public function edit(Page $page, PageRepository $pageRepository): View
    {
        $data = [
            'page' => $page,
            'templateOptions' => $pageRepository->getTemplateOptions(),
        ];

        return view('admin.pages.edit', $data);
    }

    /**
     * Updates the specified page.
     *
     * @param UpdateRequest  $request        A page update request.
     * @param Page           $page           The page to update.
     * @param PageRepository $pageRepository A page repository instance.
     *
     * @return RedirectResponse
     */
    public function update(UpdateRequest $request, Page $page, PageRepository $pageRepository): RedirectResponse
    {
        $updatedData = [
            'title' => $request->has('title') ? $request->get('title') : null,
            'slug' => $request->has('slug') ? $request->get('slug') : null,
            'template' => $request->has('template') ? $request->get('template') : null,
            'content' => $request->has('content') ? $request->get('content') : null,
            'lead' => $request->has('lead') ? $request->get('lead') : null,
            'image_main' => $request->hasFile('image_main') ? $request->file('image_main') : null,
            'image_main_delete' => $request->has('image_main_delete') ? $request->get('image_main_delete') : null,
            'show_in_navigation' => $request->has('show_in_navigation') ? $request->get('show_in_navigation') : null,
            'selectable_in_navigation' => $request->has('selectable_in_navigation') ? $request->get('selectable_in_navigation') : null,
            'show_articles_in_navigation' => $request->has('show_articles_in_navigation') ? $request->get('show_articles_in_navigation') : null,
            'articles_per_page' => $request->has('articles_per_page') ? $request->get('articles_per_page') : null,
        ];

        $pageRepository->update($page, $updatedData);

        $successMessage = trans('admin/pages.successMessages.edit');

        return Redirect::action(static::class . '@edit', ['page' => $page->id])
            ->with('successMessages', new MessageBag([$successMessage]));
    }

    /**
     * Displays the page deletion confirmation form.
     *
     * @param Page $page The page.
     *
     * @return View
     */
    public function confirmDelete(Page $page): View
    {
        $data = [
            'page' => $page,
        ];

        return view('admin.pages.delete', $data);
    }

    /**
     * Deletes a page.
     *
     * @param Request        $request        The current request.
     * @param Page           $page           The page to delete.
     * @param PageRepository $pageRepository A page repository instance.
     *
     * @return RedirectResponse
     */
    public function delete(Request $request, Page $page, PageRepository $pageRepository): RedirectResponse
    {
        if ($request->get('action') !== 'confirm') {
            return Redirect::action(static::class . '@index');
        }

        $pageRepository->delete($page);

        $successMessage = trans('admin/pages.successMessages.delete', ['title' => $page->title]);

        return Redirect::action(static::class . '@index')
            ->with('successMessages', new MessageBag([$successMessage]));
    }
}
