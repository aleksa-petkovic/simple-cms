<?php

declare(strict_types=1);

namespace App\Content\Http\Requests\Admin\Article;

use App\Content\ValidationRules\ArticleTemplate;
use App\Http\Requests\Request;
use App\Validation\Rules\Slug;

class UpdateRequest extends Request
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize(): bool
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules(): array
    {
        return [
            'title' => [
                'required',
            ],
            'slug' => [
                app(Slug::class),
            ],
            'template' => [
                'required',
                app(ArticleTemplate::class),
            ],
            'image_main' => [
                'image',
                'max:10240',
            ],
        ];
    }
}
