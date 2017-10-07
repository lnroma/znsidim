<?php

namespace App\Models\Users;

use Illuminate\Database\Eloquent\Model;

/**
 * Class Properties
 * @package App\Models\Users
 *
 * @property $user_id
 * @property $system_name
 * @property $value
 */
class Properties extends Model
{
    //
    public $table = 'user_properties';
}

