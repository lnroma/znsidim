<?php
/**
 * Created by PhpStorm.
 * User: roman
 * Date: 07.05.17
 * Time: 12:07
 */
namespace App\Http\Controllers\Notification;

use App\Http\Controllers\Controller;
use App\Notifications\UserEvents;
use Illuminate\Notifications\DatabaseNotification;
use Illuminate\Notifications\DatabaseNotificationCollection;
use Illuminate\Support\Facades\Auth;

class IndexController extends Controller
{

    /**
     * index action
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function index()
    {
        $user = Auth::user();
        /** @var DatabaseNotificationCollection $notifications */
        $notifications = $user->unreadNotifications;
        $allNotifications = $user->notifications();

        return view('notification.index')
            ->with('notifications', $notifications)
            ->with('all', $allNotifications);
    }

    public function read($idNotifi)
    {
        $notifi = DatabaseNotification::find($idNotifi);
        $notifi->markAsRead();
        return redirect($notifi->data['link']);
    }

}