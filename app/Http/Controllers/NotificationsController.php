<?php

namespace App\Http\Controllers;

use App\Notifications;
use App\User;
use DemeterChain\A;
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
        $th = User::where('id',Auth::user()->id)->first();
        $output = preg_replace("/^0/", "+254", $request->phone);
        $not = new Notifications();
        $not->notification = $th->username." has a crush on you.";
        $not->sender_id = Auth::user()->id;
        $not->receiver_phone = $output;
        $not->status = false;
        if ($output==Auth::user()->phone){
            return response()->json([
                'message' => 'You cannot use your own phone number.',
            ],201);
        }else{
            $not->save();
            return response()->json([
                'message' => 'Your crush has been notified.',
            ],200);
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
}
