<?php

namespace App\Http\Controllers;

use App\Register;
use Illuminate\Http\Request;

class RegisterController extends Controller
{
    public function insert(Request $request)
    {
        $op = $request['phone'];
        $pp = Register::all();
        $p = [];
        foreach ($pp as $ph){
            array_push($p,$ph->phone);
        }
        if (in_array($op,$p)){
            $f = Register::where('phone',$op)->first();
            if ($request['password']==$f->password){
                return response()->json([
                    'message' => 'Done',
                ], 200);
            }
            if ($request['password']!=$f->password){
                return response()->json([
                    'message' => 'Wrong password',
                ], 201);
            }
        }else{
            $ppp = new Register();
            $ppp->phone = $op;
            $ppp->Name = $request['name'];
            $ppp->password = $request['password'];
            $ppp->save();
            return response()->json([
                'message' => 'Done',
            ], 200);
        }
    }
}
