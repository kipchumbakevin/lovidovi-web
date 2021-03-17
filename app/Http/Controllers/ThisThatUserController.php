<?php

namespace App\Http\Controllers;

use AfricasTalking\SDK\AfricasTalking;
use App\ThisCode;
use App\ThisThatUser;
use Exception;
use Illuminate\Http\Request;

class ThisThatUserController extends Controller
{
    public function insert(Request $request)
    {
        $op = $request['phone'];
        $f = ThisThatUser::where('phone',$op)->first();
        $pp = ThisThatUser::all();
        $p = [];
        foreach ($pp as $ph){
            array_push($p,$ph->phone);
        }
        if (in_array($op,$p)&&$request['pin']==$f->pin){

            return response()->json([
                'message' => 'Success',
            ], 201);
        }
        if (in_array($op,$p)&& $request['password']!=$f->password){
            return response()->json([
                'message' => 'Wrong password',
            ], 200);
        }
        if(!in_array($op,$p)){
            $ppp = new ThisThatUser();
            $ppp->phone = $op;
            $ppp->pin = $request['pin'];
            $ppp->save();
            return response()->json([
                'message' => 'Success',
            ], 201);
        }
    }

    public function fetchUser(Request $request)
    {
        $user = ThisThatUser::where('phone',$request['phone'])->first();
		if ($user == null){
			return response()->json([
                'message' => 'User not registered',
            ], 404);
		}else {
          return $user;
		}
    }
}
