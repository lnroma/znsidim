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
    public function upload()
    {
        var_dump($_POST, $_FILES);die;
    }
}
