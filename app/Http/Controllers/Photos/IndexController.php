<?php
/**
 * Created by PhpStorm.
 * User: roman
 * Date: 24.06.17
 * Time: 12:37
 */

namespace App\Http\Controllers\Photos;

use App\Helpers\Messages;
use App\Helpers\User as UserHelper;
use App\Http\Controllers\Controller;
use App\Models\Photos;
use App\Models\Photos\Comment;
use App\Models\Photos\Directory;
use App\Notifications\UserEvents;
use App\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Input;

class IndexController extends Controller
{

    public function upload($userName)
    {
        $user = UserHelper::getUserByName($userName);
        // check permision
        if (Auth::user()->cannot('photo_edit', [$user])) {
            Messages::addError('Вы не имеете прав на доступ');
            return redirect(url()->previous());
        }

        return view('photos.upload')->with('user', $user);
    }

    public function post($userName, Request $request)
    {
        $user = UserHelper::getUserByName($userName);
        // check permision
        if (Auth::user()->cannot('photo_edit', [$user])) {
            Messages::addError('Вы не имеете прав на доступ');
            return redirect(url()->previous());
        }

        $directory = Directory::find($request->get('directory'));
        if (Input::file('file') && Input::file('file')->isValid()) {
            $destinationPath = $directory->storage_path;
            $fileName = Input::file('file')->getClientOriginalName();
            Input::file('file')->move($destinationPath, $fileName);

            $photo = new Photos();
            $photo->directory_id = $directory->id;
            $photo->description = $request->get('description');
            $photo->user_id = $user->id;
            $photo->url = $this->_generateUrl($destinationPath, $fileName);
            $photo->file_name = $fileName;
            $photo->save();
        }

        return redirect('/photos/' . $userName . '/directory/' . $directory->id);
    }

    protected function _generateUrl($destination, $fileName)
    {
        $pathToFile = $destination . $fileName;
        $url = str_replace(public_path(), '', $pathToFile);
        return $url;
    }

    public function show($idPhoto)
    {
        $photo = Photos::find($idPhoto);
        return view('photos.show')->with('photo', $photo);
    }

    /**
     * add comment to blog
     * @param Request $request
     * @return \Illuminate\Http\RedirectResponse|\Illuminate\Routing\Redirector
     */
    public function comment(Request $request)
    {
        // значение с input'а, который создается при открытии страницы браузером
        $antispam = $request->get('antispam');
        if ($antispam) {
            $blogsComment = new Comment();

            if (Auth::guest()) {
                $blogsComment->user_id = -1;
            } else {
                $blogsComment->user_id = Auth::user()->id;
            }

            $comment = str_replace('script', 'hui', $request->get('comment'));
            $blogsComment->name = $request->get('name', 'Аноним');
            $blogsComment->comment = $comment;
            $blogsComment->user_photo_id = $request->get('photo_id');
            $blogsComment->is_enabled = true;
            $blogsComment->is_delete = false;
            $blogsComment->save();

            // load block and notification users
            $photo = Photos::find($request->get('photo_id'));

            $this->_sendNotifi($photo, $comment);
        }
        return redirect('/photo/show/' . $request->get('photo_id'));
    }

    private function _sendNotifi($photo, $comment)
    {
        // скомпилируем тем кому надо отправить нотификацию
        $comments = $photo->comments;
        $userIds = array();

        foreach ($comments as $_comments) {
            $userIds[] = $_comments->user_id;
        }

        $userIds[] = $photo->user_id;
        $userIds = array_unique($userIds);

        // разослать всем нотификации
        foreach ($userIds as $_userId) {
            // быдлокод не большой
            $userNotifi = User::find($_userId);

            // исключаем самого себя из нотификации
            if(!Auth::guest() && $_userId == Auth::user()->id)
            {
                continue;
            }

            if (!$userNotifi) {
                continue;
            }

            $userNotifi->notify(
                new UserEvents(
                    array(
                        'message' => 'Коментарий к фотографии "' . $photo->name . '": ' . $comment,
                        'title' => 'Новое сообщение в фотографиях',
                        'link' => '/photo/show/' . $photo->id,
                    )
                )
            );
        }
    }
}