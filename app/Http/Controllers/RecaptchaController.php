<?php

namespace App\Http\Controllers;

use GuzzleHttp\Client;
use Illuminate\Http\Request;
use App\Rules\GoogleRecaptcha;

class RecaptchaController extends Controller
{
    function store( Request $request ){
        $validator = \Validator::make(
            $request->except('_token'),
            [
                'g-recaptcha-response' => [
                    'required', new GoogleRecaptcha
                ],
            ]
        );
        
        if ($validator->fails()) {
            return redirect()->back()->withErrors($validator)->withInput();
        }
        $this->saveSession();
        // return redirect('/');
        return redirect( session('checkRobotReferer') );

    }

    function saveSession(){
        $session_key = 'counter0099';
        $time_key = 'timer0099';
        // $value = session($session_key);
        // $interval = 60 * 60 * 2  ;
        // $interval = 60 * 60 * 2  ;

        session([ $time_key =>  \Carbon\Carbon::now()->toDateTimeString() ]);
        session([$session_key=> 1]);

        return;
    }
}
