<?php

namespace App\Http\Controllers;

use App\Contribution;
use App\Register;
use Illuminate\Http\Request;

class ContributionsController extends Controller
{
    public function insert(Request $request)
    {
        $pp = $request['phone'];
        $contri = Contribution::where('fund_id',$request['id'])->get();
        $arry = [];
        foreach ($contri as $co){
            array_push($arry,$co->phone);
        }
        $us = Register::where('phone',$pp)->first();
        if (in_array($pp,$arry)){
            $ct = Contribution::where('fund_id',$request['id'])->where('phone',$pp)->first();
            $v = $ct->amount;
            $ct->amount = $request['amount']+$v;
            $ct->save();
            return response()->json([
                'message' => 'Successful',
            ],201);
        }else{
            $ctt = new Contribution();
            $ctt->name = $us->Name;
            $ctt->fund_id = $request['id'];
            $ctt->amount=$request['amount'];
            $ctt->phone=$pp;
            $ctt->save();
            return response()->json([
                'message' => 'Successful',
            ],201);
        }
    }
}
