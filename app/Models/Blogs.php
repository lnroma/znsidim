<?php

namespace App\Models;

use App\Models\Blogs\Tags;
use Illuminate\Database\Eloquent\Model;
use App\Models\Blogs\Comment;
class Blogs extends Model
{
    public $table = 'user_blogs';
    /**
     * comments for blog
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function comments()
    {
        return $this->hasMany(Comment::class, 'user_blogs_id');
    }

    public function tags()
    {
        return $this->belongsToMany(Tags::class, 'blog_tags_user_blogs', 'blog_ids', 'tag_ids');
    }

}
