<?php
/**
 * Created by PhpStorm.
 * User: roman
 * Date: 14.06.17
 * Time: 20:53
 */
namespace App\Observers;

use App\Notifications\UserEvents;
use App\User;
use Riari\Forum\Frontend\Support\Forum;
use Riari\Forum\Models\Thread;

class ThreadObserver
{

    public function created(Thread $thread)
    {
        // ибо создаёться и сообщение
        return;
        $users = User::all();
        foreach ($users as $_user) {
            $_user->notify(
                new UserEvents(
                    array(
                        'message' => 'В форуме создана новая ветка: ' . $thread->title,
                        'title' => 'Новая ветка в форуме',
                        'link' => Forum::route('thread.show', $thread),
                    )
                )
            );
        }
    }

}