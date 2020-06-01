<?php

namespace App\Http\Controllers;

use App\Chat;
use App\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ChatsController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth:api');
    }

    public function unreadChat(Request $request)
    {

        $output = preg_replace("/^0/", "+254", $request->phone);
        $ddx = Auth::guard('api')->user();
        $bb = User::where('phone',$output)->first();
        $chat = Chat::where('owner_id',$bb->id)->orWhere('participant_id',$bb->id)->get();
        $www = [];
        $ppp = [];
        foreach ($chat as $single){
            array_push($www,$single->owner_id);
            array_push($ppp,$single->participant);
        }
        if (in_array($bb->id,$www)){
            $chatty = Chat::where('owner_id',$bb->id)->get();
        }if (in_array($bb->id,$ppp)){
         $chatty = Chat::where('participant_id',$bb->id)->get();
    }
        return $chatty;
    }
}
