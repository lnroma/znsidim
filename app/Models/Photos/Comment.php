<?php

namespace App\Models\Photos;

use App\Models\Photos;
use Illuminate\Database\Eloquent\Model;

class Comment extends Model
{
    public $table = 'photo_comments';
    //
    public function blog()
    {
        return $this->belongsTo(Photos::class, 'user_photo_id', 'id');
    }
}
