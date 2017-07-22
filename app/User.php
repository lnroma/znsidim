<?php

namespace App;

use App\Models\Photos\Directory;
use App\Models\Users\Anketa;
use App\Models\Users\Tables;
use Illuminate\Notifications\Notifiable;
use Illuminate\Foundation\Auth\User as Authenticatable;

class User extends Authenticatable
{
    use Notifiable;
    use \HighIdeas\UsersOnline\Traits\UsersOnlineTrait;
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name', 'email', 'password',
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password', 'remember_token',
    ];

    public function directories()
    {
        return $this->hasMany(Directory::class, 'user_id');
    }

    public function tables()
    {
        return $this->hasMany(Tables::class, 'user_tables_id');
    }

    public function ankets()
    {
        return $this->hasOne(Anketa::class, 'user_id');
    }
}
