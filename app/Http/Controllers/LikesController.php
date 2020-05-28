<?php

namespace App\Http\Controllers;

use App\Like;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class LikesController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth:api');
    }

    public function insert(Request $request)
    {
        $all = Like::all();
        $arr = [];
        $lik = new Like();
        $lik->like="Like";
        $lik->username = Auth::user()->username;
        $lik->quote_id = $request->quoteId;
        foreach ($all as $al){
            array_push($arr,$al->username);
        }
        if (!in_array(Auth::user()->username,$arr)){
            $lik->save();
            return response()->json([
                'message' => 'Liked.',
            ],200);
        }
        else{
            return response()->json([
                'message' => 'You have liked this quote.',
            ],201);
        }
    }

    public function fetchlikes(Request $request)
    {
        $likes = Like::where('quote_id',$request->quoteId)->latest()->get();
        return $likes;
    }
    public function fetchlikescount(Request $request)
    {
        $likescount = Like::where('quote_id',$request->quoteId)->count();
        return [
            'likescount'=>$likescount
            ];
    }
}
