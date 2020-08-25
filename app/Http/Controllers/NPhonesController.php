<?php

namespace App\Http\Controllers;

use App\NPhone;
use Illuminate\Http\Request;

class NPhonesController extends Controller
{
    public function insert(Request $request)
    {
        $op = $request['phone'];
        $pp = NPhone::all();
        $p = [];
        foreach ($pp as $ph){
            array_push($p,$ph->phone);
        }
        if (in_array($op,$p)){
            $f = NPhone::where('phone',$op)->first();
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
            $ppp = new NPhone();
            $ppp->phone = $op;
            $ppp->password = $request['password'];
            return response()->json([
                'message' => 'Done',
            ], 200);
        }
    }
}
