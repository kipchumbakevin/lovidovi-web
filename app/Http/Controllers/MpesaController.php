<?php

namespace App\Http\Controllers;

use App\C2BModel;
use Illuminate\Http\Request;

class MpesaController extends Controller
{
    public function index(Request $request)
    {
        //"TransactionType" => "Hehe",
        //"TransID" => "MGR66HFTd7",
        //"TransTime" => "3798798ww",
        //"TransAmount" => "15",
        //"BusinessShortCode" => "46663",
        //"BillRefNumber" => "tutu",
        //"InvoiceNumber" => "wsww",
        //"OrgAccountBalance" => "888844",
        //"ThirdPartyTransID" => "4888484",
        //"MSISDN" => "254726712505",
        //"FirstName" => "Hillary",
        //"MiddleName" => "H",
        //"LastName" => "Tao"

        $MpesaCode = $request["TransID"];
        $amount = $request["TransAmount"];
        $FirstName = isset($request["FirstName"]) ? $request["FirstName"] : "";
        $LastName = isset($request["LastName"]) ? $request["LastName"] : "";
        $MiddleName = isset($request["MiddleName"]) ? $request["MiddleName"] : "";
        $phone = $request["MSISDN"];
        $accountNumber = strtoupper($request['BillRefNumber']);
        $fullName = $FirstName." ".$MiddleName." ".$LastName;

        $C2B = C2BModel::create([
            'mpesa_code'=>$MpesaCode,
            'phone' => $phone,
            'account_number'=>$accountNumber,
            'name'=>$fullName
        ]);
    }

    public function confirmation(Request $request)
    {

    }
}
