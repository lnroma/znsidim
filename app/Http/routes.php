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
Route::post('/message/settings', 'MessageController@saveSettings');
Route::get('/message/settings', 'MessageController@settings');
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
Route::get('/search', 'Search\IndexController@index');
Route::get('/search/result/', 'Search\IndexController@result');
Route::get('/search/result/{type}/{query}', 'Search\IndexController@resultType');
/**
 * static page routers
 */
Route::get('/games', 'Games\IndexController@listGames');
Route::get('/games/add', 'Games\IndexController@addGames');
Route::post('/games/add', 'Games\IndexController@postAddGames');
Route::get('/games/show/{id}', 'Games\IndexController@show');
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
Route::get('comment/delete/{idComment}', 'Blogs\IndexController@commentDelete');
/**
 * events router
 */
Route::get('events', 'Notification\IndexController@index');
Route::get('events/all', 'Notification\IndexController@all');
Route::get('notifi/read/{idNotifi}', 'Notification\IndexController@read');
Route::get('notifi/asread/{idNotifi}', 'Notification\IndexController@markAsRead');
/**
 * photo routers
 */
Route::get('/photos/{userName}', 'Photos\Directories\IndexController@index');
Route::get('/photos/{userName}/createDirectory', 'Photos\Directories\IndexController@createDirectory');
Route::post('/photos/{userName}/createDirectory', 'Photos\Directories\IndexController@postCreateDirectory');
Route::get('/photos/{userName}/directory/{directoryId}', 'Photos\Directories\IndexController@showDirectory');
Route::get('/photos/{userName}/uploadForm', 'Photos\IndexController@upload');
Route::post('/photos/{userName}/uploadForm', 'Photos\IndexController@post');
Route::get('/photo/show/{idPhoto}', 'Photos\IndexController@show');
Route::post('/photo/comment/', 'Photos\IndexController@comment');
Route::post('/photos/pass/directoy/{idDirectory}', 'Photos\Directories\IndexController@check');

/**
 * users anketa
 */
Route::get('/user/anketa/{userName}', 'Anketa\IndexController@editAnketa');
Route::post('/user/anketa/{userName}', 'Anketa\IndexController@saveAnketa');
Route::post('/anketa/saveFilters', 'Anketa\IndexController@saveFilters');
Route::get('/dating', 'Anketa\IndexController@listAnketa');
Route::get('/anketa/clearFilters', 'Anketa\IndexController@clearFilters');
Route::post('/tables/saveComment', 'Users@saveTables');
/**
 * youtube video
 */
Route::get('/videos', 'Videos\IndexController@index');
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
 * file upload
 */
Route::post('/file/upload', 'Files\IndexController@upload');
Route::get('/file/get_uploaded', 'Files\IndexController@getUploaded');
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

    if (!$feed->isCached()) {
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
            $feed->add(
                strip_tags($_post->name),
                \App\Helpers\User::getUserById($_post->user_id)->name,
                url('blogs/read') . '/' . $_post->id,
                $_post->created_at,
                strip_tags($_post->content),
                strip_tags($_post->content)
            );
        }
    }
    return $feed->render('atom');
});
