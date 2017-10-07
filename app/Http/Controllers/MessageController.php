<?php

namespace App\Http\Controllers;

//use App\Notifications\InvoicePaid;
//use App\Notifications\Post;
use App\Helpers\Messages;
use App\Notifications\Post;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Http\Request;
use App\User;
use Intervention\Image\Exception\NotFoundException;
use Nahid\Talk\Conversations\Conversation;
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

    public function settings()
    {
        /** @var User $user */
        $user = Auth::user();

        if($user->getProperty('mail_settings_input_up', 1) == 1) {
            $inputUp[1] = 'active';
            $inputUp[0] = 'notActive';
        } else {
            $inputUp[1] = 'notActive';
            $inputUp[0] = 'active';
        }

        if($user->getProperty('mail_settings_first_up', 1) == 1) {
            $firstUp[1] = 'active';
            $firstUp[0] = 'notActive';
        } else {
            $firstUp[1] = 'notActive';
            $firstUp[0] = 'active';
        }

        return view('messages.settings')
            ->with('inputUp', $inputUp)
            ->with('firstUp', $firstUp);
    }

    public function saveSettings(Request $request)
    {
        /** @var User $user */
        $user = Auth::user();
        $user->setProperty('mail_settings_input_up', $request->get('input_up', 1));
        $user->setProperty('mail_settings_first_up', $request->get('first_up', 1));

        Messages::addSuccess('Настройка почты сохранена');

        header('Location: ' . url()->previous());
        exit;
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

    public function chat($login, Request $request)
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

        $conversations = Talk::getMessagesAllByUserId($user->id, 0, 1000);

        if($conversations) {
            $messages = $conversations->messages;
            $countMessages = $messages->count();

            /** @var Collection $messages */
            $countPages = ceil($countMessages / 5);

            if($user->getProperty('mail_settings_first_up', 1)) {
                $messages = $messages->reverse();
                $currentPage = $request->get('p', 1);
            } else {
                $currentPage = $request->get('p', $countPages);
            }
            $messages = $messages->forPage($currentPage, 5);
        } else {
            $countPages = 0;
            $currentPage = 0;
        }

        return view('messages.chat', array(
            'user' => $user,
            'messages' => $messages,
            'countPage' => $countPages,
            'currentPage' => $currentPage,
            'inputUp' => $user->getProperty('mail_settings_input_up', 1)
        ));
    }
}
