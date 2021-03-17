<?php

namespace App\Http\Controllers;

use App\ThisThatUser;
use App\WouldYou;
use Illuminate\Http\Request;

class WouldYouController extends Controller
{
    public function insert(Request $request)
    {
        $wo = new WouldYou();
        $wo->optionA = $request['optionA'];
        $wo->optionB = $request['optionB'];
        $wo->save();
    }

    public function fetch()
    {
        $would = WouldYou::all();
        return $would;
    }
	public function fetchSp(Request $request)
    {
        $would = WouldYou::where('id',$request['id'])->first();
        return $would;
    }
	
    public function answer(Request $request)
    {
        $key = $request['key'];
        $would = WouldYou::where('id',$request['id'])->first();
        $use = ThisThatUser::where('phone',$request['phone'])->first();
        if ($key == 1){
          $would->update([
              'pickA'=>$would->pickA + 1
          ]);
        }else if ($key == 2){
            $would->update([
                'pickB'=>$would->pickB + 1,
            ]);
        }
        $would->update([
            'total'=>$would->total + 1
        ]);
        $use->update([
            'would'=>$request['id']
        ]);
        return response()->json([
            'message' => 'Done',
        ],201);
    }
}
