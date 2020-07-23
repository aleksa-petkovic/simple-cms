<?php

declare(strict_types=1);

namespace App\Content\Page;

use App\Content\Page;
use App\Content\Page\TemplateRepository as PageTemplateRepository;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Support\Arr;

class Repository
{
    /**
     * A Page model instance.
     *
     * @var Page
     */
    protected $pageModel;

    /**
     * A PageTemplateRepository instance.
     *
     * @var PageTemplateRepository
     */
    protected $pageTemplateRepository;

    /**
     * @param Page                   $pageModel              A Page model instance.
     * @param PageTemplateRepository $pageTemplateRepository A PageTemplateRepository instance.
     */
    public function __construct(Page $pageModel, PageTemplateRepository $pageTemplateRepository)
    {
        $this->pageModel = $pageModel;
        $this->pageTemplateRepository = $pageTemplateRepository;
    }

    /**
     * Finds a page by its ID or fails.
     *
     * @param int $id The page ID.
     *
     * @return Page
     */
    public function findOrFail(int $id): Page
    {
        return $this->pageModel->findOrFail($id);
    }

    /**
     * Finds a page by its slug.
     *
     * @param string $slug The page slug.
     *
     * @return Page
     */
    public function findBySlug(string $slug): Page
    {
        return $this->pageModel->where('slug', $slug)->get()->first();
    }

    /**
     * Returns the template options.
     *
     * @return array
     */
    public function getTemplateOptions(): array
    {
        $templates = $this->pageTemplateRepository->getTemplates();
        $options = [];

        foreach ($templates as $id => $template) {
            $options[$id] = $template['label'];
        }

        return $options;
    }

    /**
     * Gets all the pages.
     *
     * @return Collection
     */
    public function getAll(): Collection
    {
        return $this->pageModel->get();
    }

    /**
     * Gets all the pages by template.
     *
     * @param string $template The template ID.
     *
     * @return Collection
     */
    public function getAllByTemplate(string $template): Collection
    {
        return $this->pageModel->whereTemplate($template)->get();
    }

    /**
     * Creates a new page and returns it.
     *
     * @param array $inputData The input data.
     *
     * @return Page
     */
    public function create(array $inputData): Page
    {
        return $this->populateAndSave($this->pageModel->newInstance(), $inputData);
    }

    /**
     * Updates the passed page and returns it.
     *
     * @param Page  $page      The page to update.
     * @param array $inputData The input data.
     *
     * @return Page
     */
    public function update(Page $page, array $inputData): Page
    {
        return $this->populateAndSave($page, $inputData);
    }

    /**
     * Populates the passed Page instance with the input data.
     *
     * @param Page  $page      The page to populate.
     * @param array $inputData The input data.
     *
     * @return Page
     */
    protected function populate(Page $page, array $inputData): Page
    {
        $page->title = Arr::get($inputData, 'title', '');
        $page->slug = Arr::get($inputData, 'slug', '');
        $page->template = Arr::get($inputData, 'template', 'default');

        $page->lead = Arr::get($inputData, 'lead', '');
        $page->content = Arr::get($inputData, 'content', '');

        $page->show_in_navigation = (bool) Arr::get($inputData, 'show_in_navigation', false);
        $page->selectable_in_navigation = (bool) Arr::get($inputData, 'selectable_in_navigation', false);
        $page->show_articles_in_navigation = (bool) Arr::get($inputData, 'show_articles_in_navigation', false);
        $page->articles_per_page = (int) Arr::get($inputData, 'articles_per_page', 10);

        if (isset($inputData['image_main_delete'])) {
            $page->deleteImage('main');
        }

        if (isset($inputData['image_main'])) {
            $page->uploadImage($inputData['image_main'], 'main');
        }

        return $page;
    }

    /**
     * Populates the passed instance with the input data, saves and returns it.
     *
     * @param Page  $page      The page to populate and save.
     * @param array $inputData The input data.
     *
     * @return Page
     */
    protected function populateAndSave(Page $page, array $inputData): Page
    {
        $page = $this->populate($page, $inputData);

        $page->save();

        return $page;
    }

    /**
     * Deletes the passed page from the system.
     *
     * @param Page $page The page to delete.
     *
     * @return bool|null
     */
    public function delete(Page $page): ?bool
    {
        return $page->delete();
    }
}
