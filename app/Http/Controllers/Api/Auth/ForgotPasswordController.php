<?php

namespace App\Http\Controllers\Api\Auth;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Models\VerifyCode;
use App\Services\SMS\SmsService;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class ForgotPasswordController extends Controller {

    public function step1(Request $request) {

        $mobile = $request->get('mobile');
        $verifyCode = mt_rand(1000, 9999);
        $waitTime = null;
        $isCodeSend = false;

        if (!User::whereMobile($mobile)->exists()) {

            return response()->json([
                'status' => false,
                'msg' => 'شماره موبایل وارد شده صحیح نیست',
            ]);
        }

        if ($request->get('send_code') == 'yes') {
            $code = VerifyCode::whereMobile($mobile)->first();
            if (!$code) {
                VerifyCode::create([
                    'mobile' => $mobile,
                    'code' => $verifyCode
                ]);
                $isCodeSend = true;
            } else {
                $secDiff = $code->updated_at->diffInSeconds(Carbon::now());
                if ($secDiff >= 120) {
                    $code->code = $verifyCode;
                    $code->save();
                    $isCodeSend = true;
                } else {
                    $waitTime = 120 - $secDiff;
                }
            }
        }

        if ($isCodeSend) {
            (new SmsService)->sendVerifyCode($mobile, $verifyCode);

            return response()->json([
                'status' => true,
                'msg' => 'کد فعال سازی با موفقیت ارسال شد',
            ]);
        } else {

            return response()->json([
                'status' => false,
                'wait_time' => $waitTime,
                'msg' => 'لطفا بعد از ' . $waitTime . ' ثانیه مجدد تلاش کنید',
            ]);
        }
    }

    public function step2(Request $request) {

        $verifyCode = $request->get('verify_code');
        $mobile = $request->get('mobile');
        $password = $request->get('password');

        $user = User::whereMobile($mobile)->first();

        if (!$user) {
            return response()->json([
                'status' => false,
                'msg' => 'شماره موبایل وارد شده صحیح نیست',
            ]);
        }

        if (!VerifyCode::whereMobile($mobile)->whereCode($verifyCode)->exists()) {
            return response()->json([
                'status' => false,
                'msg' => 'کد تایید وارد شده صحیح نیست',
            ]);
        }

        VerifyCode::whereMobile($mobile)->whereCode($verifyCode)->delete();

        $user->password = Hash::make($password);
        $user->save();

        Auth::login($user);
        $user = Auth::user();
        $user->token = $user->createToken('RAKHSHAI_APP')->plainTextToken;

        return response()->json([
            'status' => true,
            'user' => $user
        ]);
    }
}
