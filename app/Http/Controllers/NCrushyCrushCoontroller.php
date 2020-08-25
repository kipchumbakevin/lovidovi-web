<?php

namespace App\Http\Controllers;

use App\NCrush;
use Illuminate\Http\Request;

class NCrushyCrushCoontroller extends Controller
{
    public function insert(Request $request)
    {

        $ownerp = $request['ownerphone'];
        $receiverp = $request['phone'];
        $nottt = NCrush::where('sender_phone',$ownerp)->get();
        $ss = [];
        foreach ($nottt as $avi){
            array_push($ss,$avi->receiver_phone);
        }
        $output = preg_replace("/^0/", "+254", $request->phone);
        $not = new NCrush();
        $not->notification = "Secret crush on you.";
        $not->sender_phone = $ownerp;
        $not->receiver_phone = $receiverp;
        $not->status = false;

        if (in_array($receiverp,$ss)){
            return response()->json([
                'message' => 'You already mentioned this person as your crush',
            ],200);
        }else{
            if ($receiverp==$ownerp){
                return response()->json([
                    'message' => 'You cannot use your own phone number.',
                ],200);
            }else{
                $not->save();
                return response()->json([
                    'message' => 'Your crush has been notified.',
                ],200);
            }
        }

    }

    public function fetch(Request $request)
    {
        $ownerp = $request['ownerphone'];
        $receiverp = $request['phone'];
        // $notify = Notifications::where('receiver_phone',Auth::user()->phone)->orderBy('created_at','DESC')->get();
        $notify = NCrush::where('receiver_phone',$ownerp)->latest()->get();
        return $notify;
    }

    public function unread(Request $request)
    {
        $ownerp = $request['ownerphone'];
        $notif = NCrush::where('receiver_phone',$ownerp)->where('status',false)->count();
        return response()->json([
            'num' => $notif,
        ],201);
    }
    public function deleteN(Request $request)
    {
        $notif = NCrush::where('id',$request->id)->first();
        $notif->delete();
        return response()->json([
            'messsage' => "Deleted successfully",
        ],201);
    }

    public function readall(Request $request)
    {
        $ownerp = $request['ownerphone'];
        $nnn = NCrush::where('receiver_phone',$ownerp)->where('status',false)->get();
        foreach ($nnn as $dff){
            $dff->update([
                'status'=>true
            ]);
        }
        return response()->json([
            'message' => 'read.',
        ],201);
    }
}
