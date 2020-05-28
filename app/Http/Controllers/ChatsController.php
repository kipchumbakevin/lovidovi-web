<?php

namespace App\Http\Controllers;

use App\Chat;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ChatsController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth:api');
    }

    public function createChat(Request $request)
    {
        $chat = new Chat();
        $chat->owner_id=Auth::user()->id;
        $chat->participant_id=1;
        $chat->save();
    }
}
