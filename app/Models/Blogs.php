<?php

namespace App\Models;

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
}
