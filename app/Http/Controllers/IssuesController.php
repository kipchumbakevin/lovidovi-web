<?php

namespace App\Http\Controllers;

use App\Helper;
use App\Issue;
use Illuminate\Http\Request;

class IssuesController extends Controller
{
    public function addIssue(Request $request)
    {
        $issue = new Issue();
        $issue->phone=$request['phone'];
        $issue->shortD=$request['shortD'];
        $issue->longD=$request['longD'];
        $issue->gender=$request['gender'];
        $issue->country=$request['country'];
        $issue->save();
        return response()->json([
            'message' => 'Added successfully',
        ],201);
    }
    public function fetchIssues(Request $request)
    {
        $iss = Issue::orderBy('country')->latest()->get();
        return $iss;
    }
    public function fetchMine(Request $request)
    {
        $mine = Issue::where('phone',$request['phone'])->latest()->get();
        return $mine;
    }
	public function fetchC(Request $request)
    {
        $mine = Issue::where('country',$request['country'])->latest()->get();
        return $mine;
    }
    public function addHelper(Request $request)
    {
		$arr = [];
		$h = Helper::where('issue_id',$request['id'])->get();
		foreach($h as $hu){
			array_push($arr,$hu->phone);
		}
		if(in_array($request['phone'],$arr)){
			return response()->json([
            'message' => 'Be blessed. Your have already submitted your number. Wait for a call or text',
        ],201);
		}
		else {
        $help = new Helper();
        $help->issue_id = $request['id'];
        $help->phone = $request['phone'];
		$help->save();
        return response()->json([
            'message' => 'Be blessed. Your phone number has been shared. Wait for a call or text',
        ],201);
		}
    }
    public function fetchHelpers(Request $request)
    {
        $helpers = Helper::where('issue_id',$request['id'])->latest()->get();
        return $helpers;
    }
    public function deleteIssue(Request $request)
    {
        $iss = Issue::where('id',$request['id'])->first();
        $help = Helper::where('issue_id',$request['id'])->all();
        $iss->delete();
        foreach ($help as $h){
            $h->delete();
        }
    }
}
