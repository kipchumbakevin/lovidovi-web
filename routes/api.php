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
//mkulima
Route::post("/mkulimasendcode","\App\Http\Controllers\MkulimaController@mkulimaSendCode");
Route::post("/mkulimaregister","\App\Http\Controllers\MkulimaController@mkulimaRegister");
Route::post("/mkulimalogin","\App\Http\Controllers\MkulimaController@login");
Route::post('/checkmkulima','MkulimaController@checkIfExist');
Route::post('/getmkulima','MkulimaController@getMkulima');
Route::post('/payup','MkulimaController@payUp');
Route::post('/withdraw','MkulimaController@withdraw');
//issues
Route::post("/addissue","IssuesController@addIssue");
Route::post("/fetchissues","IssuesController@fetchIssues");
Route::post("/fetchmine","IssuesController@fetchMine");
Route::post("/fetchc","IssuesController@fetchC");
Route::post("/addhelper","IssuesController@addHelper");
Route::post("/fetchhelper","IssuesController@fetchHelpers");
Route::post("/deleteissue","IssuesController@deleteIssue");

//this that
Route::post("/insertwould","WouldYouController@insert");
Route::post("/answerwould","WouldYouController@answer");
Route::get("/getwould","WouldYouController@fetch");
Route::post("/getsp","WouldYouController@fetchSp");

//never
Route::post("/insertnever","NeverHaveController@insert");
Route::post("/answernever","NeverHaveController@answer");
Route::get("/getnever","NeverHaveController@fetch");
Route::post("/getsnever","NeverHaveController@fetchS");

Route::post("/registerthisthat","ThisThatUserController@insert");
Route::post("/fetchtuser","ThisThatUserController@fetchUser");

Route::post("/insertceleb","CelebritiesController@insert");
Route::post("/getceleb","CelebritiesController@fetchCeleb");
Route::get("/getallceleb","CelebritiesController@fetchAllCeleb");
Route::get("/getalllife","CelebritiesController@fetchLife");
Route::get("/getallfood","CelebritiesController@fetchFood");
Route::get("/getallpartner","CelebritiesController@fetchPartner");


Route::post("/addlifestyle","CelebritiesController@addLifestyle");
Route::post("/addfood","CelebritiesController@addFood");
Route::post("/addpartner","CelebritiesController@addPartner");
//self
Route::post("/selflife","SelfEvaluationController@selfLife");
Route::post("/selffood","SelfEvaluationController@selfFood");
Route::post("/selfpartner","SelfEvaluationController@selfPartner");
Route::post("/selfceleb","SelfEvaluationController@selfCeleb");

Route::post("/specificlife","SelfEvaluationController@specificLifestyle");
Route::post("/specificfood","SelfEvaluationController@specificFood");
Route::post("/specificceleb","SelfEvaluationController@specificCeleb");
Route::post("/specificpartner","SelfEvaluationController@specificPartner");
//where i am the evaluatee
Route::post("/fetchmylife","SelfEvaluationController@fetchLifestyle");
Route::post("/fetchmyfood","SelfEvaluationController@fetchFood");
Route::post("/fetchmyceleb","SelfEvaluationController@fetchCeleb");
Route::post("/fetchmypartner","SelfEvaluationController@fetchPartner");
//specific
Route::post("/fetchmyspecificlife","FriendEvaluationController@fetchLifestyle");
Route::post("/fetchmyspecificfood","FriendEvaluationController@fetchFood");
Route::post("/fetchmyspecificceleb","FriendEvaluationController@fetchCeleb");
Route::post("/fetchmyspecificpartner","FriendEvaluationController@fetchPartner");

//i am the evaluator
Route::post("/fetchflife","SelfEvaluationController@fetchfLifestyle");
Route::post("/fetchffood","SelfEvaluationController@fetchfFood");
Route::post("/fetchfceleb","SelfEvaluationController@fetchfCeleb");
Route::post("/fetchfpartner","SelfEvaluationController@fetchfPartner");
//specific
Route::post("/fetchfspecificlife","FriendEvaluationController@fetchfLifestyle");
Route::post("/fetchfspecificfood","FriendEvaluationController@fetchfFood");
Route::post("/fetchfspecificceleb","FriendEvaluationController@fetchfCeleb");
Route::post("/fetchfspecificpartner","FriendEvaluationController@fetchfPartner");

//friend
Route::post("/friendlife","FriendEvaluationController@friendLife");
Route::post("/friendfood","FriendEvaluationController@friendFood");
Route::post("/friendceleb","FriendEvaluationController@friendCeleb");
Route::post("/friendpartner","FriendEvaluationController@friendPartner");





//guess it
Route::post("/insertfame","FamousController@insert");
Route::post("/getfame","FamousController@getFame");
Route::post("/updatefame","FamousController@updateFame");

Route::post("/high","HighscoreController@insert");
Route::get("/gethigh","HighscoreController@getHigh");
Route::post("/reg","UserPointsController@register");
Route::post("/freecoins","UserPointsController@freeCoins");
Route::post("/earnfromguess","UserPointsController@earnFromGuess");
Route::post("/getuser","UserPointsController@getUser");
Route::post("/earnfromquiz","QuestionsController@earnFromQuiz");
Route::post("/add","QuestionsController@insert");
Route::get("/getquestions","QuestionsController@getQuestions");
//mpesa
Route::post("/confirm","MpesaController@index");
Route::get("/btoc","B2CController@b2cPayment");
Route::get("/stk","STKController@stkPayment");
Route::post("/stkcallback","STKController@callback");
Route::post("/btoccallback","B2CController@callback");
Route::post("/ctob","MpesaController@confirmation");
Route::get('/registerurl','Controller@index');
Route::post('/ussd','USSDController@index');

//casino
Route::post('/insertcasino','CasinoController@insert');
Route::post('/getcasino','CasinoController@getCasino');
Route::post('/reducetrials','CasinoController@reduceTrials');
//cards
Route::post('/insertcasinoc','CardsController@insert');
Route::post('/getcasinoc','CardsController@getCasino');
Route::post('/reducetrialsc','CardsController@reduceTrials');
Route::post('/reducebonus','CardsController@reduceBonus');


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
Route::post("/delete","FundraiserController@deleteFundraiser");
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




