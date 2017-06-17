<?php
/**
 * Created by PhpStorm.
 * User: roman
 * Date: 07.05.17
 * Time: 16:14
 */
namespace App\Http\Composers;
use App\Http\Requests\Request;
use App\Models\Blogs;
use App\Notifications\Post;
use App\Notifications\UserEvents;
use App\Seo\Seo;
use App\User;
use Illuminate\Notifications\DatabaseNotificationCollection;
use Illuminate\Support\Facades\Auth;
use Illuminate\Contracts\View\View;
use Riari\Forum\Frontend\Support\Forum;
use Riari\Forum\Models\Category;
use Riari\Forum\Models\Thread;
use Symfony\Component\HttpFoundation\RequestMatcher;

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
            if($seo = $this->_seoForum()) {
                return $seo;
            } else {
                return array(
                    'title' => 'Знакомства, блоги, хайп и айти всё это - официальный сайт пробки об айти sidimvprobke.com',
                    'description' => 'Вы хотите войти в айти, научиться кодить или программировать, тогда этот сайт для вас, изучи обстановку и смотри что будет',
                    'keywords' => 'it, php, python, ssl, certificate, философия, пробки об айти'
                );
            }
        }
    }

    /**
     * компиляция сео для форума
     * @return array|bool
     */
    protected function _seoForum()
    {
        $ids = explode('/', $_SERVER['REQUEST_URI']);

        if(!isset($ids[2])) {
            return false;
        }

        $idCategory = $ids[2];
        $title = 'Форум пробки об айти!';
        // выбираем категорию
        $category = Category::find($idCategory);

        $seo = null;
        if(!is_null($category) && $category->title) {
            $title = $category->title;
            $seo = $category;
        }

        // если есть поток то идём в поток
        if(isset($ids[3])) {
            $thread = Thread::find($ids[3]);
            if(!is_null($thread) && $thread->title) {
                $title .= ' ' . $thread->title;
                $seo = $thread;
            }
        }
        // если нет и потока возвращаем фалс
        if(!$seo) {
            return false;
        }

        // всё заебись вернём title и description
        return array(
            'title' => $title,
            'description' => $seo->description,
            'keywords' => 'PHP, программирование, python, форум программистов',
        );
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
