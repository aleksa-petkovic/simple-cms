<?php

declare(strict_types=1);

namespace App\Content\Http\Requests\Admin\Page;

use App\Content\ValidationRules\PageTemplate;
use App\Http\Requests\Request;

class StoreRequest extends Request
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
            'template' => [
                'required',
                app(PageTemplate::class),
            ],
            'image_main' => [
                'image',
                'max:10240',
            ],
        ];
    }
}
