<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Tags2Blogs extends Model
{
    //
    public $table = 'blog_tags_user_blogs';

    public function clearAll($idBlog)
    {
        $clear = self::where('blog_ids', '=', $idBlog)->get();
        foreach ($clear as $_cl)
        {
            $_cl->delete();
        }
    }

    public function addFollow($idBlog, $idTag)
    {
        $this->blog_ids = $idBlog;
        $this->tag_ids = $idTag;
        $this->save();
    }
}
