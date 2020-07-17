<?php

declare(strict_types=1);

namespace App\Auth\Http\Requests\Admin\User;

use App\Auth\Role\Repository as RoleRepository;
use App\Http\Requests\Request;

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
     * @param RoleRepository $roleRepository A role repository instance.
     *
     * @return array
     */
    public function rules(RoleRepository $roleRepository): array
    {
        $userId = $this->route('user')->id;
        $roles = implode(',', array_keys($roleRepository->getOptions()));

        return [
            'email' => [
                'required',
                'email',
                "unique:users,email,{$userId}",
            ],
            'first_name' => [
                'required',
            ],
            'last_name' => [
                'required',
            ],
            'role' => [
                'required',
                "in:{$roles}",
            ],
        ];
    }
}
