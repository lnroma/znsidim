<?php

namespace App\Http\Controllers\Blogs;

use App\Http\Controllers\Controller;
use App\Models\Blogs;
use App\Models\Blogs\Comment;
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

    public function index()
    {
        if (Auth::guest()) {
            head('Location:/');
        }
        /** @var \Illuminate\Database\Query\Builder $blogs */
        $blogs = Blogs::orderBy('id', 'desc')->where('user_id', '=', Auth::user()->id)->paginate(5);
        return view('blogs/myblogs')->with('blogs', $blogs);
    }

    public function post(Request $request)
    {
        try {
            $blogs = new Blogs();
            $blogs->name = $request->get('name');
            $blogs->content = $request->get('comment');
            $blogs->is_enable = true;
            $blogs->user_id = Auth::user()->id;

            // upload main image
            if (Input::file('main_image') && Input::file('main_image')->isValid()) {
                $destinationPath = 'uploads';
                $extensions = Input::file('main_image')->getClientOriginalExtension();
                $fileName = rand(1000, 10000) . '.' . $extensions;
                Input::file('main_image')->move($destinationPath, $fileName);
                $blogs->main_image = '/' . $destinationPath . '/' . $fileName;
            }

            $blogs->save();
        } catch (Exception $exception) {
            var_dump($exception);die;
        }
        return redirect('/myblogs');
    }


    public function read($idBlog)
    {
        $blog = Blogs::find($idBlog);
        $blog->viewed++;
        $blog->save();
        if ($blog === null) {
            throw new NotFoundHttpException('Такой записи нет');
        }
        return view('blogs/show')->with('blog', $blog);
    }

    public function comment(Request $request)
    {
        $blogsComment = new Comment();

        if (Auth::guest()) {
            $blogsComment->user_id = -1;
        } else {
            $blogsComment->user_id = Auth::user()->id;
        }

        $comment = str_replace('script', 'hui', $request->get('comment'));
        $blogsComment->name = $request->get('name', 'Аноним');
        $blogsComment->comment = $comment;
        $blogsComment->user_blogs_id = $request->get('blog_id');
        $blogsComment->is_enabled = true;
        $blogsComment->is_delete = false;
        $blogsComment->save();

        $user = Auth::user();
        // load block and notification users
        $blog = Blogs::find($request->get('blog_id'));

        if (Auth::guest() || $blog->user_id !== $user->id) {
            $userNotifi = User::find($blog->user_id);
            $userNotifi->notify(
                new UserEvents(
                    array(
                        'message' => 'В вашем блоге: "' . $blog->name . '" есть новое сообщение: ' . $comment,
                        'title' => 'Новое сообщение в блоге',
                        'link' => '/blogs/read/' . $blog->id,
                    )
                )
            );
        }

        return redirect('blogs/read/' . $request->get('blog_id'));
    }

    public function listBlogs()
    {
        $blogs = Blogs::orderBy('id', 'desc')->paginate(5);
        return view('blogs/blogs')->with('blogs', $blogs);
    }

    public function like($idBlog, $csrf, Request $request)
    {
        $token = $request->session()->getToken();

        if($token != $csrf) {
            return redirect(url()->previous())->with('errors', 'Защита от ботов!');
        }

        $this->saveLikeDislike($idBlog, 'like');
        return redirect(url()->previous() . '#blog_' . $idBlog)->with('message', 'Лайк добавлен');
    }

    public function dislike($idBlog, $csrf, Request $request)
    {
        $token = $request->session()->getToken();

        if($token != $csrf) {
            return redirect(url()->previous())->with('errors', 'Защита от ботов!');
        }

        $this->saveLikeDislike($idBlog, 'dislike');
        return redirect(url()->previous() . '#blog_' . $idBlog)->with('message', 'Лайк добавлен');
    }

    /**
     * save like or dislike state
     * @param $id
     * @param $likeOrDislike string 'like' or 'dislike'
     */
    protected function saveLikeDislike($id, $likeOrDislike)
    {
        $blogs = Blogs::find($id);
        $blogs->{$likeOrDislike}++;
        $blogs->save();
        return true;
    }
}
