<?php

declare(strict_types=1);

namespace App\Content\Article;

use App\Content\Article;
use App\Content\Article\TemplateRepository as ArticleTemplateRepository;
use Illuminate\Support\Arr;

class Repository
{
    /**
     * An Article model instance.
     *
     * @var Article
     */
    protected $articleModel;

    /**
     * An ArticleTemplateRepository instance.
     *
     * @var ArticleTemplateRepository
     */
    protected $templateRepository;

    /**
     * @param Article                   $articleModel       An Article model instance.
     * @param ArticleTemplateRepository $templateRepository An ArticleTemplateRepository instance.
     */
    public function __construct(Article $articleModel, ArticleTemplateRepository $templateRepository)
    {
        $this->articleModel = $articleModel;
        $this->templateRepository = $templateRepository;
    }

    /**
     * Finds an article with the specified ID or fails.
     *
     * @param int $id The article ID.
     *
     * @return Article
     */
    public function findOrFail(int $id): Article
    {
        return $this->articleModel->findOrFail($id);
    }

    /**
     * Finds and article by its slug.
     *
     * @param string $slug The article slug.
     *
     * @return Article
     */
    public function findBySlug(string $slug): Article
    {
        return $this->articleModel->where('slug', $slug)->get()->first();
    }

    /**
     * Creates a new article and returns it.
     *
     * @param array $inputData The input data.
     *
     * @return Article
     */
    public function create(array $inputData): Article
    {
        $article = $this->articleModel->newInstance();

        $article->page_id = $inputData['page']->id;

        return $this->populateAndSave($article, $inputData);
    }

    /**
     * Updates the passed article and returns it.
     *
     * @param Article $article   The article to update.
     * @param array   $inputData The input data.
     *
     * @return Article
     */
    public function update(Article $article, array $inputData): Article
    {
        (int) $inputData['page_id'] = $article->page_id;

        return $this->populateAndSave($article, $inputData);
    }

    /**
     * Populates the passed Article instance with the input data.
     *
     * @param Article $article   The article to populate.
     * @param array   $inputData The input data.
     *
     * @return Article
     */
    protected function populate(Article $article, array $inputData): Article
    {
        $article->page_id = Arr::get($inputData, 'page_id', $article->page_id);
        $article->title = Arr::get($inputData, 'title', '');
        $article->slug = Arr::get($inputData, 'slug', '');
        $article->template = Arr::get($inputData, 'template', 'default');

        $article->lead = Arr::get($inputData, 'lead', '');
        $article->content = Arr::get($inputData, 'content', '');

        if (isset($inputData['image_main_delete'])) {
            $article->deleteImage('main');
        }

        if (isset($inputData['image_main'])) {
            $article->uploadImage($inputData['image_main'], 'main');
        }

        return $article;
    }

    /**
     * Populates the passed instance with the input data, saves and returns it.
     *
     * @param Article $article   The article to populate and save.
     * @param array   $inputData The input data.
     *
     * @return Article
     */
    protected function populateAndSave(Article $article, array $inputData): Article
    {
        $article = $this->populate($article, $inputData);

        $article->save();

        return $article;
    }

    /**
     * Deletes the passed article from the system.
     *
     * @param Article $article The article to delete.
     *
     * @return bool|null
     */
    public function delete(Article $article): ?bool
    {
        return $article->delete();
    }

    /**
     * Returns the template options.
     *
     * @return array
     */
    public function getTemplateOptions(): array
    {
        $templates = $this->templateRepository->getTemplates();

        $options = [];

        foreach ($templates as $id => $template) {
            $options[$id] = $template['label'];
        }

        return $options;
    }
}
