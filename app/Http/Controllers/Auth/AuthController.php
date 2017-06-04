<?php

namespace App\Http\Controllers\Auth;

use App\Helpers\Messages;
use App\User;
use Exception;
use Google_Client;
use Google_Service_Oauth2;
use Illuminate\Support\Facades\Auth;
use Symfony\Component\HttpKernel\Exception\BadRequestHttpException;
use Validator;
use App\Http\Controllers\Controller;
use Illuminate\Foundation\Auth\ThrottlesLogins;
use Illuminate\Foundation\Auth\AuthenticatesAndRegistersUsers;

class AuthController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | Registration & Login Controller
    |--------------------------------------------------------------------------
    |
    | This controller handles the registration of new users, as well as the
    | authentication of existing users. By default, this controller uses
    | a simple trait to add these behaviors. Why don't you explore it?
    |
    */

    use AuthenticatesAndRegistersUsers, ThrottlesLogins;

    /**
     * Where to redirect users after login / registration.
     *
     * @var string
     */
    protected $redirectTo = '/';
    protected $username = 'name';

    /**
     * Create a new authentication controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware($this->guestMiddleware(), ['except' => 'logout']);
    }

    /**
     * Get a validator for an incoming registration request.
     *
     * @param  array  $data
     * @return \Illuminate\Contracts\Validation\Validator
     */
    protected function validator(array $data)
    {
        return Validator::make($data, [
            'name' => 'required|max:255|unique:users',
            'email' => 'required|email|max:255|unique:users',
            'password' => 'required|min:6|confirmed',
            'captcha' => 'required|captcha',
        ]);
    }

    /**
     * Create a new user instance after a valid registration.
     *
     * @param  array  $data
     * @return User
     */
    protected function create(array $data)
    {
        return User::create([
            'name' => $data['name'],
            'email' => $data['email'],
            'password' => bcrypt($data['password']),
        ]);
    }

    public function googleCallback()
    {
        if(!isset($_GET['code'])) {
            http_redirect('/');
        }

        try {
            $googleClient = new Google_Client();
            $clientJson = base_path('storage/config/') . 'client_id.json';
            $googleClient->setAuthConfig($clientJson);
            $googleClient->addScope(Google_Service_Oauth2::USERINFO_EMAIL);
            $googleClient->addScope(Google_Service_Oauth2::USERINFO_PROFILE);
            $googleClient->setRedirectUri('http://sidimvprobke.com/googleCallbak');

            $token = $googleClient->fetchAccessTokenWithAuthCode($_GET['code']);
            $googleClient->setAccessToken($token);
            $userGoogle = new Google_Service_Oauth2($googleClient);
            $userGoogle = $userGoogle->userinfo->get();

            $user = User::where('auth_token', '=', $userGoogle->id)->first();

            if (!$user) {
                $nick = explode('@', $userGoogle->getEmail(), 2);
                $nick = $nick[0];

                if (!User::where('name', '=', $nick)) {
                    $nick = $nick . rand(1, 1000);
                }

                $user = new User();
                $user->name = $nick;
                $user->email = $userGoogle->getEmail();
                $user->auth_token = $userGoogle->getId();
                $user->save();

                Messages::addSuccess('Вы успешно зарегистрированны!');
                Auth::login($user);
            } else {
                Messages::addSuccess('Вы залогинились!');
                Auth::login($user);
            }

        } catch (Exception $exception) {
            Messages::addError('Ошибка авторизации, попробуйте снова!');
        }

        return redirect('/');
    }
}
