<?php
/**
 * Created by PhpStorm.
 * User: roman
 * Date: 08.05.17
 * Time: 21:26
 */
Breadcrumbs::register('home', function ($breadcrumbs) {
    $breadcrumbs->push('Домой', '/');
});

Breadcrumbs::register('blogs', function ($breadcrumbs) {
    $breadcrumbs->parent('home');
    $breadcrumbs->push('Блоги', route('blogs'));
});

Breadcrumbs::register('mypage', function ($breadcrumbs) {
    $breadcrumbs->parent('home');
    $breadcrumbs->push('Анкета', route('home'));
});

Breadcrumbs::register('users', function ($breadcrumbs) {
    $breadcrumbs->parent('home');
    $breadcrumbs->push('Пользователи', '/users');
});

Breadcrumbs::register('users_show', function ($breadcrumbs, $userId, $name) {
    $breadcrumbs->parent('users');
    $breadcrumbs->push($name, '/user/show/' . $userId);
});

Breadcrumbs::register('events', function ($breadcrumbs) {
    $breadcrumbs->parent('home');
    $breadcrumbs->push('Журнал', 'events');
});

Breadcrumbs::register('messages', function ($breadcrumbs) {
    $breadcrumbs->parent('home');
    $breadcrumbs->push('Сообщения', '/message');
});

Breadcrumbs::register('messages_show', function ($breadcrumbs, $user) {
    $breadcrumbs->parent('messages');
    $breadcrumbs->push($user->name, '/message/chat/' . $user->name);
});


Breadcrumbs::register('myblogs', function ($breadcrumbs) {
    $breadcrumbs->parent('home');
    $breadcrumbs->push('Мой блог', route('blogs'));
});

Breadcrumbs::register('readblog', function ($breadcrumbs, $blog) {
    $breadcrumbs->parent('blogs');
    $breadcrumbs->push($blog->name, 'blog/show/' . $blog->id);
});

Breadcrumbs::register('forum', function ($breadcrumbs) {
    $breadcrumbs->parent('home');
    $breadcrumbs->push('Форум', '/forum');
});

Breadcrumbs::register('forum_category', function ($breadcrumbs, \Riari\Forum\Models\Category $category) {
    $breadcrumbs->parent('forum');
    $breadcrumbs->push($category->title, \Riari\Forum\Frontend\Support\Forum::route('category.show', $category));
});

Breadcrumbs::register('forum_thread', function ($breadcrumbs, \Riari\Forum\Models\Thread $thread){
    $breadcrumbs->parent('forum_category', $thread->category);
    $breadcrumbs->push($thread->title, \Riari\Forum\Frontend\Support\Forum::route('thread.show', $thread));
});

Breadcrumbs::register('photo', function ($breadcrumbs, $userName, $userId) {
    $breadcrumbs->parent('users_show', $userId, $userName);
    $breadcrumbs->push('Фото', '/photos/' . $userName );
});

Breadcrumbs::register('photo_directory', function ($breadcrumbs, $userName, $userId, $directoryName, $directoryId) {
    $breadcrumbs->parent('photo', $userName, $userId);
    $breadcrumbs->push($directoryName, '/photos/' . $userName . '/directory/' . $directoryId );
});


Breadcrumbs::register('photo_show', function ($breadcrumbs, $userName, $userId, $directoryName, $directoryId, $photoName, $photoId) {
    $breadcrumbs->parent('photo_directory', $userName, $userId, $directoryName, $directoryId);
    $breadcrumbs->push($photoName, '/photo/show/' . $photoId );
});