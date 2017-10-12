<?php

namespace App\Models\Users;

use App\Models\Users\Anketa\Value\City;
use App\Models\Users\Anketa\Value\Purpose;
use App\Models\Users\Anketa\Value\Sex;
use App\User;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class Anketa extends Model
{
    public $table = 'user_ankets';
    //
    public function getAllCity()
    {
        return DB::table('city_value')->orderBy('sort', 'DESC')->get();
    }

    public function getPurpose()
    {
        return Purpose::all();
    }

    public function getSex()
    {
        return Sex::all();
    }

    public function getSexValue()
    {
        return Sex::where('id',$this->sex)->first()->value;
    }

    public function getCityValue()
    {
        return City::where('id', $this->city_id)->first()->value;
    }

    public function getPurposeValue()
    {
        return Purpose::where('id', $this->purpose_id)->first()->value;
    }

    public function getUser()
    {
        return \App\Helpers\User::getUserById($this->user_id);
    }
}


