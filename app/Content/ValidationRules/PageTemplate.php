<?php

declare(strict_types=1);

namespace App\Content\ValidationRules;

use App\Content\Page\TemplateRepository as PageTemplateRepository;
use Illuminate\Contracts\Validation\Rule;

class PageTemplate implements Rule
{
    /**
     * A page template repository.
     *
     * @var PageTemplateRepository
     */
    private $pageTemplateRepository;

    /**
     * @param PageTemplateRepository $pageTemplateRepository A page template repository.
     */
    public function __construct(PageTemplateRepository $pageTemplateRepository)
    {
        $this->pageTemplateRepository = $pageTemplateRepository;
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
            $this->pageTemplateRepository->getTemplates(),
        );
    }

    /**
     * Get the validation error message.
     *
     * @return string
     */
    public function message(): string
    {
        return 'The passed page template is invalid.';
    }
}
