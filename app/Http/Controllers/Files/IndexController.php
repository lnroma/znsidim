<?php

namespace App\Http\Controllers\Files;

use App\Helpers\Messages;
use App\Http\Controllers\Controller;
use App\Models\Blogs;
use App\Models\Blogs\Comment;
use App\Models\Blogs\Tags;
use App\Models\Tags2Blogs;
use App\Notifications\UserEvents;
use App\User;
use DaveJamesMiller\Breadcrumbs\Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Input;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;

class IndexController extends Controller
{
    /**
     * show blogs
     * @return $this
     */
    public function upload(Request $request)
    {
        $this->validate($request, [
            'file' => 'required|image'
        ], [
            'file' => 'Разрешенно загружать только картинки!'
        ]);
        // upload main image
        try {
            if (Input::file('file') && Input::file('file')->isValid()) {
                $destinationPath = 'uploads';
                $extensions = Input::file('file')->getClientOriginalExtension();
                $user = Auth::user();
                $destinationPath = public_path($destinationPath . DIRECTORY_SEPARATOR . $user->id);
                if (!file_exists($destinationPath)) {
                    var_dump($destinationPath);
                    if (
                    !@mkdir($destinationPath)
                    ) {
                        throw new Exception('Ошибка создания директории');
                    }
                }

                $fileName = rand(1000, 10000) . '.' . $extensions;
                Input::file('file')->move($destinationPath, $fileName);
                $fileUrl = DIRECTORY_SEPARATOR . 'uploads' . DIRECTORY_SEPARATOR . $user->id . DIRECTORY_SEPARATOR . $fileName;
            }
        } catch (Exception $err) {
            var_dump($err->getMessage());
            die;
        }

        return [
            'result' => true,
            'url' => $fileUrl
        ];
    }
}
