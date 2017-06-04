<?php

namespace App\Policies;

use App\Models\Blogs\Tags;
use App\User;

class TagsPolicy
{
    /**
     * Permission: Create threads in category.
     *
     * @param  object  $user
     * @param Tags $tags
     * @return bool
     */
    public function createTags(User $user)
    {
        if($user->role == 'superadmin') {
            return true;
        } else {
            return false;
        }
    }
}