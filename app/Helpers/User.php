<?php
/**
 * Created by PhpStorm.
 * User: roman
 * Date: 11.05.17
 * Time: 21:10
 */
namespace App\Helpers;

use App\User as UserModel;

class User {

    public static function getLinkById($id)
    {
        $user = UserModel::find($id);
        return '<a href="/user/show/' . $user->name . '"> ' . $user->name . '</a>';
    }

}