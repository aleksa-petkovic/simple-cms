<?php

declare(strict_types=1);

namespace App\Content\ValidationRules;

use App\Content\Article\TemplateRepository as ArticleTemplateRepository;
use Illuminate\Contracts\Validation\Rule;

class ArticleTemplate implements Rule
{
    /**
     * An article template repository.
     *
     * @var ArticleTemplateRepository
     */
    private $articleTemplateRepository;

    /**
     * @param ArticleTemplateRepository $articleTemplateRepository An article template repository.
     */
    public function __construct(ArticleTemplateRepository $articleTemplateRepository)
    {
        $this->articleTemplateRepository = $articleTemplateRepository;
    }

    /**
     * Determine if the validation rule passes.
     *
     * @param string $attribute The input attribute name.
     * @param mixed  $value     The input value.
     *
     * @return bool
     */
    public function passes($attribute, $value): bool
    {
        return array_key_exists(
            $value,
            $this->articleTemplateRepository->getTemplates(),
        );
    }

    /**
     * Get the validation error message.
     *
     * @return string
     */
    public function message(): string
    {
        return 'The passed article template is invalid.';
    }
}
