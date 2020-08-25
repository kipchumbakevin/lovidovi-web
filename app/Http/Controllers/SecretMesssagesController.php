<?php

namespace App\Http\Controllers;

use AfricasTalking\SDK\AfricasTalking;
use App\SecretChat;
use App\SecretMessage;
use App\User;
use Carbon\Carbon;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class SecretMesssagesController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth:api');
    }

    public function sendSecretMessage(Request $request)
    {
        $output = preg_replace("/^0/", "+254", $request->phone);
        $ccc = SecretChat::where('owner_id',Auth::guard('api')->user()->id)
            ->orWhere('participant_id',Auth::guard('api')->user()->id)->get();
        $arrr = [];
        $avvv = [];

        foreach ($ccc as $av){
            array_push($arrr,$av->owner_id);
            array_push($avvv,$av->participant_id);
        }
        $us = User::all();
        $rr = [];

        foreach ($us as $u){
            array_push($rr,$u->phone);
        }
        if (in_array($output,$rr)) {
            $xx = User::where('phone', $output)->first();
            if (in_array($xx->id, $arrr)||in_array($xx->id,$avvv) ) {
                $dddd = SecretChat::where('owner_id', Auth::guard('api')->user()->id)->where('participant_id',$xx->id)->count();
                $ddddz = SecretChat::where('participant_id', Auth::guard('api')->user()->id)->where('owner_id',$xx->id)->count();
                if ($dddd>0){
                    $dm = SecretChat::where('owner_id', Auth::guard('api')->user()->id)
                        ->where('participant_id',$xx->id)->first();
                    $mesg = new SecretMessage();
                    $mesg->message = $request->msg;
                    $mesg->sender_id = Auth::guard('api')->user()->id;
                    $mesg->chat_id = $dm->id;
                    $mesg->receiver_id = $xx->id;
                    $dm->touch();
                    $mesg->save();
                    return response()->json([
                        'message' => 'Message sent',
                    ],201);
                }
                if ($ddddz>0){
                    $dm = SecretChat::where('participant_id', Auth::guard('api')->user()->id)
                        ->where('owner_id',$xx->id)->first();
                    $mesg = new SecretMessage();
                    $mesg->message = $request->msg;
                    $mesg->sender_id = Auth::guard('api')->user()->id;
                    $mesg->chat_id = $dm->id;
                    $mesg->receiver_id = $xx->id;
                    $dm->touch();
                    $mesg->save();
                    return response()->json([
                        'message' => 'Message sent',
                    ],201);
                }

            }
            else{
                $chat = new SecretChat();
                $chat->owner_id=Auth::user()->id;
                $chat->participant_id = $xx->id;
                $chat->save();
                $new_item = SecretChat::orderby('created_at', 'desc')->first();
                $mesg = new SecretMessage();
                $mesg->message = $request->msg;
                $mesg->sender_id = Auth::user()->id;
                $mesg->chat_id=$new_item->id;
                $mesg->receiver_id = $xx->id;
                $mesg->save();
                return response()->json([
                    'message' => 'Message sent',
                ],201);
            }
        }
        if (!in_array($output,$rr)) {
            if (in_array($output, $avvv)) {
                $dddd = SecretChat::where('owner_id', Auth::guard('api')->user()->id)->where('participant_id',$output)->count();
                //$ddddz = Chat::where('participant_id', Auth::guard('api')->user()->id)->where('owner_id',$xx->id)->count();
                if ($dddd>0){
                    $damn = SecretChat::where('owner_id', Auth::guard('api')->user()->id)->where('participant_id',$output)->first();
                    $mesg = new SecretMessage();
                    $mesg->message = $request->msg;
                    $mesg->sender_id = Auth::user()->id;
                    $mesg->chat_id = $damn->id;
                    $mesg->receiver_id = $output;
                    $damn->touch();
                    $mesg->save();
                  //  $username   = "mduka.com";
                  //  $apiKey     = "d2bdc1e410c54f814600f7dda33cbede0219d74940900f5b3a5dc145cc954082";
                  //  $AT         = new AfricasTalking($username, $apiKey);
                 //   $sms        = $AT->sms();
                 //   $recipients = $output;
                //    $message    = "You have 1 new message.\n download now at https://play.google.com/store/apps/details?id=aarhealthcare.com.androidapp\ ";
                  //  try {
                        // Thats it, hit send and we'll take care of the rest
                 //       $result = $sms->send([
                 //           'to'      => $recipients,
                 //           'message' => $message,
                 //       ]);
                 //   } catch (Exception $e) {
                 //       echo "Error: ".$e->getMessage();
                  //  }
                    return response()->json([
                        'message' => 'Message sent',
                    ],201);
                }

            }
            if (!in_array($output, $avvv)) {
                $chat = new SecretChat();
                $chat->owner_id = Auth::user()->id;
                $chat->participant_id = $output;
                $chat->save();
                $new_item = SecretChat::orderby('created_at', 'desc')->first();
                $mesg = new SecretMessage();
                $mesg->message = $request->msg;
                $mesg->sender_id = Auth::user()->id;
                $mesg->chat_id = $new_item->id;
                $mesg->receiver_id = $output;
                $mesg->save();
                $username   = "mduka.com";
                $apiKey     = "d2bdc1e410c54f814600f7dda33cbede0219d74940900f5b3a5dc145cc954082";
                $AT         = new AfricasTalking($username, $apiKey);
                $sms        = $AT->sms();
                $recipients = $output;
                $message    = "You have 1 new message.\n download now at https://play.google.com/store/apps/details?id=aarhealthcare.com.androidapp\ ";
                try {
                    // Thats it, hit send and we'll take care of the rest
                    $result = $sms->send([
                        'to'      => $recipients,
                        'message' => $message,
                    ]);
                } catch (Exception $e) {
                    echo "Error: ".$e->getMessage();
                }
                return response()->json([
                    'message' => 'Message sent',
                ],201);

            }
        }
    }

    public function fetchSecretChats(Request $request)
    {
        $gg =  Auth::guard('api')->user();
        $c = SecretChat::where('owner_id',$gg->id)->orWhere('participant_id',$gg->id)->get();
        foreach ($c as $ddf) {
            if ($ddf->owner_id == $gg->id) {
                $c = SecretChat::where('owner_id', $gg->id)->orWhere('participant_id', $gg->id)->where('owner_delete',false)->
                with('participant')->with('owner')->with('receiver')->latest('updated_at')->get();
                return $c;
            }
            if ($ddf->participant_id == $gg->id) {
                $c = SecretChat::where('owner_id', $gg->id)->orWhere('participant_id', $gg->id)->where('participant_delete',false)->
                with('participant')->with('owner')->with('receiver')->latest('updated_at')->get();
                return $c;
            }
        }

    }
    public function fetchSecretMessages(Request $request)
    {
        $m = SecretMessage::where('chat_id', $request->chat_id)->latest()->get();
        return $m;
    }
    public function readUnreadMessages(Request $request)
    {
        $mmm = SecretMessage::where('chat_id',$request->chat_id)->where('receiver_id',Auth::guard('api')->user()->id)->get();
        foreach ($mmm as $ddd){
            $ddd->receiver_read=true;
            $ddd->save();
        }
        return response()->json([
            'message' => 'Done',
        ],201);
    }
    public function unreadMessages()
    {
        $notif = SecretMessage::where('receiver_id',Auth::guard('api')->user()->id)->where('receiver_read',false)->count();
        return response()->json([
            'num' => $notif,
        ],201);

    }
    public function deleteChat(Request $request)
    {
        $ch = SecretChat::where('id',$request->id)->first();
        $m = SecretMessage::where('chat_id',$request->id)->get();
        $rr = [];
        if ($ch->owner_id == Auth::guard('api')->user()->id){
            $ch->update([
                'owner_delete'=>1
            ]);
            foreach ($m as $sen){
                    $sen->delete();

            }
            return response()->json([
                'message' => 'Deleted',
            ],201);
        }if ($ch->participant_id == Auth::guard('api')->user()->id){
        $ch->update([
            'participant_delete'=>1
        ]);
        foreach ($m as $sen){
            $sen->delete();

        }
        return response()->json([
            'message' => 'Deletetd',
        ],201);
    }
    else{
        return response()->json([
            'message' => 'failed',
        ],200);
    }
    }
    public function deleteMessage(Request $request)
    {
        $mes = SecretMessage::where('id',$request->id)->first();
        if ($mes->sender_id == Auth::guard('api')->user()->id){
            $mes->update([
                'sender_delete'=>1
            ]);
            return response()->json([
                'message' => 'Delete',
            ],201);
        }if ($mes->receiver_id == Auth::guard('api')->user()->id){
        $mes->update([
            'receiver_delete'=>1
        ]);
        return response()->json([
            'message' => 'Delete',
        ],201);
    }
    else{
        return response()->json([
            'message' => 'failed',
        ],200);
    }
    }
}
