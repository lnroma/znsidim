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
            return [
                'result' => false,
                'message' => 'Фаил не верного формата',
            ];
        }

        return [
            'result' => true,
            'url' => $fileUrl,
            'id_editor' => $request->get('id_editor')
        ];
    }

    public function getUploaded(Request $request)
    {
        $user = Auth::user();
        $destinationPath = 'uploads';
        $destinationPath = public_path($destinationPath . DIRECTORY_SEPARATOR . $user->id);
        $getFileUploaded = glob($destinationPath . DIRECTORY_SEPARATOR . '*');

        $getFileUploaded = array_map(function($element) use ($user, $destinationPath) {
            return [
                'url' => '/uploads/' . $user->id . str_replace($destinationPath, '', $element),
                'path' => $element
            ];
        }, $getFileUploaded);

        return [
            'html' => view('messages.chunks.user.files')
                ->with('id_editor', $request->get('id_editor'))
                ->with('files', $getFileUploaded)->render()
        ];
    }

}
