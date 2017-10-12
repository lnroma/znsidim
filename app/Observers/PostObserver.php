<?php
/**
 * Created by PhpStorm.
 * User: roman
 * Date: 14.06.17
 * Time: 21:57
 */
namespace App\Observers;

use App\Jobs\SendNotification;
use App\Helpers\User as UserHelper;
use Riari\Forum\Frontend\Support\Forum;
use Riari\Forum\Models\Post;
use Illuminate\Foundation\Bus\DispatchesJobs;

class PostObserver
{
    use DispatchesJobs;

    public function created(Post $post)
    {
        $this->dispatch(
            new SendNotification(
                UserHelper::getUserById($post->author_id)->name . ' написал: ' . $post->content,
                Forum::route('thread.show', $post->thread),
                'Новое сообщение в форуме'
            )
        );
    }

}
