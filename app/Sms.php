<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Sms extends Model
{
    public function send($msisdn, $message)
    {
        $msg = urlencode($message);
        $destination = urlencode($msisdn);

//        $url = "https://deywuro.com/api/sms?username=multimoney&password=multimoney123&source=MultiMoney&destination=233542688902&message=jkldas";
        $url = "https://deywuro.com/api/sms/?username=Multimoney&password=multimoney123&destination=" . $destination . "&source=MultiMoney&message=" . $msg;

        $curl = curl_init($url);
        $v = curl_exec($curl);
        curl_close($curl);

    }
}
