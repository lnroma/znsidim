<?php

namespace App\Http\Controllers\Blogs;

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

    public function index()
    {
        if (Auth::guest()) {
            head('Location:/');
        }
        $tags = Tags::all();
        /** @var \Illuminate\Database\Query\Builder $blogs */
        $blogs = Blogs::orderBy('id', 'desc')->where('user_id', '=', Auth::user()->id)->paginate(5);
        return view('blogs/myblogs')
            ->with('blogs', $blogs)
            ->with('tags', $tags);
    }

    public function post(Request $request)
    {
        try {

            if($request->get('blog_id')) {
                $blogs = Blogs::find($request->get('blog_id'));
                if(!$this->_checkPermisionEdit($blogs)) {
                    Messages::addError('Не хватает прав!');
                    return redirect(url()->previous());
                }
            } else {
                $blogs = new Blogs();
            }

            $blogs->name = $request->get('name');
            $blogs->content = $request->get('comment');
            $blogs->is_enable = true;

            // если есть уже id автора не перезаписываем
            if(!$blogs->user_id) {
                $blogs->user_id = Auth::user()->id;
            }

            // upload main image
            if (Input::file('main_image') && Input::file('main_image')->isValid()) {
                $destinationPath = 'uploads';
                $extensions = Input::file('main_image')->getClientOriginalExtension();
                $fileName = rand(1000, 10000) . '.' . $extensions;
                Input::file('main_image')->move($destinationPath, $fileName);
                $blogs->main_image = '/' . $destinationPath . '/' . $fileName;
            }

            $blogs->save();

            $tags2blogs = new Tags2Blogs();
            // clear all tags and adding new
            $tags2blogs->clearAll($blogs->id);

            if($request->get('tags')) {
                foreach ($request->get('tags') as $_tag) {
                    $tags2blogs = new Tags2Blogs();
                    $tags2blogs->addFollow($blogs->id, $_tag);
                }
            }

        } catch (Exception $exception) {
            Messages::addError('Произошла ошибка');
            return redirect(url()->previous());
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

    /**
     * edit action
     * @param $idBlog
     * @return $this
     */
    public function edit($idBlog)
    {
        $blog = Blogs::find($idBlog);
        $tags = Tags::all();

        if($blog === null) {
            redirect('/');
        }

        if (!$this->_checkPermisionEdit($blog)) {
            Messages::addError('Не хватает прав!');
            return redirect(url()->previous());
        }

        return view('blogs/editblog')
            ->with('blog', $blog)
            ->with('tags', $tags);
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
	    Messages::addError('Защита от батов!');
            return redirect(url()->previous()); 
       }

        $this->saveLikeDislike($idBlog, 'like');
	Messages::addSuccess('Лайк поставлен!');
        return redirect(url()->previous() . '#blog_' . $idBlog);
    }

    public function dislike($idBlog, $csrf, Request $request)
    {
        $token = $request->session()->getToken();

        if($token != $csrf) {
            Messages::addError('Защита от ботов!');
            return redirect(url()->previous());
        }

	Messages::addSuccess('Дизлайк поставлен!');
        $this->saveLikeDislike($idBlog, 'dislike');
        return redirect(url()->previous() . '#blog_' . $idBlog);
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

    /**
     * check permision edit
     * @param $blog
     * @return bool
     */
    protected function _checkPermisionEdit(Blogs $blog)
    {
        if(
            (!Auth::guest() && $blog->user_id == Auth::user()->id)
            || (!Auth::guest() && Auth::user()->role == 'superadmin')
        ) {
            return true;
        } else {
            return false;
        }
    }

}
