<?php

namespace App\Models\Blogs;

use App\Models\Blogs;
use Illuminate\Database\Eloquent\Model;

class Comment extends Model
{
    public $table = 'blog_comments';
    //
    public function blog()
    {
        return $this->belongsTo(Blogs::class, 'user_blogs_id', 'id');
    }
}
