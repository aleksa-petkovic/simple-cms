<?php

declare(strict_types=1);

namespace App\Content\Page;

use App\Content\AbstractTemplateRepository;

class TemplateRepository extends AbstractTemplateRepository
{
    /**
     * @inheritDoc
     */
    protected function loadTemplates(): array
    {
        return $this->config->get('templates.pages');
    }
}
