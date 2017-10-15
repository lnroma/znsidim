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

    /**
     * show blogs
     * @return $this
     */
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

    /**
     * create post
     *
     * @param Request $request
     * @return \Illuminate\Http\RedirectResponse|\Illuminate\Routing\Redirector
     */
    public function post(Request $request)
    {
        try {

            if ($request->get('blog_id')) {
                $blogs = Blogs::find($request->get('blog_id'));
                if (!$this->_checkPermisionEdit($blogs)) {
                    Messages::addError('Не хватает прав!');
                    return redirect(url()->previous());
                }
            } else {
                $blogs = new Blogs();
            }

            $blogs->name = $request->get('name');
            $blogs->content = $request->get('comment');
            $blogs->short_description = $request->get('short_description');
            $blogs->is_enable = true;

            // если есть уже id автора не перезаписываем
            if (!$blogs->user_id) {
                $blogs->user_id = Auth::user()->id;
            }

            $blogs->save();

            $tags2blogs = new Tags2Blogs();
            // clear all tags and adding new
            $tags2blogs->clearAll($blogs->id);

            if ($request->get('tags')) {
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

    /**
     * read blog
     * @param $idBlog
     * @return $this
     */
    public function read($idBlog)
    {
        $blog = Blogs::find($idBlog);
        if ($blog === null) {
            throw new NotFoundHttpException('Такой записи нет');
        }
        $blog->viewed++;
        $blog->save();

        $smiles = glob(base_path('public/smiles/smiles/*.gif'));
        $smiles = array_map(function($element){
            $element = explode('/', $element);
            $element = end($element);
            return $element;
        }, $smiles);

        return view('blogs/show')
            ->with('blog', $blog)
            ->with('smiles', $smiles)
            ;
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

        if ($blog === null) {
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
            $blogsComment->user_blogs_id = $request->get('blog_id');
            $blogsComment->is_enabled = true;
            $blogsComment->is_delete = false;
            $blogsComment->save();

            // load block and notification users
            $blog = Blogs::find($request->get('blog_id'));

            $this->_sendNotifi($blog, $comment);
        }
        return redirect('blogs/read/' . $request->get('blog_id'));
    }

    /**
     * send notification to users on blog activity
     * @param Blogs $blog
     * @param $comment
     */
    protected function _sendNotifi(Blogs $blog, $comment)
    {
        // скомпилируем тем кому надо отправить нотификацию
        $comments = $blog->comments;
        $userIds = array();

        foreach ($comments as $_comments) {
            $userIds[] = $_comments->user_id;
        }

        $userIds[] = $blog->user_id;
        $userIds = array_unique($userIds);

        // разослать всем нотификации
        foreach ($userIds as $_userId) {
            // быдлокод не большой
            $userNotifi = User::find($_userId);

            // исключаем самого себяиз нотификации
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
                        'message' => 'В вашем блоге: "' . $blog->name . '" есть новое сообщение: ' . $comment,
                        'title' => 'Новое сообщение в блоге',
                        'link' => '/blogs/read/' . $blog->id,
                    )
                )
            );
        }
    }

    /**
     * delete comment from post
     * @param $idComment
     * @param User $user
     * @return \Illuminate\Http\RedirectResponse|\Illuminate\Routing\Redirector
     */
    public function commentDelete($idComment)
    {
        if (Auth::guest()) {
            Messages::addError('Недостаточно прав!');
            return redirect(url()->previous());
        }

        $role = Auth::user()->can('superadmin');

        if (!$role) {
            Messages::addError('Недостаточно прав!');
            return redirect(url()->previous());
        }

        $comment = Comment::find($idComment);
        $comment->delete();

        Messages::addSuccess('Комментарий удалён');
        return redirect(url()->previous());
    }

    /**
     * list blogs
     * @return $this
     */
    public function listBlogs()
    {
        $blogs = Blogs::orderBy('id', 'desc')->paginate(5);
        return view('blogs/blogs')->with('blogs', $blogs);
    }

    /**
     * set like to blog post
     * @param $idBlog
     * @param $csrf
     * @param Request $request
     * @return \Illuminate\Http\RedirectResponse|\Illuminate\Routing\Redirector
     */
    public function like($idBlog, $csrf, Request $request)
    {
        $token = $request->session()->getToken();

        if ($token != $csrf) {
            Messages::addError('Защита от батов!');
            return redirect(url()->previous());
        }

        return $this->saveLikeDislike($idBlog, 'like', $request);
    }


    public function dislike($idBlog, $csrf, Request $request)
    {
        $token = $request->session()->getToken();

        if ($token != $csrf) {
            Messages::addError('Защита от ботов!');
            return redirect(url()->previous());
        }

        return $this->saveLikeDislike($idBlog, 'dislike', $request);
    }

    /**
     * save like or dislike state
     * @param $id
     * @param $likeOrDislike string 'like' or 'dislike'
     */
    protected function saveLikeDislike($id, $likeOrDislike, Request $request)
    {

        if ($request->session()->get('blog_like_' . $likeOrDislike . $id) == true) {
            Messages::addError('Вы уже поставили ' . $likeOrDislike . ' к этому посту');
            return redirect(url()->previous() . '#blog_' . $id);
        }

        $blogs = Blogs::find($id);
        $blogs->{$likeOrDislike}++;
        $blogs->save();
        $request->session()->set('blog_like_' . $likeOrDislike . $id, true);
        Messages::addSuccess($likeOrDislike . ' поставлен!');
        return redirect(url()->previous() . '#blog_' . $id);
    }

    /**
     * check permision edit
     * @param $blog
     * @return bool
     */
    protected function _checkPermisionEdit(Blogs $blog)
    {
        if (
            (!Auth::guest() && $blog->user_id == Auth::user()->id)
            || (!Auth::guest() && Auth::user()->role == 'superadmin')
        ) {
            return true;
        } else {
            return false;
        }
    }

}
