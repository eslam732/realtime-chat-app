<?php

namespace App\Http\Controllers;

use App\Event\NewMessage;
use App\Events\MessageSent;
use App\Models\Chat;
use App\Models\ChatUsers;
use App\Models\Message;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class ChatsController extends Controller
{

    public function __construct()
    {
        $this->middleware('auth:api');
    }

    public function getChats()
    {$user_id = Auth::id();

        $chats = DB::select(DB::raw("
        SELECT * FROM users
       join  chat_users on users.id=chat_users.user_id
       where (user_id=$user_id)
    ;"));

        return response()->json(['chats' => $chats], 200);

    }

    public function sendMessage()
    {
        if (!request()->chatId) {

            $chat = Chat::create();

            $chat_id = $chat->id;
            $user1chat = [];
            $user1chat['user_id'] = Auth::id();
            $user1chat['chat_id'] = $chat_id;
            ChatUsers::create($user1chat);
            $user2chat = [];
            $user2chat['user_id'] = request()->reciverId;
            $user2chat['chat_id'] = $chat_id;
            ChatUsers::create($user2chat);

            $messageData = [];
            $messageData['user_id'] = Auth::user()->id;
            $messageData['message'] = request()->message;
            $messageData['chat_id'] = $chat_id;

            $message=Message::create($messageData);
            broadcast(new NewMessage($message))->toOthers();
            return response()->json(['messages' => $message], 200);

        }
        $messageData = [];
        $messageData['user_id'] = Auth::user()->id;
        $messageData['message'] = request()->message;
        $messageData['chat_id'] = request()->chatId;

        $message= Message::create($messageData);
        broadcast(new NewMessage($message))->toOthers();
        
        return response()->json(['messages' => $message], 200);
    }

    public function userChats()
    {
        $user = Auth::user();
        $user=User::find($user->id);
    
        //$chats = $user->chats()->with('messages')->get();

        $chats=DB::select(DB::raw("
        SELECT * FROM users 
        join  chat_users on users.id=chat_users.user_id
        where (users.id=$user->id)
           
        "));
        return response()->json(['chats' => $chats], 200);
    }

    public function chatMessages($chatId)
    {
        $messages = Message::where('chat_id', $chatId)->with('user')->orderByDesc('created_at')->get();
        return response()->json(['messages' => $messages], 200);
    }
}
