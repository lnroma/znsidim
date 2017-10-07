<?php

namespace App;

use App\Models\Photos\Directory;
use App\Models\Users\Anketa;
use App\Models\Users\Properties;
use App\Models\Users\Tables;
use Carbon\Carbon;
use Illuminate\Notifications\Notifiable;
use Illuminate\Foundation\Auth\User as Authenticatable;

class User extends Authenticatable
{
    use Notifiable;
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

    public function properties()
    {
        return $this->hasMany(Properties::class, 'user_id');
    }

    /**
     * set property data for user
     * @param $name
     * @param $value
     * @return $this
     */
    public function setProperty($name, $value)
    {
        if(!$value) {
            $value = 0;
        }

        $newValue = array();

        if(!is_array($value)) {
            $newValue[$name] = $value;
        } else {
            $newValue[$name] = $value;
        }

        $idProperty = null;
        if($this->getProperty($name, false, $idProperty)) {
           $property = Properties::find($idProperty);
        } else {
            $property = new Properties();
        }

        $property->user_id = $this->id;
        $property->system_name = $name;
        $property->value = json_encode($newValue);
        $property->save();

        return $this;
    }

    /**
     * get property from user
     * @param $name
     * @param null $default
     * @param null $returnId
     * @return mixed
     */
    public function getProperty($name, $default = null, &$returnId = null)
    {
        $property = Properties::whereRaw('user_id = ? and system_name = ?', [
            $this->id,
            $name
        ])->orderBy('id', 'desc')->first();

        if(is_null($property)) {
            return $default;
        }
        $returnId = $property->id;
        $value = $property->value;
        $value = json_decode($value, true);
        return $value[$name];
    }

    /**
     * is online user
     * @return bool
     */
    public function isOnline()
    {
        $date = Carbon::createFromTimestamp($this->getLastActivite());
        $diff = $date->diff(
            Carbon::now()
        );
        return ($diff->i < 1);
    }

    /**
     * set last activity
     * @return $this
     */
    public function setLastActivite()
    {
        $this->setProperty('last_activity', Carbon::now()->timestamp);
        return $this;
    }

    /**
     * get last activity
     * @return mixed
     */
    public function getLastActivite()
    {
        return $this->getProperty('last_activity', false);
    }
}
