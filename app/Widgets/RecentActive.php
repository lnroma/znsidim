<?php

namespace App\Widgets;

use App\Models\Blogs\Comment;
use Arrilot\Widgets\AbstractWidget;

class RecentActive extends AbstractWidget
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
        $comments = Comment::all()->sortByDesc('id')->take(5);
        return view("widgets.recent_comments", [
            'comments' => $comments,
            'config' => $this->config,
        ]);
    }
}
