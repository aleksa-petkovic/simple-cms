<?php

declare(strict_types=1);

namespace Library\ViewData;

use App\Auth\User;
use Illuminate\Support\Facades\Config;
use stdClass;

class ViewData
{
    /**
     * The current user.
     *
     * Should be attached later in the app lifecycle, via a middleware.
     *
     * @var User|null
     */
    public $currentUser;

    /**
     * An object for containing meta parameters.
     *
     * @var stdClass
     */
    public $meta;

    /**
     */
    public function __construct()
    {
        $this->meta = new stdClass();
        $this->meta->description = '';
        $this->meta->opengraph = [];

        $this->currentUser = null;
    }

    /**
     * Sets the SEO tags.
     *
     * @param SeoPresenter $presenter A SeoPresenter implementation.
     *
     * @return void
     */
    public function setSeo(SeoPresenter $presenter): void
    {
        $this->meta->opengraph['og:type'] = $presenter->getType();

        if ($presenter->hasSiteName()) {
            $this->pageTitle->setSiteName($presenter->getSiteName());
            $this->meta->opengraph['og:site_name'] = $presenter->getSiteName();
        }

        if ($presenter->hasLocale()) {
            $this->meta->opengraph['og:locale'] = $presenter->getLocale();
        }

        if ($presenter->hasTitle()) {
            $title = $presenter->getTitle();

            if ($presenter->overridesTitle()) {
                $this->pageTitle->setOverride($title);
            } else {
                $this->pageTitle->setPage($title);
            }
        }

        $this->meta->opengraph['og:title'] = $this->pageTitle->render();

        if ($presenter->hasDescription()) {
            $description = $presenter->getDescription();

            $this->meta->description = $description;
            $this->meta->opengraph['og:description'] = $description;
        }

        // phpcs:ignore SlevomatCodingStandard.ControlStructures.EarlyExit.EarlyExitNotUsed -- This is nicer than early exit
        if ($presenter->hasImage()) {
            $this->meta->opengraph['og:image'] = $presenter->getImage();
        }
    }
}
