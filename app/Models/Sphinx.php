<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

/**
 * Class Sphinx
 * @package App\Models
 *
 * @property string $module
 * @property integer $sources_id
 * @property string $index
 */
class Sphinx extends Model
{
    public $table='blog_search_index';

    const INDEX_TYPE_FORUM = 'FORUM';
    const INDEX_TYPE_BLOG = 'BLOG';
    const INDEX_TYPE_USER = 'USER';
}
