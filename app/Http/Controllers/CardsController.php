<?php

namespace App\Http\Controllers;

use App\Cards;
use Illuminate\Http\Request;
use function Sodium\crypto_box_publickey_from_secretkey;

class CardsController extends Controller
{
    public function insert(Request $request)
    {
        $cards = Cards::where('phone',$request['phone'])->first();
        if ($cards != null){
            $cards->update([
                'trials'=>3,
                'amount'=>$request['amount']
            ]);
        }else{
            $cas = new Cards();
            $cas->phone = $request['phone'];
            $cas->trials=3;
            $cas->amount=$request['amount'];
            $cas->save();
        }
        return response()->json([
            'message' => 'success',
        ]);
    }
    public function reduceTrials(Request $request)
    {
        $cc = Cards::where('phone',$request['phone'])->first();
        $cc->update([
            'trials'=>($cc->trials)-1
        ]);
        return response()->json([
            'message' => 'sucess',
        ]);
    }
    public function getCards(Request $request)
    {
        $cc = Cards::where('phone', $request['phone'])->first();
        if ($cc != null) {
            $num = $cc->trials;
        } else {
            $num = 0;
        }
        return response()->json([
            'num' => $num,
        ]);
    }

    public function reduceBonus(Request $request)
    {
        $bonus = Cards::where('phone',$request['phone'])->first();
        $bonus->update([
            'bonus'=>($bonus->bonus)-1
        ]);
    }
}
