<?php

namespace App\Http\Controllers;

use App\Casino;
use Illuminate\Http\Request;

class CasinoController extends Controller
{
    public function insert(Request $request)
    {
        $casino = Casino::where('phone',$request['phone'])->first();
        if ($casino != null){
            $casino->update([
                'trials'=>3,
                'amount'=>$request['amount']
            ]);
        }else{
            $cas = new Casino();
            $cas->phone = $request['phone'];
            $cas->trials=3;
            $cas->amount=$request['amount'];
            $cas->save();
        }
    }

    public function getCasino(Request $request)
    {
        $cc = Casino::where('phone',$request['phone'])->first();
        if ($cc != null){
            $num = $cc->trials;
        }else{
            $num = 0;
        }
        return response()->json([
            'num' => $num,
        ],201);

    }

    public function reduceTrials(Request $request)
    {
        $cc = Casino::where('phone',$request['phone'])->first();
        $cc->update([
            'trials'=>($cc->trials)-1
        ]);
    }
}
