<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Twilio\Rest\Client;

class SmsController extends Controller
{
    public function sendsms()
    {
        $sid = getenv("TWILIO_SID");
        $token = getenv("TWILIO_TOKEN");
        $sendernumber = getenv("TWILIO_PHONE");

        $twilio = new Client($sid, $token);

        $message = $twilio->messages
            ->create(
                "+84362287661", // to
                [
                    "body" => "This is the ship that made the Kessel Run in fourteen parsecs?",
                    "from" => "+84362287661"
                ]
            );
    }
}
