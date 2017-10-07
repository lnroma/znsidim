<?php
/**
 * Created by PhpStorm.
 * User: roman
 * Date: 07.10.17
 * Time: 15:11
 */
namespace App\Http\Middleware;

use App\User;
use Closure;
//use Auth;
use Illuminate\Support\Facades\Auth;

class UsersOnline
{

    public function handle($request, Closure $next, $guard = null)
    {
        /** @var User $user */
        if($user = Auth::user()) {
            $user->setLastActivite();
        }
        return $next($request);
    }

}