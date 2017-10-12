<?php
/**
 * Created by PhpStorm.
 * User: roman
 * Date: 21.05.17
 * Time: 0:21
 */
namespace App\Helpers;

use Illuminate\Support\Facades\Session;

class Messages {

    public static function addSuccess($message)
    {
        Session::push('message.success', $message);
    }

    public static function addInfo($message)
    {
        Session::push('message.info', $message);
    }

    public static function addError($message)
    {
        Session::push('message.warning', $message);
    }

    public static function clearMessages()
    {
    }

    public static function getMessages()
    {
        $messages = session('message', false);
        Session::forget('message');
        return $messages;
    }

}