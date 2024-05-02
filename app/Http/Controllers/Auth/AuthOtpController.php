<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
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
        $userOtp->sendSMS($request->mobile_no); //send otp
        return redirect()->route('otp.verification', ['user_id', $userOtp->user_id])
            ->with('success', 'OTP has been sent to your mobile phone');
    }

    public function generateOTP($mobile_no)
    {
        $user = User::where('mobile_no', $mobile_no)->first();
        $userOtp = UserOtp::where('user_id', $user->id)->latest()->first();
        $now = now();
        if ($userOtp && $now->isBefore($userOtp->expired_at)) {
            return $userOtp;
        }
        return UserOtp::create([
            'user_id' => $user->id,
            'otp' => rand(123456, 999999),
            'expired_at' => $now->addSecond(61),
        ]);
    }
    public function verification($user_id)
    {
        return view('auth.OtpVerification')->with(['user_id' => $user_id]);
    }
    public function loginWithOtp(Request $request)
    {
        $request->validate([
            'otp' => 'required',
            'user_id' => 'required|exists:users,id',
        ]);
        $userOtp = UserOtp::where('user_id', $request->user_id)->where('otp', $request->otp)->first();
        $now = now();
        if (!$userOtp) {
            return redirect()->back()->with('error', 'OTP khong dung');
        } else if ($userOtp && $now->isAfter($userOtp->expired_at)) {
            return redirect()->back()->with('error', 'OTP het han');
        }
        $user = User::WhereId($request->user_id)->first();
        if ($user) {
            $userOtp->update(
                ['expired_at' => $now]
            );
            Auth::login($user);
            return redirect('/home');
        }
        return redirect()->route('otp.login')->with('error', 'Otp khong dung');
    }
}
