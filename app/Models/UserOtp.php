<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Exception;
use Twilio\Rest\Client;

class UserOtp extends Model
{
    use HasFactory;
    protected $fillable  = [
        'user_id',
        'otp',
        'expired_at'
    ];
    public function sendSMS($receiverNumber)
    {
        $message = ' OTP VERIFY IS' . $this->otp;
        try {
            $account_id = getenv("TWILIO_SID");
            $auth_token = getenv("TWILIO_TOKEN");
            $twilio_number = getenv("TWILIO_PHONE");

            $client = new Client($account_id, $auth_token);
            $client->messages->create(
                $receiverNumber,
                [
                    'from' => $twilio_number,
                    'body' => $message
                ]
            );
            info("SMS sent successfully");
        } catch (Exception $e) {
            return $e->getMessage();
        } catch (Exception $e) {
            info("Error sending" . $e->getMessage());
        }
    }
}
