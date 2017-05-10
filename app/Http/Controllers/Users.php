<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\App;
use Illuminate\Support\Facades\DB;
use App\User;
class Users extends Controller
{
    //
    public function index()
    {
        /** @var \Illuminate\Pagination\LengthAwarePaginator $catalog */
        $users = DB::table('users')->paginate(30);

        return view('users.users')
            ->with('users', $users);
    }

    public function show($login)
    {
        $user = User::where('name', $login)
            ->take(1)
            ->get();
        $user = $user->toArray();
        $userInformation = reset($user);

        return view('users.show')
            ->with($userInformation);
    }

}
