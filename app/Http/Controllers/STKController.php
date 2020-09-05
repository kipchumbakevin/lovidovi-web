<?php

namespace App\Http\Controllers;

use App\STKModel;
use Carbon\Carbon;
use Illuminate\Http\Request;

class STKController extends Controller
{
    function stkPayment($amount=1, $phone="+254706459189", $reference="Samsung", $description="Kevin")
    {
        $now = Carbon::now('Africa/Nairobi');
        $phoneFormat = json_decode($this->phoneFormat($phone), TRUE);
        $phone = $phoneFormat['formattedPhone'];

        $MerchantRequestID = '';
        $status = 0;
        $ResponseDescription = '';

        $tokenResult = $this->generateAccessToken();
        $accessVals = json_decode($tokenResult, TRUE);

        if ($accessVals['status'] == 1) {
            $accessToken = "Bearer " . $accessVals['token'];

            $shortCode = '174379';
            $passKey = 'bfb279f9aa9bdbcf158e97dd71a467cd2e0c893059b10f78e6b72ada1ed2c919';
            $timestamp = $now->format('YmdHis');
            $password = base64_encode($shortCode . $passKey . $timestamp);

            // The data to send to the API
            $postData = array(
                'BusinessShortCode' => $shortCode,
                'Password' => $password,
                'Timestamp' => $timestamp,
                'TransactionType' => 'CustomerPayBillOnline',
                'Amount' => (int)$amount,
                'PartyA' => $phone,
                'PartyB' => $shortCode,
                'PhoneNumber' => $phone,
                'CallBackURL' => "https://www.lovidovi.co.ke/stkcallback",
                'AccountReference' => $reference,
                'TransactionDesc' => $description
            );

            $requestBody = json_encode($postData);

            // Setup cURL
            $ch = curl_init('https://api.safaricom.co.ke/mpesa/stkpush/v1/processrequest');
            curl_setopt_array($ch, array(
                CURLOPT_POST => TRUE,
                CURLOPT_SSL_VERIFYPEER => FALSE,
                CURLOPT_SSL_VERIFYHOST => FALSE,
                CURLOPT_RETURNTRANSFER => TRUE,
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
                return "CURL ERROR " . curl_error($ch);
            } else {
                $requestVals = json_decode($response, TRUE);

                $MerchantRequestID = isset($requestVals['MerchantRequestID']) ? $requestVals['MerchantRequestID'] : '';
                $CheckoutRequestID = isset($requestVals['CheckoutRequestID']) ? $requestVals['CheckoutRequestID'] : '';
                $ResponseCode = isset($requestVals['ResponseCode']) ? $requestVals['ResponseCode'] : '';
                $ResponseDescription = isset($requestVals['ResponseDescription']) ? $requestVals['ResponseDescription'] : '';
                $CustomerMessage = isset($requestVals['CustomerMessage']) ? $requestVals['CustomerMessage'] : '';
                $ResultCode = isset($requestVals['ResultCode']) ? $requestVals['ResultCode'] : '';
                $ResultDesc = isset($requestVals['ResultDesc']) ? $requestVals['ResultDesc'] : '';
                $MpesaReceiptNumber = isset($requestVals['MpesaReceiptNumber']) ? $requestVals['MpesaReceiptNumber'] : '';

                if ($ResponseCode == '0')//success
                {
                    $status = 1;
                    $stkm = STKModel::create([
                        'status'=>1,
                        'merchant_request_id'=>$MerchantRequestID
                    ]);
                }else{
                    return $response;
                }


            }
        }

        return array(
            'status' => $status,
            'response' => $ResponseDescription
        );
    }

    //generate access token to be used for transactions
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

    public function callback(Request $request)
    {
        date_default_timezone_set('Africa/Nairobi');
        $now = date('Y-m-d H:i:s');

        $paymentDetails = $request;

        if (!empty($paymentDetails)) {
            $successVals = json_decode($paymentDetails, TRUE);

            //when success
            $MerchantRequestID = $successVals['Body']['stkCallback']['MerchantRequestID'];
            $CheckoutRequestID = $successVals['Body']['stkCallback']['CheckoutRequestID'];
            $ResultCode = $successVals['Body']['stkCallback']['ResultCode'];
            $ResultDesc = $successVals['Body']['stkCallback']['ResultDesc'];

            //initialize non-common variables
            $amount = 0;
            $MpesaReceiptNumber = "";
            $TransactionDate = "";
            $PhoneNumber = "";

            $statusRes = 2;

            if ($ResultCode == '0')//success
            {
                $statusRes = 1;
                $amount = $successVals['Body']['stkCallback']['CallbackMetadata']['Item'][0]['Value'];
                $MpesaReceiptNumber = $successVals['Body']['stkCallback']['CallbackMetadata']['Item'][1]['Value'];
                $TransactionDate = $successVals['Body']['stkCallback']['CallbackMetadata']['Item'][3]['Value'];
//                $PhoneNumber = $successVals['Body']['stkCallback']['CallbackMetadata']['Item'][4]['Value'];

                $stkRequest = STKModel::where('merchant_request_id', $MerchantRequestID)->first();

                $stkRequest->mpesa_code = $MpesaReceiptNumber;//(Mpesa reference number)
                //0 = pending
                //1 = success
                //2 = failed

                //save details in table
                $stkRequest->status = 2;
                $stkRequest->phone = $PhoneNumber;
                $stkRequest->amount=$amount;
                $stkRequest->save();

            }

        } else {
            echo "Empty request";
        }
    }
}
