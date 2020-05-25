<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

Route::middleware('auth:api')->get('/user', function (Request $request) {
    return $request->user();
});

Route::group([
    'prefix' => 'auth'
], function () {
    Route::post('login', 'AuthController@login');
    Route::post('signup', 'AuthController@signup');

    Route::group([
        'middleware' => 'auth:api'
    ], function() {
        Route::get('logout', 'AuthController@logout');
        Route::get('user', 'AuthController@user');
    });
});
//check if user exists
Route::post("/checkifexist","NoAuthController@checkIfUserExists");//body(phone,username)
//generate signupcode
Route::post("/signupcode","CodesController@signUpCode");

//send crush notification
Route::post("/notifycrush","NotificationsController@insert");
Route::post("/likepost","NotificationsController@like");

//fetch notification
Route::post("/fetch","NotificationsController@fetch");

//quotes
Route::post("/insertquote","QuotesController@insert");
Route::get("/fetchquote","QuotesController@fetchQuotes");


