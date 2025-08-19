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
use Illuminate\Support\Str;

class RegisterController extends Controller {

    // register step1
    public function step1(Request $request) {
        $mobile = $request->get('mobile');
        $verifyCode = mt_rand(1000, 9999);
        $waitTime = null;
        $isCodeSend = false;

        if (User::whereMobile($mobile)->exists()) {
            return response()->json([
                'status' => false,
                'msg' => 'شماره موبایل قبلا ثبت شده لطفا از قسمت ورود وارد شوید',
            ]);
        }

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

        if ($isCodeSend) {
            (new SmsService)->sendVerifyCode($mobile, $verifyCode);

            return response()->json([
                'status' => true,
            ]);
        } else {
            return response()->json([
                'status' => false,
                'wait_time' => $waitTime,
                'msg' => 'لطفا بعد از ' . $waitTime . ' ثانیه مجدد تلاش کنید',
            ]);
        }
    }

    // register step2
    public function step2(Request $request) {
        $verifyCode = $request->get('verify_code');
        $mobile = $request->get('mobile');
        $username = $request->get('username');
        $password = $request->get('password');

        if (User::whereMobile($mobile)->exists()) {
            return response()->json([
                'status' => false,
                'msg' => 'شماره موبایل قبلا ثبت شده لطفا از قسمت ورود وارد شوید',
            ]);
        }

        if (!VerifyCode::whereMobile($mobile)->whereCode($verifyCode)->exists()) {
            return response()->json([
                'status' => false,
                'msg' => 'کد تایید وارد شده صحیح نیست',
            ]);
        }

        VerifyCode::whereMobile($mobile)->whereCode($verifyCode)->delete();
        $user = User::create([
            'name' => $username,
            'mobile' => $mobile,
            'mobile_verified_at' => now(),
            'password' => Hash::make($password),
            'uuid' => Str::uuid()->toString()
        ]);
        $user->is_from_app = true;
        Auth::login($user);
        $user = Auth::user();
        $user->token = $user->createToken('RAKHSHAI_APP')->plainTextToken;

        return response()->json([
            'status' => true,
            'user' => $user,
        ]);
    }
}
