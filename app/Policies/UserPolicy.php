<?php

namespace App\Policies;

use App\Models\User;
use Illuminate\Auth\Access\Response;
use Illuminate\Support\Facades\Auth;

class UserPolicy
{
    /**
     * Determine whether the user can view any models.
     */
    
    public function before()
    {
        if( Auth::user()->type === 'super-admin'){
            return true;
        }
    }
    public function viewAny(User $user): bool
    {
        
        // return in_array('users.view',$user->role->abilities??[]);
        return $user->hasAppility('users.view');
    }

    /**
     * Determine whether the user can view the model.
     */
    public function view(User $user, User $model): bool
    {
        // return ;
        return $user->hasAppility('users.view');

    }

    /**
     * Determine whether the user can create models.
     */
    public function create(User $user): bool
    {
                return $user->hasAppility('users.create');

    }

    /**
     * Determine whether the user can update the model.
     */
    public function update(User $user, User $model): bool
    {
        return $user->hasAppility('users.update');

    }

    /**
     * Determine whether the user can delete the model.
     */
    public function delete(User $user, User $model): bool
    {
                return $user->hasAppility('users.delete');

    }

    /**
     * Determine whether the user can restore the model.
     */
    public function restore(User $user, User $model): bool
    {
                return $user->hasAppility('users.restore');

    }

    /**
     * Determine whether the user can permanently delete the model.
     */
    public function forceDelete(User $user, User $model): bool
    {
                return $user->hasAppility('users.force-delete');

    }
}
