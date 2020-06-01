<?php

namespace App\Http\Controllers;

use App\Code;
use App\Codes;
use App\User;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class NoAuthController extends Controller
{
    public function sendCode(Request $request)
    {
        $output = preg_replace("/^0/", "+254", $request->phone);
        $user = User::where('phone',$output)->first();
        if ($user->phone==$output) {
            return response()->json([
                'message' => 'Correct',
            ], 201);
        }else{
            return null;
        }

    }
    public function checkIfUserExists(Request $request)
    {
        $numbers = [];
        $all = [];
        $output = preg_replace("/^0/", "+254", $request->phone);
        $user = User::all('phone','username');
        $usnm = $request['username'];
        foreach ($user as $users){
            array_push($numbers,$users->phone);
            array_push($numbers,$users->username);
        }
        if (in_array($output,$numbers) && in_array($usnm,$numbers)){
            return response()->json([
                'message' => 'The username and phone number have already been taken',
            ]);
        }
        if (in_array($output,$numbers)){
            return response()->json([
                'message' => 'The phone number has already been taken',
            ]);
        }if (in_array($usnm,$numbers)){
        return response()->json([
            'message' => 'The username has already been taken',
        ]);
    }else{
        return response()->json([
            'message' => 'Your verification code has been sent',
        ],201);
    }

    }
    public function changePassword(Request $request)
    {
        $output = preg_replace("/^0/", "+254", $request->phone);
        $usera = User::where('phone',$output)->first();
        $codestable = Codes::where('code',$request['code'])->first();
        $tokenResult = $usera->createToken('Personal Access Token');
        $token = $tokenResult->token;
        if ($request->remember_me)
            $token->expires_at = Carbon::now()->addWeeks(1);
        $token->save();
        $usera->update([
            'password'=>Hash::make($request['newpass']),
        ]);
        $codestable->delete();

        return response()->json([
            'access_token' => $tokenResult->accessToken,
            'user' => $usera,
            'message'=>"Password changed successfuly",
            'token_type' => 'Bearer',
            'expires_at' => Carbon::parse(
                $tokenResult->token->expires_at
            )->toDateTimeString()
        ]);
    }
}
