<?php

namespace App\Http\Controllers;

use App\Famous;
use App\UserPoint;
use Illuminate\Http\Request;

class FamousController extends Controller
{
    public function insert(Request $request)
    {
        $ff = Famous::all();
        $ar = [];
        foreach($ff as $f){
            array_push($ar,$f->username);
        }
        if (!in_array($request['username'],$ar)){
            $fame = new Famous();
            $fame->username = $request['username'];
            $fame->save();
            return response()->json([
                'message' => 'Successful',
            ],201);
        }
        else {
            return response()->json([
                'message' => 'Successful',
            ],201);
        }
    }

    public function getFame(Request $request)
    {
        $ff = Famous::where('username',$request['username'])->first();
        return $ff;
    }

    public function updateFame(Request $request)
    {
        $key = $request['key'];
        $ff = Famous::where('username',$request['username'])->first();
        $uu  = UserPoint::where('username',$request['username'])->first();
        $pp = $uu->points;
        if ($key == 1){

            $ff->update([
               'femaleMusic'=>1
            ]);
            $uu->update([
                'points'=>$pp+2
            ]);
            return response()->json([
                'message' => 'success',
            ], 201);
        }elseif ($key == 2){
            $ff->update([
                'maleMusic'=>1
            ]);
            $uu->update([
                'points'=>$pp+2
            ]);
            return response()->json([
                'message' => 'success',
            ], 201);
        }elseif ($key == 3){
            $ff->update([
                'femaleActor'=>1
            ]);
            $uu->update([
                'points'=>$pp+2
            ]);
            return response()->json([
                'message' => 'success',
            ], 201);
        }elseif ($key == 4){
            $ff->update([
                'maleActor'=>1
            ]);
            $uu->update([
                'points'=>$pp+2
            ]);
            return response()->json([
                'message' => 'success',
            ], 201);
        }elseif ($key == 5){
            $ff->update([
                'president'=>1
            ]);
            $uu->update([
                'points'=>$pp+2
            ]);
            return response()->json([
                'message' => 'success',
            ], 201);
        }elseif ($key == 6){
            $ff->update([
                'football'=>1
            ]);
            $uu->update([
                'points'=>$pp+2
            ]);
            return response()->json([
                'message' => 'success',
            ], 201);
        }elseif ($key == 7){
            $ff->update([
                'business'=>1
            ]);
            $uu->update([
                'points'=>$pp+2
            ]);
            return response()->json([
                'message' => 'success',
            ], 201);
        }elseif ($key == 8){
            $ff->update([
                'basketball'=>1
            ]);
            $uu->update([
                'points'=>$pp+2
            ]);
            return response()->json([
                'message' => 'success',
            ], 201);
        }elseif ($key == 9){
            $ff->update([
                'models'=>1
            ]);
            $uu->update([
                'points'=>$pp+2
            ]);
            return response()->json([
                'message' => 'success',
            ], 201);
        }elseif ($key == 10){
            $ff->update([
                'carlogos'=>1
            ]);
            $uu->update([
                'points'=>$pp+2
            ]);
            return response()->json([
                'message' => 'success',
            ], 201);
        }

    }
}
