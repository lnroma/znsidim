<?php

namespace App\Models;

use App\Models\Photos\Comment;
use Illuminate\Database\Eloquent\Model;

class Photos extends Model
{
    //
    public $table = 'photos';

    public function comments()
    {
        return $this->hasMany(Comment::class, 'user_photo_id');
    }
}
