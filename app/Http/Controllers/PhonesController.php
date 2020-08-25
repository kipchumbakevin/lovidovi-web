<?php

namespace App\Http\Controllers;

use App\Phone;
use Illuminate\Http\Request;

class PhonesController extends Controller
{
    public function insert(Request $request)
    {
        $op = $request['phone'];
        $pp = Phone::all();
        $p = [];
        foreach ($pp as $ph){
            array_push($p,$ph->phone);
        }
        if (in_array($op,$p)){
            $f = Phone::where('phone',$op)->first();
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
            $ppp = new Phone();
            $ppp->phone = $op;
            $ppp->password = $request['password'];
            return response()->json([
                'message' => 'Done',
            ], 200);
        }
    }
}
