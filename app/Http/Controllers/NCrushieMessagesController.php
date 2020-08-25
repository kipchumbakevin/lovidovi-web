<?php

namespace App\Http\Controllers;

use App\NCrushieChat;
use App\NCrushieMessage;
use Illuminate\Http\Request;

class NCrushieMessagesController extends Controller
{
    public function sendSecretMessage(Request $request)
    {

        $ownerp = $request['ownerphone'];
        $receiverp = $request['phone'];
        $ccc = NCrushieChat::where('owner_id', $ownerp)
            ->orWhere('participant_id', $ownerp)->get();
        $arrr = [];
        $avvv = [];

        foreach ($ccc as $av) {
            array_push($arrr, $av->owner_id);
            array_push($avvv, $av->participant_id);
        }

        if (in_array($receiverp, $arrr) || in_array($receiverp, $avvv)) {
            $dddd = NCrushieChat::where('owner_id', $ownerp)->where('participant_id', $receiverp)->count();
            $ddddz = NCrushieChat::where('participant_id', $ownerp)->where('owner_id', $receiverp)->count();
            if ($dddd > 0) {
                $dm = NCrushieChat::where('owner_id',$ownerp)
                    ->where('participant_id', $receiverp)->first();
                $mesg = new NCrushieMessage();
                $mesg->message = $request->msg;
                $mesg->sender_id = $ownerp;
                $mesg->chat_id = $dm->id;
                $mesg->receiver_id = $receiverp;
                $dm->touch();
                $mesg->save();
                return response()->json([
                    'message' => 'Message sent',
                ], 201);
            }
            if ($ddddz > 0) {
                $dm = NCrushieChat::where('participant_id',$ownerp)
                    ->where('owner_id', $receiverp)->first();
                $mesg = new NCrushieMessage();
                $mesg->message = $request->msg;
                $mesg->sender_id = $ownerp;
                $mesg->chat_id = $dm->id;
                $mesg->receiver_id = $receiverp;
                $dm->touch();
                $mesg->save();
                return response()->json([
                    'message' => 'Message sent',
                ], 201);
            }

        } else {
            $chat = new NCrushieChat();
            $chat->owner_id = $ownerp;
            $chat->participant_id =$receiverp;
            $chat->save();
            $new_item = NCrushieChat::orderby('created_at', 'desc')->first();
            $mesg = new NCrushieMessage();
            $mesg->message = $request->msg;
            $mesg->sender_id = $ownerp;
            $mesg->chat_id = $new_item->id;
            $mesg->receiver_id =$receiverp;
            $mesg->save();
            return response()->json([
                'message' => 'Message sent',
            ], 201);
        }
    }

    public function fetchSecretChats(Request $request)
    {
        $ownerp = $request['ownerphone'];
        $receiverp = $request['phone'];
        $c = NCrushieChat::where('owner_id',$ownerp)->orWhere('participant_id',$ownerp)->with('receiver')->latest('updated_at')->get();
        return $c;
//        foreach ($c as $ddf) {
//            if ($ddf->owner_id == $gg->id) {
//                $c = SecretChat::where('owner_id', $gg->id)->orWhere('participant_id', $gg->id)->where('owner_delete',false)->
//                with('participant')->with('owner')->with('receiver')->latest('updated_at')->get();
//                return $c;
//            }
//            if ($ddf->participant_id == $gg->id) {
//                $c = SecretChat::where('owner_id', $gg->id)->orWhere('participant_id', $gg->id)->where('participant_delete',false)->
//                with('participant')->with('owner')->with('receiver')->latest('updated_at')->get();
//                return $c;
//            }
//        }

    }
    public function fetchSecretMessages(Request $request)
    {
        $m = NCrushieMessage::where('chat_id', $request->chat_id)->latest()->get();
        return $m;
    }
    public function readUnreadMessages(Request $request)
    {
        $ownerp = $request['ownerphone'];
        $receiverp = $request['phone'];
        $mmm = NCrushieMessage::where('chat_id',$request->chat_id)->where('receiver_id',$ownerp)->get();
        foreach ($mmm as $ddd){
            $ddd->receiver_read=true;
            $ddd->save();
        }
        return response()->json([
            'message' => 'Done',
        ],201);
    }
    public function unreadMessages(Request $request)
    {
        $ownerp = $request['ownerphone'];
        $receiverp = $request['phone'];
        $notif = NCrushieMessage::where('receiver_id',$ownerp)->where('receiver_read',false)->count();
        return response()->json([
            'num' => $notif,
        ],201);

    }
    public function deleteChat(Request $request)
    {
        $ch = NCrushieChat::where('id',$request->id)->first();
        $m = NCrushieMessage::where('chat_id',$request->id)->get();
        $ch->delete();
        $m->delete();
    }
    public function deleteMessage(Request $request)
    {
        $mes = NCrushieMessage::where('id', $request->id)->first();
        $mes->delete();
        return response()->json([
            'message' => 'Delete',
        ], 201);
    }
}
