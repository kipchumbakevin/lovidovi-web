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
//FUNDRAISER
//create fundraiser
Route::post("/createfund","FundraiserController@createFundraiser");
//fetch all fundraisers
Route::get("/fetchfundraisers","FundraiserController@fetchFundraisers");
//fetch by id
Route::post("/fetchbyid","FundraiserController@fetchById");
//fetch own fund
Route::post("/fetchown","FundraiserController@fetchOwn");
//see all contributions
Route::post("/seeall","FundraiserController@seeContributions");
//fetch total
Route::post("/totalamount","FundraiserController@fetchTotal");
//delete fund
Route::post("/delete","FundraiserController@deleteFund");
//fetch payment options
Route::post("/fetchpayments","PaymentsController@fetchPaymentOptions");
//fetch contributions
Route::post("/fetchcontribution","FundraiserController@fetchContributions");
//register
Route::post("/register","RegisterController@insert");
//contribute
Route::post("/contribute","ContributionsController@insert");




















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
//delete
Route::post("/deletechat","MessagesController@deleteChat");
Route::post("/deletemessage","MessagesController@deleteMessage");
//
Route::post("/sendmsg","MessagesController@sendMessage");
Route::post("/fetchmsgs","MessagesController@fetchMessages");
Route::get("/fetchchats","MessagesController@fetchChats");
Route::get("/fetchunreadmessages","MessagesController@unreadMessages");
Route::post("/readmessageunread","MessagesController@readUnreadMessages");

//secret messages
//delete
Route::post("/deletesecretchat","SecretMesssagesController@deleteChat");
Route::post("/deletesecretmessage","SecretMesssagesController@deleteMessage");
//
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

//CRUSHIE
Route::post("/addphone","PhonesController@insert");
//delete
Route::post("/deletecrushiechat","CrushieMessagesController@deleteChat");
Route::post("/deletecrushiemessage","CrushieMessagesController@deleteMessage");
//
Route::post("/sendcrushie","CrushieMessagesController@sendSecretMessage");
Route::post("/fetchcrushie","CrushieMessagesController@fetchSecretMessages");
Route::post("/fetchcrushiechats","CrushieMessagesController@fetchSecretChats");
Route::get("/fetchunreadcrushie","CrushieMessagesController@unreadMessages");
Route::post("/readsecretmessageunread","CrushieMessagesController@readUnreadMessages");

Route::post("/notifycrushy","CrushyCrushCoontroller@insert");

//fetch notification
Route::post("/fetchcrushy","CrushyCrushCoontroller@fetch");
Route::post("/unreadcrushy","CrushyCrushCoontroller@unread");
//delete notification
Route::post("/deletecrushynot","CrushyCrushCoontroller@deleteN");
Route::post("/readnotificationscrushy","CrushyCrushCoontroller@readall");


//Newton
Route::post("/naddphone","NPhonesController@insert");
//delete
Route::post("/ndeletecrushiechat","NCrushieMessagesController@deleteChat");
Route::post("/ndeletecrushiemessage","NCrushieMessagesController@deleteMessage");
//
Route::post("/nsendcrushie","NCrushieMessagesController@sendSecretMessage");
Route::post("/nfetchcrushie","NCrushieMessagesController@fetchSecretMessages");
Route::post("/nfetchcrushiechats","NCrushieMessagesController@fetchSecretChats");
Route::get("/nfetchunreadcrushie","NCrushieMessagesController@unreadMessages");
Route::post("/nreadsecretmessageunread","NCrushieMessagesController@readUnreadMessages");

Route::post("/nnotifycrushy","NCrushyCrushCoontroller@insert");

//fetch notification
Route::post("/nfetchcrushy","NCrushyCrushCoontroller@fetch");
Route::post("/nunreadcrushy","NCrushyCrushCoontroller@unread");
//delete notification
Route::post("/ndeletecrushynot","NCrushyCrushCoontroller@deleteN");
Route::post("/nreadnotificationscrushy","NCrushyCrushCoontroller@readall");




