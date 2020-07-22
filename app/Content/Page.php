<?php

declare(strict_types=1);

namespace App\Content;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Facades\URL;
use Library\Models\SluggableInterface;
use Library\Models\Traits\ImageableTrait;
use Library\Models\Traits\SluggableTrait;

class Page extends Model implements SluggableInterface
{
    use SluggableTrait;
    use ImageableTrait;
    use SoftDeletes;

    /**
     * @inheritDoc
     */
    protected $appends = [
        'url_image_main',
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
     * Eloquent relationship: a page may have many articles.
     *
     * @return HasMany
     */
    public function articles(): HasMany
    {
        $articles = $this->hasMany(Article::class);

        return $articles->orderBy('created_at', 'desc');
    }
}
