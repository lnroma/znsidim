<?php
/**
 * Created by PhpStorm.
 * User: roman
 * Date: 07.05.17
 * Time: 12:07
 */
namespace App\Http\Controllers\Search;

use App\Http\Controllers\Controller;
use App\Models\Blogs;
use App\Models\Sphinx;
use App\User;
use Riari\Forum\Models\Post;
use Riari\Forum\Models\Thread;
use sngrl\SphinxSearch\SphinxSearch;

class IndexController extends Controller
{

    /**
     * index action
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function index()
    {
        return view('search.index');
    }

    /**
     * search result action
     * @param $query
     * @return $this
     */
    public function result()
    {
        $query = $_GET['q'];
        $search = new SphinxSearch();
        // common count result
        $result = $search->search($query, 'common')->query();
        $commonResult = $result['total'];
        // forum search result
        $result = $search->search($query, 'forum')->query();
        $forum = $result['total'];
        // blog search result
        $result = $search->search($query, 'blogs')->query();
        $blog = $result['total'];
        // user search result
        $result = $search->search($query, 'users')->query();
        $user = $result['total'];

        return view('search.result')
            ->with('common', $commonResult)
            ->with('forum', $forum)
            ->with('blog', $blog)
            ->with('user', $user)
            ->with('query', $query)
            ;
    }

    public function resultType($type, $query)
    {
        $search = new SphinxSearch();
        if($type == 'blog') {
            $result = $search->search($query, 'blogs')->query();

            if($result['total'] > 0) {
                $keys = array_keys($result['matches']);
                $blogIds = $this->_getOriginId($keys);
                $blogs = Blogs::whereIn('id', $blogIds)->paginate(5);
            } else {
                $blogs = array();
            }

            return view('search.result.blogs')
                ->with('total', $result['total'])
                ->with('blogs', $blogs);
        } elseif($type=='user') {
            $result = $search->search($query, 'users')->query();

            if($result['total'] > 0) {
                $keys = array_keys($result['matches']);
                $userIds = $this->_getOriginId($keys);
                $users = User::whereIn('id', $userIds)->paginate(5);
            } else {
                $users = array();
            }

            return view('search.result.users')
                ->with('total', $result['total'])
                ->with('users', $users);
        } elseif($type == 'forum') {
            $result = $search->search($query, 'forum')->query();

            if($result['total'] > 0) {
                $keys = array_keys($result['matches']);
                $threadIds = $this->_getOriginId($keys);
                $threadIds = array_unique($threadIds);
                $threads = Thread::whereIn('id', $threadIds)->paginate(5);
            } else {
                $threads = array();
            }

            return view('search.result.posts')
                ->with('total', $result['total'])
                ->with('threads', $threads);
        }
    }

    /**
     * get original id of find item
     * @param $ids
     * @return array
     */
    protected function _getOriginId($ids)
    {
        $searchRes = Sphinx::whereIn('id', $ids)->get();
        $result = array();
        foreach($searchRes as $_searchRes) {
            $result[] = $_searchRes->sources_id;
        }
        return $result;
    }

}