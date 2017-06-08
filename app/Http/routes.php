<?php

/*
|--------------------------------------------------------------------------
| Application Routes
|--------------------------------------------------------------------------
|
| Here is where you can register all of the routes for an application.
| It's a breeze. Simply tell Laravel the URIs it should respond to
| and give it the controller to call when that URI is requested.
|
*/

Route::get('/', function () {
    return view('welcome');
});

Route::get('/map', function () {
    return view('pages.map');
});

Route::get('/about', function () {
    return view('pages.about');
});

Route::auth();
/**
 * message rout
 */
Route::get('/message', 'MessageController@index');
Route::get('/message/send/{login}', 'MessageController@send');
Route::post('/message/send', 'MessageController@postMessage');
Route::get('/messages/chat/{login}', 'MessageController@chat');
/**
 * user route
 */
Route::get('/users', 'Users@index');
Route::get('/user/show/{login}', 'Users@show');
/**
 * search route
 */
Route::get('/find', 'Search\IndexController@index');
Route::get('/find/result/{query}', 'Search\IndexController@result');
/**
 * static page routers
 */
Route::get('/chats', function () {
    return view('pages.chats');
});
/**
 * blogs router
 */
Route::get('myblogs', 'Blogs\IndexController@index');
Route::get('blogs', 'Blogs\IndexController@listBlogs')->name('blogs');
Route::get('blogs/read/{idBlog}', 'Blogs\IndexController@read')->name('blogs_read');
Route::post('myblogs', 'Blogs\IndexController@post');
Route::post('blogs/comment', 'Blogs\IndexController@comment');
Route::get('blogs/like/{idBlog}/{csrf}', 'Blogs\IndexController@like');
Route::get('blogs/dislike/{idBlog}/{csrf}', 'Blogs\IndexController@dislike');
Route::get('blogs/edit/{idBlog}', 'Blogs\IndexController@edit');
/**
 * events router
 */
Route::get('events', 'Notification\IndexController@index');
/**
 * forum routers
 */
/**
 * other route
 */
Route::get('/home', 'HomeController@index')->name('home');
Route::post('/home', 'HomeController@post');

Route::get('/googleCallbak', 'Auth\AuthController@googleCallback')->name('google');
/**
 * seo modul routers
 */
Route::post('/seo/save', 'Seo\IndexController@save');
/**
 * blogs tags
 */
Route::get('/tags', 'Blogs\Tags\IndexController@index');
Route::post('/tags', 'Blogs\Tags\IndexController@post');
Route::get('/tags/{url_key}', 'Blogs\Tags\IndexController@tags');
// generate rss feed
Route::get('feed', function () {
    /** @var Roumen\Feed\Feed $feed */
    $feed = App::make("feed");
    $feed->setCache(0, 'rss_feed');

    if(!$feed->isCached()) {
        $posts = \DB::table('user_blogs')->orderBy('created_at', 'desc')->take(20)->get();

        $feed->title = 'Пробки об айти';
        $feed->description = 'RSS фид пробки об айти';
        $feed->link = url('feed');
        $feed->setDateFormat('datetime');
        $feed->pubdate = $posts[0]->created_at;
        $feed->lang = 'ru';
        $feed->setShortening(true);
        $feed->setTextLimit(100);

        foreach ($posts as $_post) {
//            var_dump($_post);die;
            $feed->add(
                strip_tags($_post->name),
                \App\Helpers\User::getUserById($_post->user_id)->name,
                url('blogs/read') . '/' . $_post->id,
                $_post->created_at,
                strip_tags($_post->content)
                );
        }
//        var_dump($posts);die;
    }
    return $feed->render('atom');
});