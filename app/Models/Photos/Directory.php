<?php

namespace App\Models\Photos;

use App\Models\Photos;
use bar\baz\source_with_namespace;
use Illuminate\Database\Eloquent\Model;

/**
 *
 * Class Directory
 * @property string title
 * @property string description
 * @property string user_id
 * @property string password
 * @property string storage_path
 *
 */
class Directory extends Model
{
    //
    public $table = 'photo_directories';

    public function photos()
    {
        return $this->hasMany(Photos::class, 'directory_id');
    }
}
