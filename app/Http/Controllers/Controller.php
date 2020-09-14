<?php

namespace App\Http\Controllers;

use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Foundation\Bus\DispatchesJobs;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Routing\Controller as BaseController;

class Controller extends BaseController
{
    use AuthorizesRequests, DispatchesJobs, ValidatesRequests;
//    function index(){
//
//        date_default_timezone_set('Africa/Nairobi');
//        $now = date('Y-m-d H:i:s');
//        $accessVals = json_decode(generateAccessToken(),true);
//        if($accessVals['status'] == 1)
//        {
//            $accessToken = "Bearer ".$accessVals['token'];
//            // The data to send to the API
//            $postData = array(
//                'ValidationURL' => "https://www.lovidovi.co.ke/ctob",
//                'ConfirmationURL' => "https://www.lovidovi.co.ke/confirm",
//                'ResponseType' => "Completed",
//                'ShortCode' => '600610'
//            );
//
//            $requestBody = json_encode($postData);
//
//            // Setup cURL
//            $ch = curl_init('https://sandbox.safaricom.co.ke/mpesa/c2b/v1/registerurl');
//            curl_setopt_array($ch, array(
//                CURLOPT_POST => TRUE,
//                CURLOPT_RETURNTRANSFER => TRUE,
//                CURLOPT_SSL_VERIFYPEER => false,
//                CURLOPT_SSL_VERIFYHOST => false,
//                CURLOPT_HTTPHEADER => array(
//                    'Content-Type: application/json',
//                    'Authorization: '.$accessToken
//                ),
//                CURLOPT_POSTFIELDS => $requestBody
//            ));
//
//            // Send the request
//            $response = curl_exec($ch);
//
//            // Check for errors
//            if($response === FALSE){
//                die(curl_error($ch));
//            }
//            else
//            {
//                $requestVals = json_decode($response,true);
//
//                echo $response."<br/><br/><br/>";
//            }
//        }
//        else
//        {
//            echo "Could not generate access token";
//        }
//    }
    function generateAccessToken()
    {
        $accessToken = "";
        $status = 0;
        $description = "";

        $url = 'https://sandbox.safaricom.co.ke/oauth/v1/generate?grant_type=client_credentials';

        $curl = curl_init();
        curl_setopt($curl, CURLOPT_URL, $url);
        $credentials = base64_encode('207AFGU8UGGKEwZq81WHztAkGUIHSuvP:EEJ09gD92PeYGzzD');
        curl_setopt($curl, CURLOPT_HTTPHEADER, array('Authorization: Basic ' . $credentials)); //setting a custom header
        curl_setopt($curl, CURLOPT_RETURNTRANSFER, TRUE);
        curl_setopt($curl, CURLOPT_SSL_VERIFYPEER, FALSE);
        curl_setopt($curl, CURLOPT_SSL_VERIFYHOST, FALSE);

        $curl_response = curl_exec($curl);

        if ($curl_response != FALSE) {
            $responseVals = json_decode($curl_response, TRUE);

            $responseVals = json_decode($curl_response, TRUE);

            $accessToken = $responseVals['access_token'];
            $status = 1;
        } else {
            $description = "Curl Failed: " . curl_error($curl);
        }

        $array = array('status' => $status, 'token' => $accessToken, 'description' => $description);

        return json_encode($array);
    }
    protected function phoneFormat($phone)
    {
        //initialize valuables
        $status = FALSE;
        $formattedPhone = '';

        //remove white spaces
        $phone = trim($phone);
        $phone = str_replace(" ", "", $phone);

        //remove -, (, and )
        $phone = str_replace("-", "", $phone);
        $phone = str_replace("(", "", $phone);
        $phone = str_replace(")", "", $phone);

        //validate - all should begin with 254
        if (strlen($phone) >= 9 && strlen($phone) <= 13) {
            if (substr($phone, 0, 2) == "07") {
                $phone = substr_replace($phone, "254", 0, 1);
            } elseif (substr($phone, 0, 4) == "+254") {
                $phone = substr_replace($phone, "", 0, 1);
            } elseif (substr($phone, 0, 1) === "7") {
                $phone = substr_replace($phone, "254", 0, 0);
            }

            if (substr($phone, 0, 3) == "254" && strlen($phone) == 12 && is_numeric($phone)) {
                $status = TRUE;
                $formattedPhone = $phone;
            }
        }

        $array = array('status' => $status, 'formattedPhone' => $formattedPhone);
        return json_encode($array);
    }
}
