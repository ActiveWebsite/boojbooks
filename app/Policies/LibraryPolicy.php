<?php

namespace App\Policies;

use App\Models\User;
use App\Models\Library;
use Illuminate\Auth\Access\HandlesAuthorization;

class LibraryPolicy
{
    use HandlesAuthorization;

    /**
     * Determine whether the library can view any models.
     *
     * @param  App\Models\User  $user
     * @return mixed
     */
    public function viewAny(User $user)
    {
        return $user->hasPermissionTo('list libraries');
    }

    /**
     * Determine whether the library can view the model.
     *
     * @param  App\Models\User  $user
     * @param  App\Models\Library  $model
     * @return mixed
     */
    public function view(User $user, Library $model)
    {
        return $user->hasPermissionTo('view libraries');
    }

    /**
     * Determine whether the library can create models.
     *
     * @param  App\Models\User  $user
     * @return mixed
     */
    public function create(User $user)
    {
        return $user->hasPermissionTo('create libraries');
    }

    /**
     * Determine whether the library can update the model.
     *
     * @param  App\Models\User  $user
     * @param  App\Models\Library  $model
     * @return mixed
     */
    public function update(User $user, Library $model)
    {
        return $user->hasPermissionTo('update libraries');
    }

    /**
     * Determine whether the library can delete the model.
     *
     * @param  App\Models\User  $user
     * @param  App\Models\Library  $model
     * @return mixed
     */
    public function delete(User $user, Library $model)
    {
        return $user->hasPermissionTo('delete libraries');
    }

    /**
     * Determine whether the library can restore the model.
     *
     * @param  App\Models\User  $user
     * @param  App\Models\Library  $model
     * @return mixed
     */
    public function restore(User $user, Library $model)
    {
        return false;
    }

    /**
     * Determine whether the library can permanently delete the model.
     *
     * @param  App\Models\User  $user
     * @param  App\Models\Library  $model
     * @return mixed
     */
    public function forceDelete(User $user, Library $model)
    {
        return false;
    }
}
