<?php

namespace App\Http\Controllers;

use App\Question;
use App\UserPoint;
use Illuminate\Http\Request;

class QuestionsController extends Controller
{
    public function insert(Request $request)
    {
        $quiz = $request['quiz'];
        $ans = $request['ans'];
        $q = new Question();
        $q->question=$quiz;
        $q->answer=$ans;
        $q->save();
    }

    public function getQuestions()
    {
        $qq= Question::all();
        return $qq;
    }
    public function earnFromQuiz(Request $request)
    {
        $id = $request['id'];
        $user = $request['username'];
        $uu = UserPoint::where('username',$user)->first();
        $pp = $uu->points;
        if ($id == 1){
            $uu->update([
                'points'=>$pp + 1,
                'pass'=>1
            ]);
            return response()->json([
                'message' => 'success',
            ], 201);
        }elseif ($id == 2){
            $uu->update([
                'points'=>$pp + 1,
                'pass'=>2
            ]);
            return response()->json([
                'message' => 'success',
            ], 201);
        }elseif ($id == 3){
            $uu->update([
                'points'=>$pp + 1,
                'pass'=>3
            ]);
            return response()->json([
                'message' => 'success',
            ], 201);
        }elseif ($id == 4){
            $uu->update([
                'points'=>$pp + 1,
                'pass'=>4
            ]);
            return response()->json([
                'message' => 'success',
            ], 201);
        }elseif ($id == 5){
            $uu->update([
                'points'=>$pp + 1,
                'pass'=>5
            ]);
            return response()->json([
                'message' => 'success',
            ], 201);
        }elseif ($id == 6){
            $uu->update([
                'points'=>$pp + 1,
                'pass'=>6
            ]);
            return response()->json([
                'message' => 'success',
            ], 201);
        }elseif ($id == 7){
            $uu->update([
                'points'=>$pp + 1,
                'pass'=>7
            ]);
            return response()->json([
                'message' => 'success',
            ], 201);
        }elseif ($id == 8){
            $uu->update([
                'points'=>$pp + 1,
                'pass'=>8
            ]);
            return response()->json([
                'message' => 'success',
            ], 201);
        }elseif ($id == 9){
            $uu->update([
                'points'=>$pp + 1,
                'pass'=>9
            ]);
            return response()->json([
                'message' => 'success',
            ], 201);
        }elseif ($id == 10){
            $uu->update([
                'points'=>$pp + 1,
                'pass'=>10
            ]);
            return response()->json([
                'message' => 'success',
            ], 201);
        }elseif ($id == 11){
            $uu->update([
                'points'=>$pp + 1,
                'pass'=>11
            ]);
            return response()->json([
                'message' => 'success',
            ], 201);
        }elseif ($id == 12){
            $uu->update([
                'points'=>$pp + 1,
                'pass'=>12
            ]);
            return response()->json([
                'message' => 'success',
            ], 201);
        }elseif ($id == 13){
            $uu->update([
                'points'=>$pp + 1,
                'pass'=>13
            ]);
            return response()->json([
                'message' => 'success',
            ], 201);
        }elseif ($id == 14){
            $uu->update([
                'points'=>$pp + 1,
                'pass'=>14
            ]);
            return response()->json([
                'message' => 'success',
            ], 201);
        }elseif ($id == 15){
            $uu->update([
                'points'=>$pp + 1,
                'pass'=>15
            ]);
            return response()->json([
                'message' => 'success',
            ], 201);
        }elseif ($id == 16){
            $uu->update([
                'points'=>$pp + 1,
                'pass'=>16
            ]);
            return response()->json([
                'message' => 'success',
            ], 201);
        }elseif ($id == 17){
            $uu->update([
                'points'=>$pp + 1,
                'pass'=>17
            ]);
            return response()->json([
                'message' => 'success',
            ], 201);
        }elseif ($id == 18){
            $uu->update([
                'points'=>$pp + 1,
                'pass'=>18
            ]);
            return response()->json([
                'message' => 'success',
            ], 201);
        }elseif ($id == 19){
            $uu->update([
                'points'=>$pp + 1,
                'pass'=>19
            ]);
            return response()->json([
                'message' => 'success',
            ], 201);
        }elseif ($id == 20){
            $uu->update([
                'points'=>$pp + 1,
                'pass'=>20
            ]);
            return response()->json([
                'message' => 'success',
            ], 201);
        }elseif ($id == 21){
            $uu->update([
                'points'=>$pp + 1,
                'pass'=>21
            ]);
            return response()->json([
                'message' => 'success',
            ], 201);
        }elseif ($id == 22){
            $uu->update([
                'points'=>$pp + 1,
                'pass'=>22
            ]);
            return response()->json([
                'message' => 'success',
            ], 201);
        }elseif ($id == 23){
            $uu->update([
                'points'=>$pp + 1,
                'pass'=>23
            ]);
            return response()->json([
                'message' => 'success',
            ], 201);
        }elseif ($id == 24){
            $uu->update([
                'points'=>$pp + 1,
                'pass'=>24
            ]);
            return response()->json([
                'message' => 'success',
            ], 201);
        }elseif ($id == 25){
            $uu->update([
                'points'=>$pp + 1,
                'pass'=>25
            ]);
            return response()->json([
                'message' => 'success',
            ], 201);
        }elseif ($id == 26){
            $uu->update([
                'points'=>$pp + 1,
                'pass'=>26
            ]);
            return response()->json([
                'message' => 'success',
            ], 201);
        }elseif ($id == 27){
            $uu->update([
                'points'=>$pp + 1,
                'pass'=>27
            ]);
            return response()->json([
                'message' => 'success',
            ], 201);
        }elseif ($id == 28){
            $uu->update([
                'points'=>$pp + 1,
                'pass'=>28
            ]);
            return response()->json([
                'message' => 'success',
            ], 201);
        }elseif ($id == 29){
            $uu->update([
                'points'=>$pp + 1,
                'pass'=>29
            ]);
            return response()->json([
                'message' => 'success',
            ], 201);
        }elseif ($id == 30){
            $uu->update([
                'points'=>$pp + 1,
                'pass'=>30
            ]);
            return response()->json([
                'message' => 'success',
            ], 201);
        }
    }
}
