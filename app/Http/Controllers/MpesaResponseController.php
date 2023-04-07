<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;

class MpesaResponseController extends Controller
{
    //
    public function validation(Request $request){

        Log::info('validation endpoint accessed');
        Log::info($request->all());

        Log::error('Something is really going wrong.');

        return [
            'ResultCode'=>0,
            'ResultDesc'=>'Accept Service',
            'ThirdPartyTransID' => rand(3100, 9090)
        ];

    }

    public function confirmation(Request $request){
        Log::error('Something is really going wrong.');
        Log::info('confirmation endpoint accessed');
        Log::info($request->all());

        return [
            'ResultCode'=>0,
            'ResultDesc'=>'Accept Service',
            'ThirdPartyTransID' => rand(3100, 9090)
        ];

    }

    public function b2cCallback(Request $request){
        Log::info('B2C endpoint hit');
        Log::info($request->all());
        return [
            'ResultCode' => 0,
            'ResultDesc' => 'Accept Service',
            'ThirdPartyTransID' => rand(3000, 10000)
        ];
    }

    public function transactionstatusresponse(Request $request)
    {
        # code...
        Log::info('verify transaction endpoint accessed');
        Log::info($request->all());



        return [
            'ResultCode'=>0,
            'ResultDesc'=>'Accept Service',
            'ThirdPartyTransID' => rand(3100, 9090)
        ];
    }

    public function transactionsReversal(Request $request)
    {
        # code...
        Log::info('transactionsReversal endpoint accessed');
        Log::info($request->all());



        return [
            'ResultCode'=>0,
            'ResultDesc'=>'Accept Service',
            'ThirdPartyTransID' => rand(3100, 9090)
        ];
    }

    public function stkPush(Request $request){
        Log::info('STK Push endpoint hit');
        Log::info($request->all());
        return [
            'ResultCode' => 0,
            'ResultDesc' => 'Accept Service',
            'ThirdPartyTransID' => rand(3000, 10000)
        ];
    }
}
