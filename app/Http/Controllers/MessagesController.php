<?php

namespace App\Http\Controllers;

use AfricasTalking\SDK\AfricasTalking;
use App\Chat;
use App\Message;
use App\User;
use Carbon\Carbon;
use Exception;
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
        $ccc = Chat::where('owner_id',Auth::guard('api')->user()->id)
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
                    $dddd = Chat::where('owner_id', Auth::guard('api')->user()->id)->where('participant_id',$xx->id)->count();
                    $ddddz = Chat::where('participant_id', Auth::guard('api')->user()->id)->where('owner_id',$xx->id)->count();
                    if ($dddd>0){
                        $dm = Chat::where('owner_id', Auth::guard('api')->user()->id)
                            ->where('participant_id',$xx->id)->first();
                        $mesg = new Message();
                        $mesg->message = $request->msg."gg";
                        $mesg->sender_id = Auth::guard('api')->user()->id;
                        $mesg->chat_id = $dm->id;
                        $mesg->receiver_id = $xx->id;
                        $mesg->save();
                        $new_item = Message::orderby('created_at', 'desc')->first();
                        $dm->touch();
						return response()->json([
            'message' => 'Message sent',
        ],201);
                    }
                    if ($ddddz>0){
                        $dm = Chat::where('participant_id', Auth::guard('api')->user()->id)
                            ->where('owner_id',$xx->id)->first();
                        $mesg = new Message();
                        $mesg->message = $request->msg;
                        $mesg->sender_id = Auth::guard('api')->user()->id;
                        $mesg->chat_id = $dm->id;
                        $mesg->receiver_id = $xx->id;
                        $mesg->save();
                        $new_item = Message::orderby('created_at', 'desc')->first();
                        $dm->touch();
						return response()->json([
            'message' => 'Message sent',
        ],201);
                    }

            }
            else{
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
				return response()->json([
            'message' => 'Message sent',
        ],201);
            }
        }
        if (!in_array($output,$rr)) {
            if (in_array($output, $avvv)) {
                $dddd = Chat::where('owner_id', Auth::guard('api')->user()->id)->where('participant_id',$output)->count();
                //$ddddz = Chat::where('participant_id', Auth::guard('api')->user()->id)->where('owner_id',$xx->id)->count();
                if ($dddd>0){
                    $damn = Chat::where('owner_id', Auth::guard('api')->user()->id)->where('participant_id',$output)->first();
                    $mesg = new Message();
                    $mesg->message = $request->msg;
                    $mesg->sender_id = Auth::user()->id;
                    $mesg->chat_id = $damn->id;
                    $mesg->receiver_id = $output;
                    $mesg->save();
                    $damn->touch();
                   // $username   = "mduka.com";
                   // $apiKey     = "d2bdc1e410c54f814600f7dda33cbede0219d74940900f5b3a5dc145cc954082";
                   // $AT         = new AfricasTalking($username, $apiKey);
                   // $sms        = $AT->sms();
                   // $recipients = $output;
                   // $message    = "You have 1 new message.\n download now at https://play.google.com/store/apps/details?id=aarhealthcare.com.androidapp\ ";
                  //  try {
                        // Thats it, hit send and we'll take care of the rest
                 //       $result = $sms->send([
                 //           'to'      => $recipients,
                 //           'message' => $message,
                 //       ]);
                 //   } catch (Exception $e) {
                 //       echo "Error: ".$e->getMessage();
                 //   }
					return response()->json([
            'message' => 'Message sent',
        ],201);
                }

            }
            if (!in_array($output, $avvv)) {
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

    public function fetchChats(Request $request)
    {
        $gg =  Auth::guard('api')->user();
        $c = Chat::where('owner_id',$gg->id)->orWhere('participant_id',$gg->id)->
            with('participant')->with('user')->latest('updated_at')->get();
        return $c;

    }
    public function fetchMessages(Request $request)
    {
        $m = Message::where('chat_id', $request->chat_id)->latest()->get();
        return $m;
    }
}
