<?php

namespace App\Http\Controllers\Blogs\Tags;

use App\Helpers\Messages;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Blogs\Tags;

class IndexController extends Controller
{

    public function index()
    {
        $tags = Tags::all();
        return view('blogs/tags')->with('tags', $tags);
    }

    public function post(Request $request)
    {
        $tags = new Tags();

        try {
            $tags->url_key = $request->get('url_key');
            $tags->title = $request->get('title');
            $tags->description = $request->get('description');
            $tags->save();

            Messages::addSuccess('Тэг ' . $request->get('title') . ' сохранён!');
        } catch (\Exception $exception) {
            Messages::addError('Ошибка! тэг не сохранён.');
        }

        return redirect('/tags');
    }

    public function tags($url_key)
    {
        $tag = Tags::where('url_key', '=', $url_key)->firstOrFail();
        /** @var \Illuminate\Database\Eloquent\Relations\BelongsToMany $blogs */
        $blogs = $tag->blogs()->paginate(5);
        return view('blogs/tags/view')
            ->with('blogs', $blogs)
            ->with('tag', $tag);
    }

}
