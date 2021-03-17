<?php

namespace App\Http\Controllers;

use App\AddFood;
use App\AddLifestyle;
use App\AddPartner;
use App\CelebImage;
use App\Celebrity;
use App\Lifestyle;
use Illuminate\Http\Request;

class CelebritiesController extends Controller
{
    public function insert(Request $request)
    {
        $cel = new Celebrity();
        $cel->optionA=$request['optionA'];
        $cel->optionB=$request['optionB'];
        $cel->save();
        $new_item = Celebrity::orderby('created_at', 'desc')->first();
        $this->validate($request, [

            'image' => 'required|image|mimes:jpeg,png,jpg,gif,svg|max:2048',

        ]);
        $image = $request->file('image');
        $imagename =rand(100000,999999).time().'.'. $image->getClientOriginalExtension();
        $image->move(public_path().'/images/', $imagename);
        $image2 = $request->file('image2');
        $imagename2 = rand(100000,999999).time().'.'.$image2->getClientOriginalExtension();
        $image2->move(public_path().'/images/', $imagename2);

        $p_image = new CelebImage();
        $p_image->celeb_id = $new_item->id;
        $p_image->image1 =$imagename;
        $p_image->image2=$imagename2;
        $p_image->save();

        return response()->json([
            'message' => 'Added successfully',
        ], 201);
    }
    public function fetchAllCeleb(Request $request)
    {
        $cele = Celebrity::all();
        return $cele;
    }
    public function fetchCeleb(Request $request)
    {
        $celeb = Celebrity::where('id',$request['id'])->with('image')->first();
        return $celeb;
    }

    public function addLifestyle(Request $request)
    {
        $life = new AddLifestyle();
        $life->optionA = $request['optionA'];
        $life->optionB = $request['optionB'];
        $life->save();
        return response()->json([
            'message' => 'Added successfully',
        ], 201);
    }
    public function fetchLife(Request $request)
    {
        $celeb = AddLifestyle::all();
        return $celeb;
    }
    public function addFood(Request $request)
    {
        $life = new AddFood();
        $life->optionA = $request['optionA'];
        $life->optionB = $request['optionB'];
        $life->save();
        return response()->json([
            'message' => 'Added successfully',
        ], 201);
    }
    public function fetchFood(Request $request)
    {
        $celeb = AddFood::all();
        return $celeb;
    }
    public function addPartner(Request $request)
    {
        $life = new AddPartner();
        $life->optionA = $request['optionA'];
        $life->optionB = $request['optionB'];
        $life->save();
        return response()->json([
            'message' => 'Added successfully',
        ], 201);
    }
    public function fetchPartner(Request $request)
    {
        $celeb = AddPartner::all();
        return $celeb;
    }
}
