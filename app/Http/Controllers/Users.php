<?php

namespace App\Http\Controllers;

use App\Helpers\Messages;
use App\Jobs\SendNotification;
use App\Models\Users\Tables;
use App\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class Users extends Controller
{
    //
    public function index()
    {
        /** @var \Illuminate\Pagination\LengthAwarePaginator $catalog */
        $users = User::orderBy('id', 'desc')->paginate(30);

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

    public function saveTables(Request $request)
    {
        $tables = new Tables();

        if(Auth::guest()) {
            Messages::addError('Сообщение могут оставлять только зарегистрированные пользователи!');
            return redirect(url()->previous());
        }

        $user = Auth::user();

        $tables->user_id = $user->id;
        $tables->user_tables_id = $request->user_id;
        $tables->is_enabled = true;
        $tables->name = $user->name;
        $tables->comment = $request->comment;
        $tables->save();

        // сообщение пользователям о написание на стене
        $this->dispatch(
            new SendNotification(
                $user->name . ' написал: ' . $request->comment ,
                url()->previous(),
                'Новое сообщение на стене:' . \App\Helpers\User::getUserById($user->id)->name,
                false
            )
        );

        Messages::addSuccess('Ваше сообщение сохранено!');

        return redirect(url()->previous());
    }

}
