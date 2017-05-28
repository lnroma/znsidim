<?php
namespace App\Policies;
use Riari\Forum\Policies;

class ForumPolicy extends Policies\ForumPolicy
{
    /**
     * Permission: Create categories.
     *
     * @param  object  $user
     * @return bool
     */
    public function createCategories($user)
    {
        if($user->role == 'superadmin') {
            return true;
        } else {
            return false;
        }
    }

    /**
     * Permission: Manage category.
     *
     * @param  object  $user
     * @return bool
     */
    public function manageCategories($user)
    {
        return $this->moveCategories($user) ||
               $this->renameCategories($user);
    }

    /**
     * Permission: Move categories.
     *
     * @param  object  $user
     * @return bool
     */
    public function moveCategories($user)
    {
        if($user->role == 'superadmin') {
            return true;
        } else {
            return false;
        }        
    }

    /**
     * Permission: Rename categories.
     *
     * @param  object  $user
     * @return bool
     */
    public function renameCategories($user)
    {
        if($user->role == 'superadmin') {
            return true;
        } else {
            return false;
        }
    }

    /**
     * Permission: Mark new/updated threads as read.
     *
     * @param  object  $user
     * @return bool
     */
    public function markNewThreadsAsRead($user)
    {
        if($user->role == 'superadmin') {
            return true;
        } else {
            return false;
        }
    }

    /**
     * Permission: View trashed threads.
     *
     * @param  object  $user
     * @return bool
     */
    public function viewTrashedThreads($user)
    {
        if($user->role == 'superadmin') {
            return true;
        } else {
            return false;
        }
    }

    /**
     * Permission: View trashed posts.
     *
     * @param  object  $user
     * @return bool
     */
    public function viewTrashedPosts($user)
    {
        if($user->role == 'superadmin') {
            return true;
        } else {
            return false;
        }
    }
}
