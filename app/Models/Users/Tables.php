<?php

namespace App\Models\Users;

use App\User;
use Illuminate\Database\Eloquent\Model;

class Tables extends Model
{
    public $table = 'user_tables';
    //
    public function blog()
    {
        return $this->belongsTo(User::class, 'user_blogs_id', 'id');
    }
}
