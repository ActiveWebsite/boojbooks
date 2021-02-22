<?php

namespace App\Policies;

use App\Models\Book;
use App\Models\User;
use Illuminate\Auth\Access\HandlesAuthorization;

class BookPolicy
{
    use HandlesAuthorization;

    /**
     * Determine whether the book can view any models.
     *
     * @param  App\Models\User  $user
     * @return mixed
     */
    public function viewAny(User $user)
    {
        return $user->hasPermissionTo('list books');
    }

    /**
     * Determine whether the book can view the model.
     *
     * @param  App\Models\User  $user
     * @param  App\Models\Book  $model
     * @return mixed
     */
    public function view(User $user, Book $model)
    {
        return $user->hasPermissionTo('view books');
    }

    /**
     * Determine whether the book can create models.
     *
     * @param  App\Models\User  $user
     * @return mixed
     */
    public function create(User $user)
    {
        return $user->hasPermissionTo('create books');
    }

    /**
     * Determine whether the book can update the model.
     *
     * @param  App\Models\User  $user
     * @param  App\Models\Book  $model
     * @return mixed
     */
    public function update(User $user, Book $model)
    {
        return $user->hasPermissionTo('update books');
    }

    /**
     * Determine whether the book can delete the model.
     *
     * @param  App\Models\User  $user
     * @param  App\Models\Book  $model
     * @return mixed
     */
    public function delete(User $user, Book $model)
    {
        return $user->hasPermissionTo('delete books');
    }

    /**
     * Determine whether the book can restore the model.
     *
     * @param  App\Models\User  $user
     * @param  App\Models\Book  $model
     * @return mixed
     */
    public function restore(User $user, Book $model)
    {
        return false;
    }

    /**
     * Determine whether the book can permanently delete the model.
     *
     * @param  App\Models\User  $user
     * @param  App\Models\Book  $model
     * @return mixed
     */
    public function forceDelete(User $user, Book $model)
    {
        return false;
    }
}
