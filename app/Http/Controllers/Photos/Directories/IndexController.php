<?php
/**
 * Created by PhpStorm.
 * User: roman
 * Date: 24.06.17
 * Time: 12:37
 */

namespace App\Http\Controllers\Photos\Directories;

use App\Helpers\Messages;
use App\Helpers\User as UserHelper;
use App\Http\Controllers\Controller;
use App\Models\Photos\Directory;
use App\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;

class IndexController extends Controller
{

    /**
     * index router
     * @param string $userName name photo owner user
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function index($userName)
    {
        $user = UserHelper::getUserByName($userName);

        if($user->directories->count() == 0) {
            $directory = new Directory();
            $directory->title = 'Картинки';
            $directory->description = 'Директория была созданна автоматически';
            $directory->user_id = $user->id;
            $directory->password = null;
            $directory->storage_path = $this->_existAndCreate($user);
            $directory->save();
        }

        return view('photos.directories.index')
            ->with('user', $user);
    }

    /**
     * check exist directory and create
     * @param User $user
     * @return string
     */
    protected function _existAndCreate(User $user, $folderName = 'default')
    {
        // puth to storage
        $publicPath = public_path('storage/');
        if(!file_exists($publicPath)) {
            mkdir($publicPath);
        }

        // puth to user root directory
        $publicPath .= $user->id . '/';
        if(!file_exists($publicPath)) {
            mkdir($publicPath);
        }

        // puth to default directory
        $publicPath .= $folderName . '/';
        if(!file_exists($publicPath)) {
            mkdir($publicPath);
        }

        return $publicPath;
    }

    /**
     * create directory route
     *
     * @param $userName
     *
     * @return $this|\Illuminate\Http\RedirectResponse|\Illuminate\Routing\Redirector
     */
    public function createDirectory($userName)
    {
        $user = UserHelper::getUserByName($userName);
        // check permision
        if(Auth::user()->cannot('photo_edit', [$user])) {
            Messages::addError('Вы не имеете прав на доступ');
            return redirect(url()->previous());
        }

        return view('photos.directories.create')
            ->with('user', $user);
    }

    /**
     * create directory
     * @param $userName
     * @param Request $request
     * @return \Illuminate\Http\RedirectResponse|\Illuminate\Routing\Redirector
     */
    public function postCreateDirectory($userName, Request $request)
    {
        $user = UserHelper::getUserByName($userName);
        // check permision
        if(Auth::user()->cannot('photo_edit', [$user])) {
            Messages::addError('Вы не имеете прав на доступ');
            return redirect(url()->previous());
        }

        $directory = new Directory();

        $directory->title = $request->get('title');
        $directory->description = $request->get('description');
        $directory->user_id = Auth::user()->id;
        $directory->alias = md5($request->get('title'));
        $directory->password = $request->get('password', null);
        $directory->storage_path = $this->_existAndCreate($user, md5($request->get('title')));
        $directory->save();

        Messages::addSuccess('Директория создана!');
        return redirect('/photos/' . $user->name . '/directory/' . $directory->id);
    }

    /**
     * show directory
     *
     * @param $userName
     * @param $directoryId
     * @return $this
     */
    public function showDirectory($userName, $directoryId)
    {
        $user = UserHelper::getUserByName($userName);
        $directory = Directory::find($directoryId);

        return view('photos.directories.show')
            ->with('user', $user)
            ->with('directory', $directory);
    }

    public function check($idDirectory, Request $request)
    {
        $directory = Directory::find($idDirectory);

        if($directory->password == $request->get('pass')) {
            Messages::addSuccess('Пароль верен');
            session(['pass_check_' . $idDirectory => true]);
        } else {
            Messages::addError('Пароль неверен');
        }

        return redirect(url()->previous());
    }
}