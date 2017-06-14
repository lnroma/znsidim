<?php
/**
 * Created by PhpStorm.
 * User: roman
 * Date: 14.06.17
 * Time: 21:57
 */
namespace App\Observers;

use App\Notifications\UserEvents;
use App\User;
use App\Helpers\User as UserHelper;
use Riari\Forum\Frontend\Support\Forum;
use Riari\Forum\Models\Post;
use Riari\Forum\Models\Thread;

class PostObserver {

    public function created(Post $post)
    {
        $thread = Thread::find($post->thread_id);
        $users = User::all();
        foreach ($users as $_user) {
            $_user->notify(
                new UserEvents(
                    array(
                        'message' => UserHelper::getUserById($post->author_id)->name . ' написал: ' . $post->content,
                        'title' => 'Новое сообщение в форуме',
                        'link' => Forum::route('thread.show', $thread),
                    )
                )
            );
        }
    }

}