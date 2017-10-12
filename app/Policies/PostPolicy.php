<?php

namespace App\Policies;

use Illuminate\Support\Facades\Gate;
use Riari\Forum\Models\Post;
use Riari\Forum\Policies;

class PostPolicy extends Policies\PostPolicy
{
    /**
     * Permission: Edit post.
     *
     * @param  object  $user
     * @param  Post  $post
     * @return bool
     */
    public function edit($user, Post $post)
    {
        if($user->role == 'superadmin' || $user->getKey() === $post->author_id) {
            return true;
        } else {
            return false;
        }
    }

    /**
     * Permission: Delete post.
     *
     * @param  object  $user
     * @param  Post  $post
     * @return bool
     */
    public function delete($user, Post $post)
    {
        return Gate::forUser($user)->allows('deletePosts', $post->thread) || $user->getKey() === $post->user_id;
    }
}
