<?php

namespace App\Http\Controllers;

use App\User;
use Illuminate\Http\Request;

class NoAuthController extends Controller
{
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
}
