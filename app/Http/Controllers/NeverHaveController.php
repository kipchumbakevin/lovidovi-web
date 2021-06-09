<?php

namespace App\Http\Controllers;

use App\Never;
use App\ThisThatUser;
use Illuminate\Http\Request;

class NeverHaveController extends Controller
{
    public function insert(Request $request)
    {
        $never = new Never();
        $never->title=$request['never'];
        $never->save();
    }
    public function fetch()
    {
        $would = Never::all();
        return $would;
    }
	public function fetchS(Request $request)
    {
        $would = Never::where('id',$request['id'])->first();
        return $would;
    }
    public function answer(Request $request)
    {
        $key = $request['key'];
        $nev = Never::where('id',$request['id'])->first();
        $use = ThisThatUser::where('phone',$request['phone'])->first();
        if ($key == 1){
            $nev->update([
                'pickA'=>$nev->pickA + 1
            ]);
        }else if ($key == 2){
            $nev->update([
                'pickB'=>$nev->pickB + 1,
            ]);
        }
        $nev->update([
            'total'=>$nev->total + 1
        ]);
        $use->update([
           'never'=>$request['id']
        ]);
        return response()->json([
            'message' => 'Done',
        ],201);
    }
}
