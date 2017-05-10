<?php

namespace App\Http\Controllers;

use App\Http\Requests;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Input;

class HomeController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return view('home');
    }

    public function post(Request $request)
    {
        /** @var User $user */
        $user = Auth::user();

        if (Input::file('avatar') && Input::file('avatar')->isValid()) {
            $destinationPath = 'uploads';
            $extensions = Input::file('avatar')->getClientOriginalExtension();
            $fileName = rand(1000,10000) . '.' . $extensions;
            Input::file('avatar')->move($destinationPath, $fileName);
            $user->avatar = '/' . $destinationPath . '/' . $fileName;
        }

        $user->birthday = date('Y-m-d h:m:s', strtotime($request->get('birthday')));
        $user->hello = $request->get('hello');
        $user->about_me = $request->get('about_me');
        $user->save();
    }
}
