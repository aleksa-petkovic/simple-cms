<?php

declare(strict_types=1);

namespace Library\Navigation;

use Illuminate\Support\Collection;

class Navigation
{
    /**
     * Navigation items.
     *
     * @var Collection
     */
    protected $items;

    /**
     * The key of the active item.
     *
     * @var string|null
     */
    protected $active = null;

    /**
     */
    public function __construct()
    {
        $this->items = new Collection();
    }

    /**
     * Returns the currently active item key.
     *
     * @return string|null
     */
    public function getActive(): ?string
    {
        return $this->active;
    }

    /**
     * Sets the currently active item key.
     *
     * @param string|null $name The key of the active item.
     *
     * @return $this
     */
    public function setActive(?string $name): Navigation
    {
        $this->active = $name;

        return $this;
    }

    /**
     * Returns the internal collection.
     *
     * @return Collection
     */
    public function getItems(): Collection
    {
        return $this->items;
    }

    /**
     * Appends an item onto the beginning, preserving keys.
     *
     * @param string $key   The key of the item.
     * @param mixed  $value The navigation item to add.
     *
     * @return $this
     */
    public function addFirst(string $key, $value): Navigation
    {
        $this->items = $this->items
            ->reverse()
            ->put($key, $value)
            ->reverse();

        return $this;
    }

    /**
     * Appends an item onto the end, preserving keys.
     *
     * @param string $key   The key of the item.
     * @param mixed  $value The navigation item to add.
     *
     * @return $this
     */
    public function addLast(string $key, $value): Navigation
    {
        $this->items->put($key, $value);

        return $this;
    }

    /**
     * Adds a a new item before a specific key.
     *
     * @param string $beforeKey The key before which the item should be added.
     * @param string $newKey    The new item's key.
     * @param mixed  $value     The navigation item to add.
     *
     * @return $this
     */
    public function addBefore(string $beforeKey, string $newKey, $value): Navigation
    {
        $items = [];

        $added = false;

        foreach ($this->items as $key => $item) {
            if ($key === $beforeKey) {
                $items[$newKey] = $value;

                $added = true;
            }

            $items[$key] = $item;
        }

        if (!$added) {
            $items[$newKey] = $value;
        }

        $this->items = new Collection($items);

        return $this;
    }

    /**
     * Adds a new item after a specific key.
     *
     * @param string $afterKey The key after which the item should be added.
     * @param string $newKey   The new item's key.
     * @param mixed  $value    The navigation item to add.
     *
     * @return $this
     */
    public function addAfter(string $afterKey, string $newKey, $value): Navigation
    {
        $items = [];

        $added = false;

        foreach ($this->items as $key => $item) {
            $items[$key] = $item;

            if ($key !== $afterKey) {
                continue;
            }

            $items[$newKey] = $value;

            $added = true;
        }

        if (!$added) {
            $items[$newKey] = $value;
        }

        $this->items = new Collection($items);

        return $this;
    }
}
