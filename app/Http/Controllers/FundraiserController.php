<?php

namespace App\Http\Controllers;

use AfricasTalking\SDK\Payments;
use App\Contribution;
use App\Fundraiser;
use App\Payment;
use App\Register;
use Illuminate\Http\Request;
use phpseclib\Crypt\Random;

class FundraiserController extends Controller
{
    public function createFundraiser(Request $request)
    {
        $fund = new Fundraiser();
        $titl = $request['title'];
        $userp = $request['phone'];
        $pass = $request['passcode'];
        $idd = rand(1000000,9999999);
        $us = Register::where('phone',$userp)->first();
        $fund->title=$titl;
        $fund->passcode=$pass;
        $fund->user_id=$us->id;
        $fund->pin=$idd;
        $fund->save();
        $new_item = Fundraiser::orderby('created_at', 'desc')->first();
        $pay = new Payment();
        $pay->fund_id=$new_item->id;
        $pay->mpesa_phone = $request['mpesaPhone'];
        $pay->mpesa_account_number = $request['mpesaPaybillAccount'];
        $pay->mpesa_paybill = $request['mpesaPaybill'];
        $pay->bank_account = $request['bankAccount'];
        $pay->paypal_account = $request['paypalAccount'];
        $pay->save();
        return response()->json([
            'message' => 'Successful',
        ],201);
    }

    public function deleteFundraiser(Request $request)
    {
        $iid = $request['id'];
        $ff = Fundraiser::where('id',$iid)->first();
        $pp = Payment::where('fund_id',$iid)->first();
        $cc = Contribution::where('fund_id',$iid)->get();
        $ff->delete();
        $pp->delete();
        foreach ($cc as $c){
            $c->delete();
        }
        return response()->json([
            'message' => 'Successful',
        ],201);
    }

    public function fetchOwn(Request $request)
    {
		$rr = Register::where('phone',$request['phone'])->first();
        $myn = Fundraiser::where('user_id',$rr->id)->with('owner')
            ->with('contribution')->with('payments')->latest()->get();
        return $myn;
    }

    public function fetchById(Request $request)
    {
        $searched = Fundraiser::where('pin',$request['id'])->with('owner')
            ->with('contribution')->with('payments')->latest()->get();
			return $searched;
    }
    public function fetchFundraisers(Request $request)
    {
        $cotralls = Fundraiser::with('owner')
            ->with('contribution')->with('payments')->latest()->get();
        return $cotralls;
    }
    public function fetchContributions(Request $request)
    {
        $cotrall = Contribution::where('fund_id',$request['id'])->latest()->get();
        return $cotrall;
    }

    public function fetchTotal(Request $request)
    {
        $notif = Contribution::where('fund_id',$request['id'])->sum('amount');
        return response()->json([
            'num' => $notif,
        ],201);
    }

    public function seeContributions(Request $request)
    {
        $ccc = Contribution::where('fund_id',$request['id'])->get();
        foreach ($ccc as $cx){
            $cx->seen = true;
            $cx->save();
        }
    }
}
