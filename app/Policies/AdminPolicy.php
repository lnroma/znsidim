<?php

namespace App\Policies;

use App\Helpers\User;
use Illuminate\Auth\Access\HandlesAuthorization;
use Illuminate\Foundation\Console\PolicyMakeCommand;
use Taskforcedev\LaravelForum\Forum;

class AdminPolicy
{
    use HandlesAuthorization;

    /**
     * Create a new policy instance.
     *
     * @return void
     */
    public function __construct()
    {
        die('123');
        //
    }

    public function create(User $user, Forum $forum)
    {
    }

    public function admin()
    {
        die('324');
    }


    public function before()
    {
        die('123');
        return true;
    }

    public function administrate()
    {
        return true;
        die('234');
    }
}
