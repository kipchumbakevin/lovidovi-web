<?php

namespace App\Http\Controllers;

use AfricasTalking\SDK\AfricasTalking;
use App\Notifications;
use App\User;
use DemeterChain\A;
use Exception;
use Illuminate\Support\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class NotificationsController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth:api');
    }
    public function insert(Request $request)
    {

        $th = User::where('id',Auth::guard('api')->user()->id)->first();
        $nottt = Notifications::where('sender_phone',$th->phone)->get();
        $ss = [];
        foreach ($nottt as $avi){
            array_push($ss,$avi->receiver_phone);
        }
        $output = preg_replace("/^0/", "+254", $request->phone);
        $not = new Notifications();
        $not->notification = $th->username." has a crush on you.";
        $not->sender_phone = Auth::guard('api')->user()->phone;
        $not->receiver_phone = $output;
        $not->status = false;
        $wwww = User::all();
        $rrr = [];
        foreach ($wwww as $ttt){
            array_push($rrr,$ttt->phone);
        }

        if (in_array($output,$ss)){
            return response()->json([
                'message' => 'You already mentioned this person as your crush',
            ],200);
        }else{
            if ($output==Auth::guard('api')->user()->phone){
                return response()->json([
                    'message' => 'You cannot use your own phone number.',
                ],200);
            }else{
                $not->save();
				if (!in_array($output,$rrr)){
            $username   = "mduka.com";
            $apiKey     = "d2bdc1e410c54f814600f7dda33cbede0219d74940900f5b3a5dc145cc954082";
            $AT         = new AfricasTalking($username, $apiKey);
            $sms        = $AT->sms();
            $recipients = $output;
            $message    = $th->username." has a crush on you.\n download now at sendeu.com haha \n and send them a message";
            try {
                // Thats it, hit send and we'll take care of the rest
                $result = $sms->send([
                    'to'      => $recipients,
                    'message' => $message,
                ]);
            } catch (Exception $e) {
                echo "Error: ".$e->getMessage();
            }
        }
                return response()->json([
                    'message' => 'Your crush has been notified.',
                ],200);
            }
        }

    }
    public function like(Request $request)
    {
        $th = User::where('id',Auth::user()->id)->first();
        $output = preg_replace("/^0/", "+254", $request->phone);
        $not = new Notifications();
        $not->notification = $th->username." liked your post.";
        $not->sender_id = Auth::user()->id;
        $not->receiver_phone = $output;
        $not->status = false;
        $not->save();
        return response()->json([
            'message' => 'Notified.',
        ],201);
    }

    public function fetch(Request $request)
    {
       // $notify = Notifications::where('receiver_phone',Auth::user()->phone)->orderBy('created_at','DESC')->get();
        $notify = Notifications::where('receiver_phone',$request->phone)->latest()->get();
        return $notify;
    }

    public function unread(Request $request)
    {
        $output = preg_replace("/^0/", "+254", $request->phone);
        $notif = Notifications::where('receiver_phone',$output)->where('status',false)->count();
        return response()->json([
            'num' => $notif,
        ],201);
    }
	 public function deleteN(Request $request)
    {
        $notif = Notifications::where('id',$request->id)->first();
		$notif->delete();
        return response()->json([
            'messsage' => "Deleted successfully",
        ],201);
    }

    public function readall(Request $request)
    {
        $output = preg_replace("/^0/", "+254", $request->phone);
        $nnn = Notifications::where('receiver_phone',$output)->where('status',false)->get();
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
