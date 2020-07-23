<?php

declare(strict_types=1);

use Cartalyst\Sentinel\Roles\EloquentRole;
use Cartalyst\Sentinel\Sentinel;
use Illuminate\Database\Seeder;

class RoleSeeder extends Seeder
{
    /**
     * A Sentinel instance.
     */
    protected Sentinel $sentinel;

    /**
     * Role configuration.
     */
    protected array $roles = [
        [
            'name' => 'Admin',
            'slug' => 'admin',
            'permissions' => [
                'App\Http\Controllers\Admin\HomeController@index' => true,

                'App\Auth\Http\Controllers\Admin\User\Controller@index' => true,
                'App\Auth\Http\Controllers\Admin\User\Controller@create' => true,
                'App\Auth\Http\Controllers\Admin\User\Controller@store' => true,
                'App\Auth\Http\Controllers\Admin\User\Controller@edit' => true,
                'App\Auth\Http\Controllers\Admin\User\Controller@update' => true,
                'App\Auth\Http\Controllers\Admin\User\Controller@confirmDelete' => true,
                'App\Auth\Http\Controllers\Admin\User\Controller@delete' => true,

                'App\Content\Http\Controllers\Admin\Page\Controller@index' => true,
                'App\Content\Http\Controllers\Admin\Page\Controller@create' => true,
                'App\Content\Http\Controllers\Admin\Page\Controller@store' => true,
                'App\Content\Http\Controllers\Admin\Page\Controller@edit' => true,
                'App\Content\Http\Controllers\Admin\Page\Controller@update' => true,
                'App\Content\Http\Controllers\Admin\Page\Controller@confirmDelete' => true,
                'App\Content\Http\Controllers\Admin\Page\Controller@delete' => true,

                'App\Content\Http\Controllers\Admin\Article\Controller@index' => true,
                'App\Content\Http\Controllers\Admin\Article\Controller@create' => true,
                'App\Content\Http\Controllers\Admin\Article\Controller@store' => true,
                'App\Content\Http\Controllers\Admin\Article\Controller@edit' => true,
                'App\Content\Http\Controllers\Admin\Article\Controller@update' => true,
                'App\Content\Http\Controllers\Admin\Article\Controller@confirmDelete' => true,
                'App\Content\Http\Controllers\Admin\Article\Controller@delete' => true,

                'App\Http\Controllers\Admin\LoginController@logout' => true,
            ],
        ],
        [
            'name' => 'User',
            'slug' => 'user',
            'permissions' => [],
        ],
    ];

    /**
     * @param Sentinel $sentinel An instance of Sentinel.
     */
    public function __construct(Sentinel $sentinel)
    {
        $this->sentinel = $sentinel;
    }

    /**
     * @inheritDoc
     *
     * @return void
     */
    public function run(): void
    {
        foreach ($this->roles as $roleConfig) {
            $role = $this->sentinel->findRoleBySlug($roleConfig['slug']);

            if ($role === null) {
                $this->createRole($roleConfig);
            } else {
                $this->updateRole($role, $roleConfig);
            }
        }
    }

    /**
     * Creates the passed role.
     *
     * @param array $roleConfig The role configuration.
     *
     * @return void
     */
    protected function createRole(array $roleConfig): void
    {
        $this->sentinel->getRoleRepository()->createModel()->create($roleConfig);
    }

    /**
     * Updates the passed role with the specified parameters.
     *
     * @param EloquentRole $role       The Eloquent role instance.
     * @param array        $roleConfig The role configuration.
     *
     * @return void
     */
    protected function updateRole(EloquentRole $role, array $roleConfig): void
    {
        $role->name = $roleConfig['name'];
        $role->permissions = $roleConfig['permissions'];

        $role->save();
    }
}

