<?php

namespace App\Http\Controllers;

use App\B2CModel;
use Carbon\Carbon;
use Illuminate\Http\Request;

class B2CController extends Controller
{
    //send B2C request
    function b2cPayment($recipient="+254706459189", $amount=50)
    {
        $amount = (int)$amount;
        //initialize responses
        $status = 0;//failed by default
        $ConversationID = '';
        $OriginatorConversationID = '';
        $ResponseCode = '';
        $ResponseDescription = '';

        $now = Carbon::now('Africa/Nairobi');
        $phoneFormat = json_decode($this->phoneFormat($recipient), TRUE);
        $phone = $phoneFormat['formattedPhone'];

        //check if phone is ok
        $phoneVals = json_decode($this->phoneFormat($recipient), TRUE);

        if ($phoneVals['status'] == TRUE) {
            //validate amount
            if (is_numeric($amount)) {
                if ($amount >= 50 && $amount <= 70000) {
                    $recipient = $phoneVals['formattedPhone'];

                    $amount = floor($amount);

                    $accessVals = json_decode($this->generateAccessTokenB2C(), TRUE);
                    if ($accessVals['status'] == 1) {
                        $nowRequest = date('Y-m-d H:i:s');
                        $accessToken = "Bearer " . $accessVals['token'];

                        $securityCredential = "hDfeuWcabPk9mA2k9IIwrEQYZ5Iknfh5vrVoNJW2LJGqysC0HyLLEap3pmDShdg9Ucmqq2RbE44XvW1KacMfhYm3BypjUXxz7DXMnVUQjiI9tw/SG3miXAXe3xbvGotzw28GQXYI7h4yAxkXozKgv+So0nsCsPtNYmwfU76l3Uig4z2AMIUhYQ/qH8r2we98pUNFoU2rK3iICdT4i/aTZ5xrtlmdQ9WpI06zeyVOzzSt84hRZqilaRSKlKYPhkWcOLC0YDa4Ov+ZvPt6uiTqxnhkIcfR2rKo9L3Q8bINLZyqpJilWkBXl6tFfzTYcEzXSatrabGujAkBU0WkEI24HQ==";
                        // The data to send to the API
                        $postData = array(
                            "InitiatorName" => "B2C INITIATOR",
                            "SecurityCredential" => $securityCredential,
                            "CommandID" => "BusinessPayment",
                            "Amount" => $amount,
                            "PartyA" => env('B2C_SHORTCODE'),
                            "PartyB" => $recipient,
                            "Remarks" => "Disbursement",
                            "QueueTimeOutURL" => env('APP_URL') . '/api/mtx/timeout',
                            "ResultURL" => env('APP_URL') . '/api/mtx/b2c',
                            "Occassion" => "Disbursement"
                        );

                        $requestBody = json_encode($postData);

                        // Setup cURL
                        $ch = curl_init('https://sandbox.safaricom.co.ke/mpesa/b2c/v1/paymentrequest');
                        curl_setopt_array($ch, array(
                            CURLOPT_POST => TRUE,
                            CURLOPT_RETURNTRANSFER => TRUE,
                            CURLOPT_SSL_VERIFYHOST => FALSE,
                            CURLOPT_SSL_VERIFYPEER => FALSE,
                            CURLOPT_HTTPHEADER => array(
                                'Content-Type: application/json',
                                'Authorization: ' . $accessToken
                            ),
                            CURLOPT_POSTFIELDS => $requestBody
                        ));

                        // Send the request
                        $response = curl_exec($ch);

                        // Check for errors
                        if ($response === FALSE) {
                            die(curl_error($ch));
                        } else {
                            $requestVals = json_decode($response, TRUE);

                            if (count($requestVals) == 4)//sent
                            {
                                $ConversationID = $requestVals['ConversationID'];
                                $OriginatorConversationID = $requestVals['OriginatorConversationID'];
                                $ResponseCode = $requestVals['ResponseCode'];
                                $ResponseDescription = $requestVals['ResponseDescription'];

                                if ($ResponseCode == '0')//success
                                {
                                    $status = 1;
                                    $btoc = B2CModel::create([
                                        'orinator_id'=>$OriginatorConversationID
                                    ]);
                                } else {

                                }
                            }
                        }
                    } else {
                        $ResponseDescription = "Could not generate access token";
                    }
                } else {
                    $status = 4;
                    $ResponseDescription = "Amount must be greater than or equal to 50 and less than or equal to 70,000";
                }
            } else {
                $status = 4;
                $ResponseDescription = "Amount is not a number";
            }
        } else {
            $status = 4;
            $ResponseDescription = "Wrong phone format";
        }


        $array = array(
            'status' => $status,
            'conversation_id' => $ConversationID,
            'originator_conversation_id' => $OriginatorConversationID,
            'result_code' => $ResponseCode,
            'result_description' => $ResponseDescription
        );

        return $array;
    }

    function callback(Request $request)
    {
        $result = TRUE;
        $Date = Carbon::now('Africa/Nairobi')->format('Y-m-d');
        $paymentDetails = file_get_contents('php://input');

        if (!empty($paymentDetails)) {
            $paymentDetailsVals = json_decode($paymentDetails, TRUE);

            $ResultType = htmlspecialchars($paymentDetailsVals['Result']['ResultType'], ENT_QUOTES);
            $ResultCode = htmlspecialchars($paymentDetailsVals['Result']['ResultCode'], ENT_QUOTES);
            $ResultDesc = htmlspecialchars($paymentDetailsVals['Result']['ResultDesc'], ENT_QUOTES);
            $OriginatorConversationID = htmlspecialchars($paymentDetailsVals['Result']['OriginatorConversationID'], ENT_QUOTES);
            $ConversationID = htmlspecialchars($paymentDetailsVals['Result']['ConversationID'], ENT_QUOTES);
            $TransactionID = htmlspecialchars($paymentDetailsVals['Result']['TransactionID'], ENT_QUOTES);
            $Key = htmlspecialchars($paymentDetailsVals['Result']['ReferenceData']['ReferenceItem']['Key'], ENT_QUOTES);
            $Value = htmlspecialchars($paymentDetailsVals['Result']['ReferenceData']['ReferenceItem']['Value'], ENT_QUOTES);

            //initialize success variables
            $TransactionAmount = 0;
            $TransactionReceipt = '';
            $ReceiverPartyPublicName = '';
            $TransactionCompletedDateTime = '';
            $B2CUtilityAccountAvailableFunds = 0;
            $B2CWorkingAccountAvailableFunds = 0;
            $B2CRecipientIsRegisteredCustomer = '';
            $B2CChargesPaidAccountAvailableFunds = 0;

            if ($ResultCode == '0')//success
            {
                $TransactionAmount = htmlspecialchars($paymentDetailsVals['Result']['ResultParameters']['ResultParameter'][0]['Value'], ENT_QUOTES);
                $TransactionReceipt = htmlspecialchars($paymentDetailsVals['Result']['ResultParameters']['ResultParameter'][1]['Value'], ENT_QUOTES);
                $ReceiverPartyPublicName = htmlspecialchars($paymentDetailsVals['Result']['ResultParameters']['ResultParameter'][2]['Value'], ENT_QUOTES);
                $TransactionCompletedDateTime = htmlspecialchars($paymentDetailsVals['Result']['ResultParameters']['ResultParameter'][3]['Value'], ENT_QUOTES);
                $B2CUtilityAccountAvailableFunds = htmlspecialchars($paymentDetailsVals['Result']['ResultParameters']['ResultParameter'][4]['Value'], ENT_QUOTES);
                $B2CWorkingAccountAvailableFunds = htmlspecialchars($paymentDetailsVals['Result']['ResultParameters']['ResultParameter'][5]['Value'], ENT_QUOTES);
                $B2CRecipientIsRegisteredCustomer = htmlspecialchars($paymentDetailsVals['Result']['ResultParameters']['ResultParameter'][6]['Value'], ENT_QUOTES);
                $B2CChargesPaidAccountAvailableFunds = htmlspecialchars($paymentDetailsVals['Result']['ResultParameters']['ResultParameter'][7]['Value'], ENT_QUOTES);

                $personalDetails = explode("-", $ReceiverPartyPublicName);
                $name = $personalDetails[1];
                $phone = $personalDetails[0];
                $btc = B2CModel::where('originator_id',$OriginatorConversationID)->first();
                $btc->update([
                    'status'=>1,
                    'mpesa_code'=>$ResultCode,
                    'phone' => $phone,
                    'name'=>$name
                ]);

            } else {
                $this->sendSMS('254725778511', "Jiweze B2C Failed due to \n" . $paymentDetails);
            }
        } else {
            $result = FALSE;
            echo "Empty Request";
        }
        return ["status" => $result];
    }

    //generate access token to be used for B2C transactions
    function generateAccessTokenB2C()
    {
        $accessToken = "";
        $status = 0;
        $description = "";

        $url = 'https://api.safaricom.co.ke/oauth/v1/generate?grant_type=client_credentials';

        $curl = curl_init();
        curl_setopt($curl, CURLOPT_URL, $url);
        $credentials = base64_encode("bfb279f9aa9bdbcf158e97dd71a467cd2e0c893059b10f78e6b72ada1ed2c919");
        curl_setopt($curl, CURLOPT_HTTPHEADER, array('Authorization: Basic ' . $credentials)); //setting a custom header
        curl_setopt($curl, CURLOPT_RETURNTRANSFER, TRUE);
        curl_setopt($curl, CURLOPT_SSL_VERIFYPEER, FALSE);
        curl_setopt($curl, CURLOPT_SSL_VERIFYHOST, FALSE);

        $curl_response = curl_exec($curl);

        if ($curl_response != FALSE) {
            $responseVals = json_decode($curl_response, TRUE);

            $accessToken = $responseVals['access_token'];
            $status = 1;
        } else {
            $description = "Curl Failed: " . curl_error($curl);
        }

        $array = array('status' => $status, 'token' => $accessToken, 'description' => $description);

        return json_encode($array);
    }
}
