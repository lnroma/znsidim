<?php

namespace App\Policies;

use App\User;
use Illuminate\Auth\Access\HandlesAuthorization;

class AdminPolicy
{
    use HandlesAuthorization;

    /**
     * Create a new policy instance.
     *
     * @return void
     */
    public function superadmin(User $user)
    {
        if($user->role == 'superadmin') {
            return true;
        } else {
            return false;
        }
    }
}
