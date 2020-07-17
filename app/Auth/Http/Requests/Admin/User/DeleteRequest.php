<?php

declare(strict_types=1);

namespace App\Auth\Http\Requests\Admin\User;

use App\Http\Requests\Request;
use Cartalyst\Sentinel\Sentinel;

class DeleteRequest extends Request
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @param Sentinel $sentinel A Sentinel instance.
     *
     * @return bool
     */
    public function authorize(Sentinel $sentinel): bool
    {
        // A user cannot delete themselves.
        return $this->route('user')->id !== $sentinel->getUser()->id;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules(): array
    {
        return [];
    }
}
