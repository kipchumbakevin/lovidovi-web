<?php

namespace App\Http\Controllers;

use App\UserPoint;
use Illuminate\Http\Request;

class UserPointsController extends Controller
{
    public function register(Request $request)
    {
        $usename = $request['username'];
        $users = UserPoint::where('username',$usename)->first();
        
        if ($users == null){
            $use = new UserPoint();
            $use->username = $usename;
            $use->pin = $request['pin'];
            $use->save();
            return response()->json([
                'message' => 'Successful',
            ], 201);
        }elseif ($users != null){
            $fu = UserPoint::where('username',$usename)->first();
            if ($fu->pin == $request['pin']){
                return response()->json([
                    'message' => 'Successful',
                ], 201);
            }else{
                return response()->json([
                    'message' => 'Wrong pin',
                ], 200);
            }
        }else{
            return response()->json([
                'message' => 'Server error',
            ]);
        }
    }
    public function freeCoins(Request $request)
    {
        $user = UserPoint::where('username',$request['username'])->first();
        $user->update([
            'points'=>($user->points)+1
        ]);
        return response()->json([
            'message' => 'done',
        ], 201);
    }

    public function getUser(Request $request)
    {
        $user = UserPoint::where('username',$request['username'])->first();
        return $user;
    }

    public function earnFromGuess(Request $request)
    {
        $key = $request['key'];
        $user = $request['username'];
        $uu = UserPoint::where('username',$user)->first();
        $pp = $uu->points;
        if ($key == 1){
            $uu->update([
                'points'=>$pp + 1,
                'actor'=>1
            ]);
            return response()->json([
                'message' => 'success',
            ], 201);
        }elseif ($key == 2){
            $uu->update([
                'points'=>$pp + 1,
                'billion'=>1
            ]);
            return response()->json([
                'message' => 'success',
            ], 201);
        }elseif ($key == 3){
            $uu->update([
                'points'=>$pp + 1,
                'convict'=>1
            ]);
            return response()->json([
                'message' => 'success',
            ], 201);
        }elseif ($key == 4){
            $uu->update([
                'points'=>$pp + 1,
                'virgin'=>1
            ]);
            return response()->json([
                'message' => 'success',
            ], 201);
        }elseif ($key == 5){
            $uu->update([
                'points'=>$pp + 1,
                'student'=>1
            ]);
            return response()->json([
                'message' => 'success',
            ], 201);
        }elseif ($key == 6){
            $uu->update([
                'points'=>$pp + 1,
                'car'=>1
            ]);
            return response()->json([
                'message' => 'success',
            ], 201);
        }elseif ($key == 7){
            $uu->update([
                'points'=>$pp + 1,
                'medicine'=>1
            ]);
            return response()->json([
                'message' => 'success',
            ], 201);
        }elseif ($key == 8){
            $uu->update([
                'points'=>$pp + 1,
                'plastic'=>1
            ]);
            return response()->json([
                'message' => 'success',
            ], 201);
        }elseif ($key == 9){
            $uu->update([
                'points'=>$pp + 1,
                'african'=>1
            ]);
            return response()->json([
                'message' => 'success',
            ], 201);
        }elseif ($key == 10){
            $uu->update([
                'points'=>$pp + 1,
                'jobless'=>1
            ]);
            return response()->json([
                'message' => 'success',
            ], 201);
        }elseif ($key == 11){
            $uu->update([
                'points'=>$pp + 1,
                'pet'=>1
            ]);
            return response()->json([
                'message' => 'success',
            ], 201);
        }
    }
}
