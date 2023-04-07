<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Env;
use Illuminate\Support\Facades\Log;

class MpesaController extends Controller
{
    //

    public function chukuaToken(){
        $url= 'https://sandbox.safaricom.co.ke/oauth/v1/generate?grant_type=client_credentials';
        //return "itakam hapa";
        //Log::error('Something is really going wrong.');
        //$url = env('MPESA_ENV') == 0
        //? 'https://sandbox.safaricom.co.ke/oauth/v1/generate?grant_type=client_credentials'
        //: 'https://api.safaricom.co.ke/oauth/v1/generate?grant_type=client_credentials';
        //keys ==> 'sDQMmlBka2LcXUaUmTnTryShCH23OUQ0:r1aGvbkeRRT62GNn'
        $curl = curl_init($url);
        curl_setopt_array(
            $curl,
            array(
                CURLOPT_HTTPHEADER => ['Content-Type: application/json; charset=utf8'],
                CURLOPT_RETURNTRANSFER => true,
                CURLOPT_HEADER => false,
                CURLOPT_USERPWD =>'sDQMmlBka2LcXUaUmTnTryShCH23OUQ0:r1aGvbkeRRT62GNn'
            )
        );
        //Log::info('auth token');
        $response = json_decode(curl_exec($curl));
        curl_close($curl);

        // return $response;
        return $response->access_token;

    }

    public function registerURL(){

        $url = env('MPESA_ENV') == 0
        ? 'https://sandbox.safaricom.co.ke/mpesa/c2b/v1/registerurl'
        : 'https://api.safaricom.co.ke/mpesa/c2b/v1/registerurl';
        $body = array(
            'ShortCode'=>'174379',
            'ResponseType'=>'Completed',
            'ConfirmationURL'=>env('MPESA_TEST_URL').'/api/confirmation',
            'ValidationURL'=>env('MPESA_TEST_URL').'/api/validation'
        );
        Log::info($body);

        $response = $this->makeHttp($url, $body);
        //Log::info($response);
        return $response;


    }

    public function stkPush(Request $request)
    {
        $timestamp = date('YmdHis');
        $password = base64_encode( env('MPESA_STK_SHORTCODE').env('MPESA_PASSKEY').$timestamp);

        $curl_post_data = array(
            'BusinessShortCode' => env('MPESA_STK_SHORTCODE'),
            'Password' => $password,
            'Timestamp' => $timestamp,
            'TransactionType' => 'CustomerPayBillOnline',
            'Amount' => $request->amount,
            'PartyA' => $request->phone,
            'PartyB' => env('MPESA_STK_SHORTCODE'),
            'PhoneNumber' => $request->phone,
            'CallBackURL' => env('MPESA_TEST_URL'). '/api/stkpush',
            'AccountReference' => $request->account,
            'TransactionDesc' => $request->account
          );

        $url = env('MPESA_ENV')==0? 'https://sandbox.safaricom.co.ke/mpesa/stkpush/v1/processrequest': 'https://API.safaricom.co.ke/mpesa/stkpush/v1/processrequest';

        $response = $this->makeHttp($url, $curl_post_data);

        Log::info($curl_post_data);

        return $response;
    }

    public function simulateTransaction(Request $request){

        $body = array(
            'Msisdn'=>'254708374149',
            'Amount' =>$request->amount,
            'BillRefNumber' =>$request->account,
            'CommandID' =>'CustomerPayBillOnline',
            'ShortCode'=> '174379'
        );

        $url= env('MPESA_ENV')==0
        ?'https://sandbox.safaricom.co.ke/mpesa/c2b/v1/simulate'
        :'https://api.safaricom.co.ke/mpesa/c2b/v1/simulate';

        $response = $this->makeHttp($url, $body);

        return $response;

    }

    public function b2cRequest(Request $request)
    {
        $post_data = array(
            "InitiatorName"=> env('MPESA_B2C_INITIATOR'),
            "SecurityCredential"=> env('MPESA_B2C_PASSWORD'),
            "CommandID"=> "SalaryPayment",
            "Amount"=>$request->amount,
            "PartyA"=>env('MPESA_SHORTCODE'),
            "PartyB"=>$request->phone,
            "Remarks"=>$request->remarks,
            "QueueTimeOutURL"=>  env('MPESA_TEST_URL').'/api/b2cresult',
            "ResultURL"=> env('MPESA_TEST_URL').'/api/timeout',
            "Occassion"=>$request->occasion,
        );

        $res = $this->makeHttp('https://sandbox.safaricom.co.ke/mpesa/b2c/v1/paymentrequest',$post_data);
        //Log::info($res);

        return $res;

    }
    public function b2cCallback(Request $request)
    {
        $timestamp = date('YmdHis');
        $password = env('MPESA_STK_SHORTCODE').env('MPESA_PASSKEY').$timestamp;

        $curl_post_data = array(
            'BusinessShortCode' => env('MPESA_STK_SHORTCODE'),
            'Password' => $password,
            'Timestamp' => $timestamp,
            'TransactionType' => 'CustomerPayBillOnline',
            'Amount' => $request->amount,
            'PartyA' => $request->phone,
            'PartyB' => env('MPESA_STK_SHORTCODE'),
            'PhoneNumber' => $request->phone,
            'CallBackURL' => env('MPESA_TEST_URL'). '/api/stkpush',
            'AccountReference' => $request->account,
            'TransactionDesc' => $request->account
          );

        $url = '/stkpush/v1/processrequest';

        $response = $this->makeHttp($url, $curl_post_data);

        return $response;
        # code...
    }

    /**
     * Transaction Status API
     */
    public function transactionstatus(Request $request)
    {
        # code...
        $url = env('MPESA_ENV')==0
        ? 'https://sandbox.safaricom.co.ke/mpesa/transactionstatus/v1/query'
        : 'https://api.safaricom.co.ke/mpesa/transactionstatus/v1/query';

        $body= array(

            "Initiator"=>env('MPESA_B2C_INITIATOR'), //"testapi",
            "SecurityCredential"=>env('MPESA_B2C_PASSWORD'),//"gBmMbwXEK9H9fmu8QpmOwcks/F/eh9v1DDMfDCO/YrRGBUACP8tmvHtKy7N0lus6/HXCQLuCMQxAObXpx0qlul/2ARp9Fy5IwV2UMl7VeAcyp3nx9ltAa9P9X738RbHnPHupAEh313/vWDi1l+Mqs6kFRjUvcOYWXda44ZQ1jJQpoJM1SZ9UrpjVRjlzIx6KxfcoRwu2pTmojNRH2yBSDC1HGTqh2f4gXbucSduLLwhAKkydVV3TD2hI1Kw19MfICuGxe/xFljiwx4vwnMG4I80zmzDYW8DJYR+dcgo3+5mNT7J0HBgI59EfLDKS0RK7+5rWdBdhPKGc/0CoVqgT8g==",
            "CommandID"=> "TransactionStatusQuery",
            "TransactionID"=>$request->transactionId,
            "PartyA"=>env('MPESA_SHORTCODE'),
            "IdentifierType"=> "4",
            "ResultURL"=>env('MPESA_TEST_URL')."/api/transaction-status/result",
            "QueueTimeOutURL"=>env('MPESA_TEST_URL')."/api/transaction-status/queue/",
            "Remarks"=>"REMARKS ZAKE",
            "Occassion"=>"LEO LEO",

        );
        $response =  $this->makeHttp($url, $body);

        return $response;
    }

    public function reverseTrans(Request $request){
        $url= 'https://sandbox.safaricom.co.ke/mpesa/reversal/v1/request';
        $body =array(
                "Initiator"=>env('MPESA_B2C_INITIATOR'),
                "SecurityCredential"=> env('MPESA_B2C_PASSWORD'),
                "CommandID"=>"TransactionReversal",
                "TransactionID"=> $request->transactionId,
                "Amount"=>$request->amount,
                "ReceiverParty"=>env('MPESA_SHORTCODE'),
                "RecieverIdentifierType"=>"11",
                "ResultURL"=>env('MPESA_TEST_URL')."/api/reversal/result_url",
                "QueueTimeOutURL"=>env('MPESA_TEST_URL')."/api/reversal/queue",
                "Remarks"=>"Please reverse",
                "Occasion"=>"work on it"
        );

        $response = $this->makeHttp($url, $body);

        return $response;
    }

    public function makeHttp($url, $body)
    {
        // $url = 'https://mpesa-reflector.herokuapp.com' . $url;
        //$url = 'https://sandbox.safaricom.co.ke/mpesa/' . $url;
        $curl = curl_init();
        curl_setopt_array(
            $curl,
            array(
                    CURLOPT_URL => $url,
                    CURLOPT_HTTPHEADER => array('Content-Type:application/json','Authorization:Bearer '. $this->chukuaToken()),
                    CURLOPT_RETURNTRANSFER => true,
                    CURLOPT_POST => true,
                    CURLOPT_POSTFIELDS => json_encode($body)
                )
        );
        $curl_response = curl_exec($curl);
        curl_close($curl);
        return $curl_response;
    }
}
