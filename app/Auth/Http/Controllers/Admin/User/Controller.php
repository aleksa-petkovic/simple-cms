<?php

declare(strict_types=1);

namespace App\Auth\Http\Controllers\Admin\User;

use App\Auth\Http\Requests\Admin\User\DeleteRequest;
use App\Auth\Http\Requests\Admin\User\StoreRequest;
use App\Auth\Http\Requests\Admin\User\UpdateRequest;
use App\Auth\Role\Repository as RoleRepository;
use App\Auth\User;
use App\Auth\User\Repository as UserRepository;
use App\Auth\User\Service as UserService;
use App\Http\Controllers\Admin\Controller as BaseController;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Arr;
use Illuminate\Support\Facades\Redirect;
use Illuminate\View\View;

class Controller extends BaseController
{
    /**
     * A UserRepository instance.
     *
     * @var UserRepository
     */
    protected $userRepository;

    /**
     * A RoleRepository instance.
     *
     * @var RoleRepository
     */
    protected $roleRepository;

    /**
     * @param UserRepository $userRepository A user repository instance.
     * @param RoleRepository $roleRepository A role repository instance.
     */
    public function __construct(UserRepository $userRepository, RoleRepository $roleRepository)
    {
        parent::__construct();

        $this->userRepository = $userRepository;
        $this->roleRepository = $roleRepository;

        $this->viewData->navigation->get('admin.main')->setActive('users');
    }

    /**
     * Shows all users.
     *
     * @param Request $request The current request instance.
     *
     * @return View
     */
    public function index(Request $request): View
    {
        if ($request->has('roles')) {
            $users = $this->userRepository->getUsersWithAnyRoles($request->get('roles'));
        } else {
            $users = $this->userRepository->getAll();
        }

        $data = [
            'users' => $users,
        ];

        return view('admin.users.index', $data);
    }

    /**
     * Displays the user create form.
     *
     * @return View
     */
    public function create(): View
    {
        $data = [
            'roleOptions' => $this->roleRepository->getOptions(),
            'defaultRoleOption' => 'user',
        ];

        return view('admin.users.create', $data);
    }

    /**
     * Saves a new user.
     *
     * @param StoreRequest $request     The user store request.
     * @param UserService  $userService A UserService instance.
     *
     * @return RedirectResponse
     */
    public function store(StoreRequest $request, UserService $userService): RedirectResponse
    {
        $data = $request->all();

        $userService->create(
            $data['role'],
            $data['email'],
            empty($data['password']) ? $userService->generateMediumPassword() : $data['password'],
            $data['first_name'],
            $data['last_name'],
            (bool) Arr::get($data, 'send_welcome_email', false),
            );

        return Redirect::action(static::class . '@index');
    }

    /**
     * Shows the specified user.
     *
     * @param User $user The user instance.
     *
     * @return View
     */
    public function edit(User $user): View
    {
        $data = [
            'roleOptions' => $this->roleRepository->getOptions(),
            'user' => $user,
        ];

        return view('admin.users.edit', $data);
    }

    /**
     * Updates the specified user.
     *
     * @param UpdateRequest $request The user update request.
     * @param User          $user    The user instance.
     *
     * @return RedirectResponse
     */
    public function update(UpdateRequest $request, User $user): RedirectResponse
    {
        $this->userRepository->update($user, $request->all());

        return Redirect::action(static::class . '@index');
    }

    /**
     * Displays the user deletion confirmation form.
     *
     * @param DeleteRequest $request The user delete request.
     * @param User          $user    The user instance.
     *
     * @return View
     */
    public function confirmDelete(DeleteRequest $request, User $user): View
    {
        $data = [
            'user' => $user,
        ];

        return view('admin.users.delete', $data);
    }

    /**
     * Deletes a user.
     *
     * @param DeleteRequest $request The user delete request.
     * @param User          $user    The user instance.
     *
     * @return RedirectResponse
     */
    public function delete(DeleteRequest $request, User $user): RedirectResponse
    {
        if ($request->get('action') !== 'confirm') {
            return Redirect::action(static::class . '@index');
        }

        $this->userRepository->delete($user);

        return Redirect::action(static::class . '@index');
    }
}
