<?php

namespace App\Widgets;

use App\Models\Blogs;
use Arrilot\Widgets\AbstractWidget;
use Illuminate\Support\Facades\DB;

class RecentBlogs extends AbstractWidget
{
    /**
     * The configuration array.
     *
     * @var array
     */
    protected $config = [];

    /**
     * Treat this method as a controller action.
     * Return view() or other content to display.
     */
    public function run()
    {
        //
        $blogs = Blogs::all()->sortByDesc('id')->take(5);
        return view("widgets.recent_blogs", [
            'blogs' => $blogs,
            'config' => $this->config,
        ]);
    }
}
