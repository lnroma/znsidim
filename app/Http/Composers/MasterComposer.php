<?php
/**
 * Created by PhpStorm.
 * User: roman
 * Date: 07.05.17
 * Time: 16:14
 */
namespace App\Http\Composers;
use App\Models\Blogs;
use App\Notifications\Post;
use App\Notifications\UserEvents;
use App\Seo\Seo;
use App\User;
use Illuminate\Notifications\DatabaseNotificationCollection;
use Illuminate\Support\Facades\Auth;
use Illuminate\Contracts\View\View;

class MasterComposer {

    public function compose(View $view)
    {
        $blogCount = Blogs::all()->count();
        $userCount = User::all()->count();

        $eventsCount = $this->_getEventCount();
        $mailCount = $this->_getCountMail();
        $filesCount = 0;


        $view->with('blog_count', $blogCount);
        $view->with('user_count', $userCount);
        $view->with('mail_count', $mailCount);
        $view->with('files_count', $filesCount);
        $view->with('events_count', $eventsCount);
        $view->with('common_count', $eventsCount + $mailCount);
        $view->with($this->_getSeoHuinju());
    }

    /**
     * get seo modul
     * @return array
     */
    protected function _getSeoHuinju()
    {
        $seo = Seo::where('url', $_SERVER['REQUEST_URI'])->first();
        if($seo) {
            return array(
                'title' => $seo->title,
                'description' => $seo->description,
                'keywords' => $seo->keywords,
            );
        } else {
            return array(
                'title' => 'Знакомства, блоги, хайп и айти всё это - официальный сайт пробки об айти sidimvprobke.com',
                'description' => 'Вы хотите войти в айти, научиться кодить или программировать, тогда этот сайт для вас, изучи обстановку и смотри что будет',
                'keywords' => 'it, php, python, ssl, certificate, философия, пробки об айти'
            );
        }
    }

    /**
     * get count notifications
     * @return int
     */
    protected function _getEventCount()
    {
        if(Auth::guest()) {
            return 0;
        }

        $user = Auth::user();
        /** @var DatabaseNotificationCollection $notifications */
        $notifications = $user->unreadNotifications;
        $count = 0;
        foreach ($notifications->toArray() as $_notifi) {
            if($_notifi['type'] == UserEvents::class) {
                $count++;
            }
        }
        return $count;
    }

    /**
     * get count email
     * @return int
     */
    protected function _getCountMail()
    {
        if(Auth::guest()) {
            return 0;
        }

        $user = Auth::user();
        /** @var DatabaseNotificationCollection $notifications */
        $notifications = $user->unreadNotifications;
        $count = 0;
        foreach ($notifications->toArray() as $_notifi) {
            if($_notifi['type'] == Post::class) {
                $count++;
            }
        }
        return $count;
    }

}