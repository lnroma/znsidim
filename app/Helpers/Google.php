<?php
/**
 * Created by PhpStorm.
 * User: roman
 * Date: 31.05.17
 * Time: 22:02
 */
namespace App\Helpers;

use Google_Client;
use Google_Service_Oauth2;

class Google {

    public static function getAuthUrl()
    {
        $googleClient = new Google_Client();
        $clientJson = base_path('storage/config/') . 'client_id.json';
        $googleClient->setAuthConfig($clientJson);
        $googleClient->addScope(Google_Service_Oauth2::USERINFO_EMAIL);
        $googleClient->addScope(Google_Service_Oauth2::USERINFO_PROFILE);
        $googleClient->setRedirectUri('http://localhost:8000/googleCallbak');

        return $googleClient->createAuthUrl();
    }

}