<?php
/**
 * Created by PhpStorm.
 * User: roman
 * Date: 11.05.17
 * Time: 21:10
 */
namespace App\Helpers;

use App\User as UserModel;

class User
{

    public static function getLinkById($id)
    {
        $user = UserModel::find($id);
        if(!$user) {
            return 'Аноним';
        }
        return '<a href="/user/show/' . $user->name . '"> ' . $user->name . '</a>';
    }

    public static function getUserById($id)
    {
        return UserModel::find($id);
    }

    public static function getUserByName($name)
    {
        return UserModel::where('name', $name)->first();
    }

}