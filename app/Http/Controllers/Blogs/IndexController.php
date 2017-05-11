<?php

namespace App\Http\Controllers\Blogs;

use App\Http\Controllers\Controller;
use App\Models\Blogs;
use App\Models\Blogs\Comment;
use App\Notifications\UserEvents;
use App\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;

class IndexController extends Controller
{

    public function index()
    {
        if (Auth::guest()) {
            head('Location:/');
        }
        /** @var \Illuminate\Database\Query\Builder $blogs */
        $blogs = DB::table('user_blogs');
        $blogs = $blogs->orderBy('id', 'desc')->where('user_id', '=', Auth::user()->id)->paginate(10);
        return view('blogs/myblogs')->with('blogs', $blogs);
    }

    public function post(Request $request)
    {
        $blogs = new Blogs();
        $blogs->name = $request->get('name');
        $blogs->content = $request->get('comment');
        $blogs->is_enable = true;
        $blogs->user_id = Auth::user()->id;
        $blogs->save();

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

        $blogsComment->name = $request->get('name', 'Аноним');
        $blogsComment->comment = $request->get('comment');
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
                        'message' => 'В вашем блоге: "' . $blog->name . '" есть новое сообщение.',
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
        $blogs = DB::table('user_blogs')->orderBy('id', 'desc')->paginate(10);
        return view('blogs/blogs')->with('blogs', $blogs);
    }
}
