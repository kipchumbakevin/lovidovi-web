<?php

namespace App\Http\Controllers;

use App\Chat;
use App\Message;
use App\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class MessagesController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth:api');
    }

    public function sendMessage(Request $request)
    {
        $output = preg_replace("/^0/", "+254", $request->phone);
        $ccc = Chat::where('owner_id',Auth::guard('api')->user()->id)->get();
        $arrr = [];
        foreach ($ccc as $av){
            array_push($arrr,$av->participant_id);
        }
        $us = User::all();
        $rr = [];

        foreach ($us as $u){
            array_push($rr,$u->phone);
        }
        if (in_array($output,$rr)) {
            $xx = User::where('phone', $output)->first();
                if (in_array($xx->phone, $arrr) && !in_array($xx->id, $arrr) ) {
                    $damn = Chat::where('owner_id', Auth::guard('api')->user()->id)->where('participant_id', $output)->first();
                    $mesg = new Message();
                    $mesg->message = $request->msg;
                    $mesg->sender_id = Auth::user()->id;
                    $mesg->chat_id = $damn->id;
                    $mesg->receiver_id = $u->id;
                    $mesg->save();
                }
                if (in_array($xx->id, $arrr) && !in_array($xx->phone, $arrr) ) {
                    $dddd = Chat::where('owner_id', Auth::guard('api')->user()->id)->where('participant_id', $xx->id)->first();
                    $mesg = new Message();
                    $mesg->message = $request->msg;
                    $mesg->sender_id = Auth::user()->id;
                    $mesg->chat_id = $dddd->id;
                    $mesg->receiver_id = $xx->id;
                    $mesg->save();

            }
            if (!in_array($xx->phone, $arrr) && !in_array($xx->id, $arrr)){
                $chat = new Chat();
                $chat->owner_id=Auth::user()->id;
                $chat->participant_id = $xx->id;
                $chat->save();
                $new_item = Chat::orderby('created_at', 'desc')->first();
                $mesg = new Message();
                $mesg->message = $request->msg;
                $mesg->sender_id = Auth::user()->id;
                $mesg->chat_id=$new_item->id;
                $mesg->receiver_id = $xx->id;
                $mesg->save();
            }
        }
        if (!in_array($output,$rr)) {
            if (in_array($output, $arrr)) {
                $damn = Chat::where('owner_id', Auth::guard('api')->user()->id)->where('participant_id', $output)->first();
                $mesg = new Message();
                $mesg->message = $request->msg;
                $mesg->sender_id = Auth::user()->id;
                $mesg->chat_id = $damn->id;
                $mesg->receiver_id = $output;
                $mesg->save();
            }
            if (!in_array($output, $arrr)) {
                $chat = new Chat();
                $chat->owner_id = Auth::user()->id;
                $chat->participant_id = $output;
                $chat->save();
                $new_item = Chat::orderby('created_at', 'desc')->first();
                $mesg = new Message();
                $mesg->message = $request->msg;
                $mesg->sender_id = Auth::user()->id;
                $mesg->chat_id = $new_item->id;
                $mesg->receiver_id = $output;
                $mesg->save();

            }
        }
    }

    public function fetchChats(Request $request)
    {
        $gg =  Auth::guard('api')->user();
        $c = Chat::where('owner_id',$gg->id)->orWhere('participant_id',$gg->id)->with('participant')->latest()->get();
       // $c = Chat::where('owner_id',$gg->id)->orWhere('participant_id',$gg->id)->latest()->get();
        return $c;
//        $us = User::all('id');
//        $tt = [];
//        foreach ($c as $cch){
//            array_push($tt,$cch->participant_id);
//        }
//        if (in_array($us,$tt)){
//            $c = Chat::where('owner_id',$gg->id)->orWhere('participant_id',$gg->id)->with('participant')->latest()->get();
//            return $c;
//        }else{
//            $c = Chat::where('owner_id',$gg->id)->orWhere('participant_id',$gg->id)->latest()->get();
//            return $c;
//        }
    }
    public function fetchMessages(Request $request)
    {
        $m = Message::where('chat_id', $request->chat_id)->latest()->get();
        return $m;
    }
}
