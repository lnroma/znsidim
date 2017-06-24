<?php

namespace App\Policies;

use App\User;
use Illuminate\Auth\Access\HandlesAuthorization;

class UsersPolicy
{
    use HandlesAuthorization;

    /**
     * Create a new policy instance.
     *
     * @return void
     */
    public function __construct()
    {
        //
    }

    public function photoOwner(User $user, User $userOwner)
    {
        if($user->id == $userOwner->id) {
            return true;
        } else {
            return false;
        }
    }
}
