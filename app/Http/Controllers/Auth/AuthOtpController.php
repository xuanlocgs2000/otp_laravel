<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\User;
use App\Models\UserOtp;
use Generator;

class AuthOtpController extends Controller
{
    public function login()
    {
        return view('auth.OtpLogin');
    }
    public function generate(Request $request)
    {
        $request->validate([
            'mobile_no' => 'required|exists:users,mobile_no',
        ]);

        $userOtp =  $this->generateOTP($request->mobile_no);
        $userOtp->sendSMS($request->mobile_no);
    }

    public function generateOTP($mobile_no)
    {
        $user = User::where('mobile_no', $mobile_no)->first();
        $userOtp = UserOtp::where('user_id', $user->id)->latest()->first();
        $now = now();
        if ($userOtp && $now->isBefore($userOtp->expired_at)) {
            return $userOtp;
        }
        UserOtp::create([
            'user_id' => $user->id,
            'otp' => rand(123456, 999999),
            'expired_at' => $now->addMinutes(10),
        ]);
    }
}
