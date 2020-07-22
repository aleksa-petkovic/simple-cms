<?php

declare(strict_types=1);

namespace Library\Navigation;

class Factory
{
    /**
     * An array of individual navigation elements.
     *
     * @var array
     */
    protected array $navigations = [];

    /**
     * Gets a named navigation, or creates one, if it doesn't exist yet.
     *
     * @param string $name The navigation name.
     *
     * @return Navigation
     */
    public function get(string $name): Navigation
    {
        if (!isset($this->navigations[$name])) {
            $this->navigations[$name] = $this->make();
        }

        return $this->navigations[$name];
    }

    /**
     * Creates a new Navigation instance.
     *
     * @return Navigation
     */
    public function make(): Navigation
    {
        return new Navigation();
    }

    /**
     * A helper method for easier fetching of named navigations.
     *
     * @param string $name The navigation name.
     *
     * @return Navigation
     */
    public function __invoke(string $name): Navigation
    {
        return $this->get($name);
    }
}
