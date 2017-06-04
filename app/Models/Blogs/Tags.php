<?php

namespace App\Models\Blogs;

use App\Models\Blogs;
use Illuminate\Database\Eloquent\Model;

class Tags extends Model
{
    //
    public $table = 'blog_tags';

    public function blogs()
    {
        return $this->belongsToMany(Blogs::class, 'blog_tags_user_blogs', 'tag_ids', 'blog_ids');
    }
}
