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

//fetch notification
Route::post("/fetch","NotificationsController@fetch");
Route::post("/unread","NotificationsController@unread");
//delete notification
Route::post("/deletenot","NotificationsController@deleteN");

//quotes
Route::post("/insertquote","QuotesController@insert");
Route::get("/fetchquote","QuotesController@fetchQuotes");

//likes
Route::post("/insertlike","LikesController@insert");
Route::post("/fetchlikes","LikesController@fetchlikes");
Route::post("/fetchlikescount","LikesController@fetchlikescount");

//messages
Route::post("/sendmsg","MessagesController@sendMessage");
Route::post("/fetchmsgs","MessagesController@fetchMessages");
Route::get("/fetchchats","MessagesController@fetchChats");
Route::get("/fetchunreadmessages","MessagesController@unreadMessages");
Route::post("/readmessageunread","MessagesController@readUnreadMessages");

//secret messages
Route::post("/sendsecret","SecretMesssagesController@sendSecretMessage");
Route::post("/fetchsecret","SecretMesssagesController@fetchSecretMessages");
Route::get("/fetchsecretchats","SecretMesssagesController@fetchSecretChats");
Route::get("/fetchunreadsecret","SecretMesssagesController@unreadMessages");
Route::post("/readsecretmessageunread","SecretMesssagesController@readUnreadMessages");

//unread chat
Route::post("/unreadchat","ChatsController@unreadChat");
//read notifications
Route::post("/readnotifications","NotificationsController@readall");

//change password
Route::post("/changepassword","ChangePersonalInfoController@changePassword");

//forgot password
Route::post("/sendcode","NoAuthController@sendCode");//body(phone
Route::post("/newpassword","NoAuthController@changePassword");//body(code,newpass)
Route::post("/checkifexist","NoAuthController@checkIfUserExists");//body(phone,username)
//change username
Route::post("/changedetails","ChangePersonalInfoController@changedetails");//body(username)
//CHANGE PHONE
//check phone
Route::post("/checkphone","ChangePersonalInfoController@checkNumberIfCorrect");//body(phone,password)
Route::post("/generatecode","ChangePersonalInfoController@generateChangePhoneCode");
Route::post("/changephone","ChangePersonalInfoController@changephone");




