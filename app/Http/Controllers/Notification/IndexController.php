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
     * index action not read notification
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function index()
    {
        $user = Auth::user();
        /** @var DatabaseNotificationCollection $notifications */
        $notifications = $user->unreadNotifications;

        return view('notification.index')
            ->with('notifications', $notifications);
    }

    /**
     * all notification
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function all()
    {
        $user = Auth::user();
        /** @var DatabaseNotificationCollection $notifications */
        $allNotifications = $user->notifications();

        return view('notification.all')
            ->with('all', $allNotifications);
    }

    public function read($idNotifi)
    {
        $notifi = DatabaseNotification::find($idNotifi);
        $notifi->markAsRead();
        return redirect($notifi->data['link']);
    }

    /**
     * mark as read
     * @param $idNotifi
     * @return \Illuminate\Http\RedirectResponse|\Illuminate\Routing\Redirector
     */
    public function markAsRead($idNotifi)
    {
        $notifi = DatabaseNotification::find($idNotifi);
        $notifi->markAsRead();
        return $this->_prevoice();
    }

}