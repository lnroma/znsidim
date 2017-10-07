<?php

namespace App\Http\Controllers\Games;

use App\Helpers\Messages;
use App\Http\Requests;
use App\Models\Games;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Input;
use App\Http\Controllers\Controller;

class IndexController extends Controller
{

    public function show($id)
    {
        $game = Games::find($id);
        return view('games.games')->with('game', $game);
    }

    public function listGames()
    {
        $allGames = Games::orderBy('id', 'desc')->paginate(15);
        return view('games.list')->with('games', $allGames);
    }

    public function addGames()
    {
        return view('games.form.add');
    }

    public function postAddGames(Request $request)
    {
        try {
            $games = new Games();
            // rom
            if (Input::file('rom') && Input::file('rom')->isValid()) {
                $destinationPath = 'roms';
                $extensions = Input::file('rom')->getClientOriginalExtension();
                $fileName = rand(1000, 10000) . '.' . $extensions;
                Input::file('rom')->move($destinationPath, $fileName);
                $games->rom_url = '/' . $destinationPath . '/' . $fileName;
            }

            $games->type = $request->get('type');
            $games->short_description = $request->get('short_description');
            $games->description_top = $request->get('description_top');
            $games->description_bottom = $request->get('description_bottom');
            $games->name = $request->get('name');
            $games->save();
        } catch (Exception $exception) {
            Messages::addError('Произошла ошибка во время сохранения '. $exception->getMessage());
        }
        Messages::addSuccess('Игра добавленна!');
        return redirect('/games/');
    }
}
