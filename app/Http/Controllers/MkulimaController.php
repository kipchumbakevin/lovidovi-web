<?php

namespace App\Http\Controllers;

use AfricasTalking\SDK\AfricasTalking;
use App\Mkulima;
use App\MkulimaCodes;
use Exception;
use Illuminate\Http\Request;

class MkulimaController extends Controller
{
    public function mkulimaSendCode(Request $request)
    {
        $signature = $request->appSignature;
        $output = $request->phone;
        $signupcode = rand(100000,999999);
        $nn = MkulimaCodes::wherePhone($output)->get();
        foreach ($nn as $n){
            $n->delete();
        }
        $codes = new MkulimaCodes();
        $codes->code=$signupcode;
        $codes->phone=$output;
        $username   = "mduka.com";
        $apiKey     = "e6bb78344764ab54525fed44772ee40feacfe796adea2d5bc620295997364a4f";
        $AT         = new AfricasTalking($username, $apiKey);
        $sms        = $AT->sms();
        $recipients = $output;
        $message    = "<#> Verification code:".$signupcode.": ".$signature;
        try {
            // Thats it, hit send and we'll take care of the rest
            $result = $sms->send([
                'to'      => $recipients,
                'message' => $message,
            ]);
        } catch (Exception $e) {
            echo "Error: ".$e->getMessage();
        }
        $codes->save();
        return response()->json([
            'message' => 'Code sent',
        ],201);
    }

    public function checkIfExist(Request $request)
    {
        $phone = $request['phone'];
        $mk = Mkulima::all();
        $ar = [];
        foreach ($mk as $p) {
            array_push($ar, $p->phone);
        }
        if (in_array($phone,$ar)){
            return response()->json([
                'message' => 'The number is already registered',
            ],200);
        }else {
            return response()->json([
                'message' => 'Done',
            ],201);
        }
    }
    function generateRandom($length = 25){
        $characters = 'abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';
        $randomString = '';
        for ($i = 0; $i<$length; $i++){
            $charactersLength = strlen($characters);
            $randomString .= $characters[rand(0,$charactersLength-1)];
        }
        return $randomString;
    }
    public function mkulimaRegister(Request $request)
    {
        $phone = $request['phone'];
        $code = $request['code'];
        $pin = $request['pin'];
        $mkCodes = MkulimaCodes::wherePhone($phone)->first();
        if ($code == $mkCodes->code){
            $mkulima = new Mkulima();
            $mkulima->phone = $phone;
            $mkulima->pin = $pin;
            $mkulima->inviteCode=$this->generateRandom(6);
            $mkulima->save();
            $mkCodes->delete();
            return response()->json([
                'message' => 'Successfully registered',
            ],201);
        }else{
            return response()->json([
                'message' => 'Wrong code',
            ],200);
        }
    }

    public function login(Request $request)
    {
        $pin = $request['pin'];
        $phone = $request['phone'];
        $mk = Mkulima::wherePhone($phone)->first();
        if ($mk == null){
            return response()->json([
                'message' => 'The phone number does not exist',
            ],200);
        }
        else if ($mk->pin != $pin){
            return response()->json([
                'message' => 'Wrong pin',
            ],200);
        }
        else {
            return response()->json([
                'message' => 'Success',
            ],201);
        }
    }
    public function payUp(Request $request)
    {
        $code = $request['inviteCode'];
        $phone = $request['phone'];
        if ($code != null) {
            $mk = Mkulima::where('inviteCode',$code)->first();
            if ($mk != null) {
                $mk->update([
                    'total' => ($mk->total) + 1,
                    'referrals' => ($mk->referrals) + 100
                ]);
            }
        }
        $mkpaying = Mkulima::wherePhone($phone)->first();
        $mkpaying->update([
            'paid'=>1
        ]);
        return response()->json([
            'message' => 'Success',
        ],201);
    }
    public function getMkulima(Request $request)
    {
        $phone = $request['phone'];
        $mkulima = Mkulima::wherePhone($phone)->first();
        return $mkulima;
    }

    public function withdraw(Request $request)
    {
        $phone = $request['phone'];
        $mk = Mkulima::wherePhone($phone)->first();
        $mk->update([
            'videos'=>0,
            'referrals'=>0
        ]);
        return response()->json([
            'message' => 'Withdrawal successful',
        ],201);
    }
}
