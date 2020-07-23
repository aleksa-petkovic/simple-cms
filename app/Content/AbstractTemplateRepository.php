<?php

declare(strict_types=1);

namespace App\Content;

use Illuminate\Config\Repository as ConfigRepository;
use RuntimeException;

abstract class AbstractTemplateRepository
{
    /**
     * A Config repository instance.
     *
     * @var ConfigRepository
     */
    protected $config;

    /**
     * An array of available templates.
     *
     * @var array
     */
    protected $templates = [];

    /**
     * @param ConfigRepository $config A Config repository instance.
     */
    public function __construct(ConfigRepository $config)
    {
        $this->config = $config;

        $this->templates = $this->loadTemplates();
    }

    /**
     * Returns the templates for this template repository.
     *
     * @return array
     */
    abstract protected function loadTemplates(): array;

    /**
     * Checks whether a specified template exists.
     *
     * @param string $id The template ID.
     *
     * @return bool
     */
    public function templateExists(string $id): bool
    {
        return isset($this->templates[$id]);
    }

    /**
     * Gets a specific template's configuration.
     *
     * @param string $id The template ID.
     *
     * @throws RuntimeException
     *
     * @return array
     */
    public function getTemplate(string $id): array
    {
        if (!$this->templateExists($id)) {
            throw new RuntimeException('The provided template does not exist.');
        }

        return $this->templates[$id];
    }

    /**
     * Returns all the templates.
     *
     * @return array
     */
    public function getTemplates(): array
    {
        return $this->templates;
    }
}
