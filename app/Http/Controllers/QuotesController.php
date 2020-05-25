<?php

namespace App\Http\Controllers;

use App\Quotes;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class QuotesController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth:api');
    }
    public function insert(Request $request)
    {
        $qq = new Quotes();
        $qq->quote = $request->quote;
        $qq->sender_id = Auth::user()->id;
        $qq->save();
        return response()->json([
            'message' => 'Quote added.',
        ],201);
    }

    public function fetchQuotes()
    {
        $qqq = Quotes::latest()->get();
        return $qqq;
    }
}
