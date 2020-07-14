<?php

declare(strict_types=1);

namespace App\Auth\User;

use App\Auth\User;
use Carbon\Carbon;
use Cartalyst\Sentinel\Sentinel;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Support\Arr;

class Repository
{
    /**
     * A User model instance.
     */
    protected User $userModel;

    /**
     * A Sentinel instance.
     */
    protected Sentinel $sentinel;

    /**
     * @param User     $userModel A user model instance.
     * @param Sentinel $sentinel  A Sentinel instance.
     */
    public function __construct(User $userModel, Sentinel $sentinel)
    {
        $this->userModel = $userModel;
        $this->sentinel = $sentinel;
    }

    /**
     * Gets all users.
     *
     * @return Collection
     */
    public function getAll(): Collection
    {
        return $this->userModel->all();
    }

    /**
     * Gets all users with the 'user' role and filters them by input.
     *
     * @param array     $inputData   The input data for filtering.
     * @param User|null $ignoredUser Optional user to ignore. This will usually be the currently authenticated user.
     *
     * @return Collection
     */
    public function searchUsers(array $inputData, ?User $ignoredUser = null): Collection
    {
        $users = $this->userModel->whereHas('roles', static function (Builder $query): void {
            $query->where(static function (Builder $query): void {
                $query->orWhere('slug', 'user');
            });
        });

        if (isset($inputData['filter']) && $inputData['filter']) {
            $users->search($inputData['filter']);
        }

        if ($ignoredUser !== null) {
            $users->where('id', '<>', $ignoredUser->id);
        }

        return $users->get();
    }

    /**
     * Gets all users with the 'user' role by IDs.
     *
     * @param array $userIds The user IDs to find.
     *
     * @return Collection
     */
    public function findUsersByIds(array $userIds): Collection
    {
        $users = $this->userModel->whereHas('roles', static function (Builder $query): void {
            $query->where(static function (Builder $query): void {
                $query->orWhere('slug', 'user');
            });
        });

        $users->whereIn('id', $userIds);

        return $users->get();
    }

    /**
     * Gets a user by email.
     *
     * @param string $email The email address.
     *
     * @return User|null
     */
    public function findByEmail(string $email): ?User
    {
        return $this->userModel->where('email', $email)->get()->first();
    }

    /**
     * Finds the user by ID, or throws an exception if the ID doesn't exist.
     *
     * @param int $id The user's ID.
     *
     * @return User
     */
    public function findOrFail(int $id): User
    {
        return $this->userModel->findOrFail($id);
    }

    /**
     * Gets all users with any of the specified roles.
     *
     * @param array $roles An array of role slugs. If empty, only users without roles will be returned.
     *
     * @return Collection
     */
    public function getUsersWithAnyRoles(array $roles = []): Collection
    {
        if (empty($roles)) {
            return $this->getUsersWithoutRoles();
        }

        // The nesting below may seem a bit weird, but it's actually there so as
        // to generate the correct query with regards to the grouping of `AND`
        // and `OR` conditions.
        return $this->userModel->whereHas('roles', static function (Builder $query) use ($roles): void {
            $query->where(static function (Builder $query) use ($roles): void {
                foreach ($roles as $role) {
                    $query->orWhere('slug', $role);
                }
            });
        })->get();
    }

    /**
     * Returns all users that have no roles.
     *
     * @return Collection
     */
    public function getUsersWithoutRoles(): Collection
    {
        return $this->userModel->withoutRoles()->get();
    }

    /**
     * Gets all admins.
     *
     * @return Collection
     */
    public function getAdmins(): Collection
    {
        // The nesting below may seem a bit weird, but it's actually there so as
        // to generate the correct query with regards to the grouping of `AND`
        // and `OR` conditions.
        return $this->userModel->whereHas('roles', static function (Builder $query): void {
            $query->where(static function (Builder $query): void {
                $query->orWhere('slug', 'admin');
            });
        })->get();
    }

    /**
     * Creates and activates a new user and returns it.
     *
     * @param array $inputData The input data for the new user.
     *
     * @return User
     */
    public function create(array $inputData): User
    {
        $userConfig = [
            'email' => Arr::get($inputData, 'email', ''),
            'password' => Arr::get($inputData, 'password', $this->generatePassword()),
            'first_name' => Arr::get($inputData, 'first_name', ''),
            'last_name' => Arr::get($inputData, 'last_name', ''),
        ];

        $user = $this->sentinel->registerAndActivate($userConfig);

        $user->save();

        $role = $this->sentinel->findRoleBySlug($inputData['role']);
        $role->users()->attach($user);

        return $user;
    }

    /**
     * Updates the passed user and returns it.
     *
     * @param User  $user      The user to update.
     * @param array $inputData Input data for the update.
     *
     * @return User
     */
    public function update(User $user, array $inputData): User
    {
        $userConfig = [
            'email' => Arr::get($inputData, 'email', $user->email),
            'first_name' => Arr::get($inputData, 'first_name', $user->first_name),
            'last_name' => Arr::get($inputData, 'last_name', $user->last_name),
        ];

        if (!empty($inputData['password'])) {
            $userConfig['password'] = $inputData['password'];
        }

        $this->sentinel->update($user, $userConfig);

        if (!empty($inputData['role'])) {
            $role = $this->sentinel->findRoleBySlug($inputData['role']);
            $user->roles()->sync([$role->id]);
        }

        return $user;
    }

    /**
     * Deletes the passed user from the system.
     *
     * @param User $user The user to delete.
     *
     * @return bool|null
     */
    public function delete(User $user): ?bool
    {
        return $user->delete();
    }

    /**
     * Partialy updates the passed user and returns it.
     *
     * Same as the regular update, but doesn't ever update the password, no
     * matter what's passed in the input data.
     *
     * @param User  $user      The user to update.
     * @param array $inputData Input data for the update.
     *
     * @return User
     */
    public function partialUpdate(User $user, array $inputData): User
    {
        $userConfig = [
            'email' => $inputData['email'],
            'first_name' => $inputData['first_name'],
            'last_name' => $inputData['last_name'],
        ];

        $this->sentinel->update($user, $userConfig);

        return $user;
    }

    /**
     * Changes the password for a user and returns it.
     *
     * @param User   $user     The user whose password should be updated.
     * @param string $password The new password.
     *
     * @return User
     */
    public function setPassword(User $user, string $password): User
    {
        $credentials = [
            'password' => $password,
        ];

        $this->sentinel->update($user, $credentials);

        return $user;
    }

    /**
     * Generates a numeric password with a specific length.
     *
     * The default length is 6 digits.
     *
     * This is not meant to be secure in any way.
     *
     * @param int $length The length of the generated password.
     *
     * @return string
     */
    public function generatePassword(int $length = 6): string
    {
        $pool = '0123456789';

        return substr(str_shuffle(str_repeat($pool, $length)), 0, $length);
    }
}
