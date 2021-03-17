<?php

namespace App\Http\Controllers;

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
use Illuminate\Http\Request;

class FriendEvaluationController extends Controller
{
    public function friendLife(Request $request)
    {
        $fse = Lifestyle::where('selfPhone',$request['friendPhone'])->where('category_id',$request['categoryId'])->first();
        $checkL = CheckLifestyle::where('evaluatorPhone',$request['phone'])->
            where('evaluateePhone',$request['friendPhone'])->first();
        $check = FriendLifestyle::where('self_id', $fse->id)->where('evaluatorPhone',$request['phone'])->
        where('evaluateePhone',$request['friendPhone'])->first();
        if ($check != null){
            return response()->json([
                'message' => 'You already evaluated your friend in this section',
            ], 201);
        }else {
            $selfL = new FriendLifestyle();
            $selfL->self_id = $fse->id;
            $selfL->category_id = $request['categoryId'];
            $selfL->evaluatorPhone = $request['phone'];
            $selfL->evaluateePhone = $request['friendPhone'];
            $selfL->evaluatorChoice = $request['choice'];
            if ($checkL == null){
                $ch = new CheckLifestyle();
                $ch->self_id = 1;
                $ch->evaluatorPhone = $request['phone'];
                $ch->evaluateePhone = $request['friendPhone'];
                $ch->save();
            }
            $selfL->save();
            return response()->json([
                'message' => 'Response recorded',
            ], 201);
        }
    }
    public function friendFood(Request $request)
    {
        $fse = Food::where('selfPhone',$request['friendPhone'])->where('category_id',$request['categoryId'])->first();
        $checkL = CheckFood::where('evaluatorPhone',$request['phone'])->
        where('evaluateePhone',$request['friendPhone'])->first();
        $check = FriendFood::where('self_id', $fse->id)->where('evaluatorPhone',$request['phone'])->
        where('evaluateePhone',$request['friendPhone'])->first();
        if ($check != null){
            return response()->json([
                'message' => 'You already evaluated your friend in this section',
            ], 201);
        }else {
            $selfL = new FriendFood();
            $selfL->self_id = $fse->id;
            $selfL->category_id = $request['categoryId'];
            $selfL->evaluatorPhone = $request['phone'];
            $selfL->evaluateePhone = $request['friendPhone'];
            $selfL->evaluatorChoice = $request['choice'];
            if ($checkL == null){
                $ch = new CheckFood();
                $ch->self_id = 2;
                $ch->evaluatorPhone = $request['phone'];
                $ch->evaluateePhone = $request['friendPhone'];
                $ch->save();
            }
            $selfL->save();
            return response()->json([
                'message' => 'Response recorded',
            ], 201);
        }
    }
    public function friendPartner(Request $request)
    {
        $fse = Partner::where('selfPhone',$request['friendPhone'])->where('category_id',$request['categoryId'])->first();
        $checkL = CheckPartner::where('evaluatorPhone',$request['phone'])->
        where('evaluateePhone',$request['friendPhone'])->first();
        $check = FriendPartner::where('self_id', $fse->id)->where('evaluatorPhone',$request['phone'])->
        where('evaluateePhone',$request['friendPhone'])->first();
        if ($check != null){
            return response()->json([
                'message' => 'You already evaluated your friend in this section',
            ], 201);
        }else {
            $selfL = new FriendPartner();
            $selfL->self_id = $fse->id;
            $selfL->category_id = $request['categoryId'];
            $selfL->evaluatorPhone = $request['phone'];
            $selfL->evaluateePhone = $request['friendPhone'];
            $selfL->evaluatorChoice = $request['choice'];
            if ($checkL == null){
                $ch = new CheckPartner();
                $ch->self_id = 4;
                $ch->evaluatorPhone = $request['phone'];
                $ch->evaluateePhone = $request['friendPhone'];
                $ch->save();
            }
            $selfL->save();
            return response()->json([
                'message' => 'Response recorded',
            ], 201);
        }
    }
    public function friendCeleb(Request $request)
    {
        $checkL = CheckFood::where('evaluatorPhone',$request['phone'])->
        where('evaluateePhone',$request['friendPhone'])->first();
        $fse = SelfCelebrity::where('selfPhone',$request['friendPhone'])->where('category_id',$request['categoryId'])->first();
        $check = FriendCeleb::where('self_id', $fse->id)->where('evaluatorPhone',$request['phone'])->
        where('evaluateePhone',$request['friendPhone'])->first();
        if ($check != null){
            return response()->json([
                'message' => 'You already evaluated your friend in this section',
            ], 201);
        }else {
            $selfL = new FriendCeleb();
            $selfL->self_id = $fse->id;
            $selfL->category_id = $request['categoryId'];
            $selfL->evaluatorPhone = $request['phone'];
            $selfL->evaluateePhone = $request['friendPhone'];
            $selfL->evaluatorChoice = $request['choice'];
            if ($checkL == null){
                $ch = new CheckCeleb();
                $ch->self_id = 3;
                $ch->evaluatorPhone = $request['phone'];
                $ch->evaluateePhone = $request['friendPhone'];
                $ch->save();
            }
            $selfL->save();
            return response()->json([
                'message' => 'Response recorded',
            ], 201);
        }
    }
    public function fetchLifestyle(Request $request)
    {
        $frie = FriendLifestyle::where('evaluateePhone',$request['phone'])->where('evaluatorPhone',$request['friendPhone'])->with('self')->with('category')->latest()->get();
        return $frie;
    }
    public function fetchFood(Request $request)
    {
        $frie = FriendFood::where('evaluateePhone',$request['phone'])->where('evaluatorPhone',$request['friendPhone'])->with('self')->with('category')->latest()->get();
        return $frie;
    }
    public function fetchPartner(Request $request)
    {
        $frie = FriendPartner::where('evaluateePhone',$request['phone'])->where('evaluatorPhone',$request['friendPhone'])->with('self')->with('category')->latest()->get();
        return $frie;
    }
    public function fetchCeleb(Request $request)
    {
        $frie = FriendCeleb::where('evaluateePhone',$request['phone'])->where('evaluatorPhone',$request['friendPhone'])->with('self')->with('category')->latest()->get();
        return $frie;
    }

    public function fetchfLifestyle(Request $request)
    {
        $frie = FriendLifestyle::where('evaluatorPhone',$request['phone'])->where('evaluateePhone',$request['friendPhone'])->with('self')->with('category')->latest()->get();
        return $frie;
    }
    public function fetchfFood(Request $request)
    {
        $frie = FriendFood::where('evaluatorPhone',$request['phone'])->where('evaluateePhone',$request['friendPhone'])->with('self')->with('category')->latest()->get();
        return $frie;
    }
    public function fetchfPartner(Request $request)
    {
        $frie = FriendPartner::where('evaluatorPhone',$request['phone'])->where('evaluateePhone',$request['friendPhone'])->with('self')->with('category')->latest()->get();
        return $frie;
    }
    public function fetchfCeleb(Request $request)
    {
        $frie = FriendCeleb::where('evaluatorPhone',$request['phone'])->where('evaluateePhone',$request['friendPhone'])->with('self')->with('category')->latest()->get();
        return $frie;
    }
}
