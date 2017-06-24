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
use App\Models\Photos\Directory;
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

}