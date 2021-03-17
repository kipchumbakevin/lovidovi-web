<?php

namespace App\Http\Controllers;

use App\AddFood;
use App\AddLifestyle;
use App\AddPartner;
use App\Celebrity;
use App\CheckCeleb;
use App\CheckFood;
use App\CheckLifestyle;
use App\CheckPartner;
use App\Food;
use App\FriendCeleb;
use App\FriendFood;
use App\FriendLifestyle;
use App\FriendPartner;
use App\Lifestyle;
use App\Partner;
use App\SelfCelebrity;
use App\ThisThatUser;
use Illuminate\Http\Request;

class SelfEvaluationController extends Controller
{
    public function selfLife(Request $request)
    {
        $selfL = new Lifestyle();
        $key = $request['key'];
        $ggg = AddLifestyle::where('id',$request['categoryId'])->first();
        $user = ThisThatUser::where('phone',$request['phone'])->first();
        $selfL->category_id = $request['categoryId'];
        $selfL->selfPhone = $request['phone'];
        $selfL->selfChoice = $request['choice'];
        $selfL->save();
        if ($key == 1){
            $ggg->update([
               'pickA'=>$ggg->pickA + 1,
               'total'=>$ggg->total + 1
            ]);
        }else if ($key == 2){
            $ggg->update([
                'pickB'=>$ggg->pickA + 1,
                'total'=>$ggg->total + 1
            ]);
        }
        $user->update([
           'lifestyle'=>$request['categoryId']
        ]);
        if ($request['categoryId'] == 30){
            $user->update([
                'complete'=> 2
            ]);
        }
        return response()->json([
            'message' => 'Response recorded',
        ], 201);
    }
    public function selfFood(Request $request)
    {
        $selfL = new Food();
        $key = $request['key'];
        $ggg = AddFood::where('id',$request['categoryId'])->first();
        $user = ThisThatUser::where('phone',$request['phone'])->first();
        $selfL->category_id = $request['categoryId'];
        $selfL->selfPhone = $request['phone'];
        $selfL->selfChoice = $request['choice'];
        $selfL->save();
        if ($key == 1){
            $ggg->update([
                'pickA'=>$ggg->pickA + 1,
                'total'=>$ggg->total + 1
            ]);
        }else if ($key == 2){
            $ggg->update([
                'pickB'=>$ggg->pickA + 1,
                'total'=>$ggg->total + 1
            ]);
        }
        $user->update([
            'food'=>$request['categoryId']
        ]);
        if ($request['categoryId'] == 30){
            $user->update([
                'complete'=> 3
            ]);
        }
        return response()->json([
            'message' => 'Response recorded',
        ], 201);
    }
    public function selfPartner(Request $request)
    {
        $selfL = new Partner();
        $key = $request['key'];
        $ggg = AddPartner::where('id',$request['categoryId'])->first();
        $user = ThisThatUser::where('phone',$request['phone'])->first();
        $selfL->category_id = $request['categoryId'];
        $selfL->selfPhone = $request['phone'];
        $selfL->selfChoice = $request['choice'];
        $selfL->save();
        if ($key == 1){
            $ggg->update([
                'pickA'=>$ggg->pickA + 1,
                'total'=>$ggg->total + 1
            ]);
        }else if ($key == 2){
            $ggg->update([
                'pickB'=>$ggg->pickA + 1,
                'total'=>$ggg->total + 1
            ]);
        }
        $user->update([
            'partner'=>$request['categoryId']
        ]);
		if ($request['categoryId'] == 10){
            $user->update([
                'complete'=> 5
            ]);
        }
        return response()->json([
            'message' => 'Response recorded',
        ], 201);
    }
    public function selfCeleb(Request $request)
    {
        $selfL = new SelfCelebrity();
        $key = $request['key'];
        $ggg = Celebrity::where('id',$request['categoryId'])->first();
        $user = ThisThatUser::where('phone',$request['phone'])->first();
        $selfL->category_id = $request['categoryId'];
        $selfL->selfPhone = $request['phone'];
        $selfL->selfChoice = $request['choice'];
        $selfL->save();
        if ($key == 1){
            $ggg->update([
                'pickA'=>$ggg->pickA + 1,
                'total'=>$ggg->total + 1
            ]);
        }else if ($key == 2){
            $ggg->update([
                'pickB'=>$ggg->pickA + 1,
                'total'=>$ggg->total + 1
            ]);
        }
        $user->update([
            'celebrity'=>$request['categoryId']
        ]);
        if ($request['categoryId'] == 33){
            $user->update([
                'complete'=> 4
            ]);
        }
        return response()->json([
            'message' => 'Response recorded',
        ], 201);
    }

    public function specificLifestyle(Request $request)
    {
        $spe = AddLifestyle::where('id',$request['id'])->first();
        return $spe;
    }
    public function specificFood(Request $request)
    {
        $spe = AddFood::where('id',$request['id'])->first();
        return $spe;
    }
    public function specificCeleb(Request $request)
    {
        $spe = Celebrity::where('id',$request['id'])->first();
        return $spe;
    }
    public function specificPartner(Request $request)
    {
        $spe = AddPartner::where('id',$request['id'])->first();
        return $spe;
    }

    public function fetchLifestyle(Request $request)
    {
        $frie = CheckLifestyle::where('evaluateePhone',$request['phone'])->latest()->get();
        return $frie;
    }
    public function fetchFood(Request $request)
    {
        $frie = CheckFood::where('evaluateePhone',$request['phone'])->latest()->get();
        return $frie;
    }
    public function fetchPartner(Request $request)
    {
        $frie = CheckPartner::where('evaluateePhone',$request['phone'])->latest()->get();
        return $frie;
    }
    public function fetchCeleb(Request $request)
    {
        $frie = CheckCeleb::where('evaluateePhone',$request['phone'])->latest()->get();
        return $frie;
    }

    public function fetchfLifestyle(Request $request)
    {
        $frie = CheckLifestyle::where('evaluatorPhone',$request['phone'])->latest()->get();
        return $frie;
    }
    public function fetchfFood(Request $request)
    {
        $frie = CheckFood::where('evaluatorPhone',$request['phone'])->latest()->get();
        return $frie;
    }
    public function fetchfPartner(Request $request)
    {
        $frie = CheckPartner::where('evaluatorPhone',$request['phone'])->latest()->get();
        return $frie;
    }
    public function fetchfCeleb(Request $request)
    {
        $frie = CheckCeleb::where('evaluatorPhone',$request['phone'])->latest()->get();
        return $frie;
    }

}
