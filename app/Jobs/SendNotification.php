<?php

namespace App\Jobs;

use App\Notifications\UserEvents;
use App\User;
use Illuminate\Queue\SerializesModels;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Support\Facades\Mail;

class SendNotification extends Job implements ShouldQueue
{
    use InteractsWithQueue, SerializesModels;

    protected $message = null;
    protected $link = null;
    protected $title = null;
    protected $sendemail = null;
    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct($message, $link, $title, $senEmail = true)
    {
        $this->message = $message;
        $this->link = $link;
        $this->title = $title;
        $this->sendemail = $senEmail;
    }

    /**
     * Execute the console command.
     *
     * @return mixed
     */
    public function handle()
    {
        $users = User::all();
        foreach ($users as $_user) {
            $_user->notify(
                new UserEvents(
                    array(
                        'message' => $this->message,
                        'title' => $this->title,
                        'link' => $this->link,
                    )
                )
            );
            if($this->sendemail) {
                Mail::send('emails.forum.notification',
                    [
                        'message_text' => $this->message,
                        'link' => $this->link
                    ], function ($m) use ($_user) {
                        $m->from('noreply@sidimvprobke.com', 'Пробки об айти');
                        $m->to($_user->email, $_user->name)->subject('Новое сообщение в форуме пробкиобайти');
                    });
            }
        }
        $this->message = null;
        $this->title = null;
        $this->link = null;
        $this->delete();
        $this->job->delete();
    }
}
