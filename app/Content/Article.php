<?php

declare(strict_types=1);

namespace App\Content;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Facades\URL;
use Library\Models\SluggableInterface;
use Library\Models\Traits\ImageableTrait;
use Library\Models\Traits\SluggableTrait;

class Article extends Model implements SluggableInterface
{
    use ImageableTrait;
    use SluggableTrait;
    use SoftDeletes;

    /**
     * @inheritDoc
     */
    protected $appends = [
        'url_image_main',
        'full_slug',
    ];

    /**
     * @inheritDoc
     */
    public function getImageConfiguration(): array
    {
        return [
            'versions' => [
                'main',
            ],
        ];
    }

    /**
     * Gets the complete URL to the image main.
     *
     * @return string
     */
    public function getUrlImageMainAttribute(): string
    {
        return URL::to($this->getImage('main'));
    }

    /**
     * Eloquent relationship: an article belongs to a parent page.
     *
     * @return BelongsTo
     */
    public function page(): BelongsTo
    {
        return $this->belongsTo('App\Content\Page');
    }

    /**
     * Get article full slug.
     *
     * @return string
     */
    public function getFullSlugAttribute(): string
    {
        $fullSlug = trim("{$this->page->slug}/{$this->slug}");

        if ($fullSlug !== '') {
            return $fullSlug;
        }
    }
}
