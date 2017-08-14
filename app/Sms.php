<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Sms extends Model
{
    public function send($msisdn, $message)
    {
        $msg = urlencode($message);
        $destination = urlencode($msisdn);

        $url = "http://deywuro.com/api/sms?username=multimoney&password=multimoney123&source=MultiMoney&destination=" . $destination . "&message=" . $msg;

        $curl = curl_init($url);
        curl_exec($curl);
        curl_close($curl);

//        $api = http://deywuro.com/api/sms?username=multimoney&password=multimoney123&source=MultiMoney&destination=0542688902&message=test

    }
}
