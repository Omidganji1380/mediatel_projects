<?php

namespace App\Services\Sms;

use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;

class SmsService
{
    public $sendUrl;
    public $username;
    public $password;
    public $sender;

    public function __construct() {
        $this->sendUrl = "https://api.smspanel.net/url/post/SendSMS.ashx";
        $this->username = "Verifyki";
        $this->password = "red0fi11";
        $this->sender = "6473721312";
    }

    public function send($phone, $message)
    {
        $url = $this->sendUrl . "?username={$this->username}&password={$this->password}&from={$this->sender}&to={$phone}&text={$message}";

        if(env('APP_ENV') !== 'local'){
            $response = Http::get($url);
        }else{
            Log::info("Sended message: " . $message);
        }
    }

    public function sendMessage($phone, $message)
    {
        $url = $this->sendUrl . "?username={$this->username}&password={$this->password}&from={$this->sender}&to={$phone}&text={$message}";

        $response = Http::get($url);
    }
}
