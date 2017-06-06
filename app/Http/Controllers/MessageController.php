<?php

namespace App\Http\Controllers;

//use App\Notifications\InvoicePaid;
//use App\Notifications\Post;
use App\Notifications\Post;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Http\Request;
use App\User;
use Intervention\Image\Exception\NotFoundException;
use Nahid\Talk\Facades\Talk;
use Illuminate\Support\Facades\Auth;
use Illuminate\Contracts\View\View;
use Nahid\Talk\Messages\Message;

class MessageController extends Controller
{
    //
    protected $authUser;

    public function __construct()
    {

    }

    public function index()
    {
        if(!Auth::user()) {
            header('Location:/');
        }

        $this->middleware('auth');
        Talk::setAuthUserId(Auth::user()->id);
        $threads = Talk::threads();

        return view('messages.threads')
            ->with('threads', $threads);
    }

    public function send($login)
    {
        if(!Auth::user()) {
            header('Location:/');
        }

        return view('messages.send')
            ->with('login', $login);
    }

    public function postMessage(Request $request)
    {
        $rules = array(
            'login' => 'required',
            'message' => 'required',
        );

        $this->validate($request, $rules);

        $user = User::where('name', $request->input('login'))
            ->first();

        if(!$user) {
            throw new NotFoundException('Пользователь не найден!');
        }

        $this->middleware('auth');
        Talk::setAuthUserId(Auth::user()->id);

        Talk::sendMessageByUserId($user->id, $request->input('message'));
        $login = $request->input('login');
        $user->notify(new Post());

        header("Location:/messages/chat/{$login}");
        die;
    }

    public function chat($login)
    {
        if(!Auth::user()) {
            header('Location:/');
        }
        /** @var Post $_notification */
        foreach (Auth::user()->unreadNotifications as $_notification) {
            if($_notification->toArray($_notification)['type'] == Post::class) {
                $_notification->markAsRead();
            }
        }
        $user = User::where('name', $login)
            ->first();
        $messages = array();

        if(!$user) {
            throw new NotFoundException('Пользователь не найден!');
        }

        $this->middleware('auth');
        Talk::setAuthUserId(Auth::user()->id);

        $conversations = Talk::getMessagesByUserId($user->id);

        if($conversations) {
            /** @var Collection $messages */
            $messages = $conversations->messages;
        }

        return view('messages.chat', array(
            'user' => $user,
            'messages' => $messages,
        ));
    }
}
