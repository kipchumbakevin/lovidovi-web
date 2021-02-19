<?php

namespace App\Http\Controllers;

use App\HighScore;
use Illuminate\Http\Request;

class HighscoreController extends Controller
{
    public function insert(Request $request)
    {
        $hh = HighScore::all();
        foreach ($hh as $h){
            $h->delete();
        }
        $high = new HighScore();
        $high->username = $request['username'];
        $high->score = $request['score'];
        $high->save();
    }

    public function getHigh()
    {
        $h = HighScore::get(['username','score']);
        return $h;
    }
}
