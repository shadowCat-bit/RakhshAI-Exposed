<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\Affiliate;
use App\Models\User;
use App\Models\VerifyCode;
use App\Services\RecaptchaService;
use App\Services\SMS\SmsService;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Cookie;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Str;

class AuthController extends Controller {

    // login page
    public function login() {
        return view('auth.login');
    }

    // logout
    public function logout() {
        Auth::logout();

        return redirect('/');
    }

    // login process
    public function loginProcess(Request $request) {
        $credentials = $request->only('mobile', 'password');
        $recaptcha = $request->get('recaptcha');

        $recaptchaCheck = (new RecaptchaService)->check($recaptcha);

        if (!$recaptchaCheck) {
            return back()->withErrors([
                'msg' => 'کپچا معتبر نیست',
            ]);
        }

        if (Auth::attempt($credentials)) {
            return redirect()->intended('/chat');
        }

        return back()->withErrors([
            'msg' => 'اطلاعات وارد شده صحیح نیست',
        ]);
    }

    // register step1
    public function registerStep1(Request $request) {

        $refCode = $request->get('ref');

        if ($refCode == '' or $refCode == null) {
            return view('auth.register-step1');
        }

        $expirationTime = 7 * 24 * 60;

        $cookie = cookie('ref_code', $refCode, $expirationTime);

        return response()
            ->view('auth.register-step1')
            ->cookie($cookie);
    }

    // register step2
    public function registerStep2(Request $request) {
        $mobile = $request->get('mobile');
        $verifyCode = mt_rand(1000, 9999);
        $waitTime = null;
        $isCodeSend = false;
        $recaptcha = $request->get('recaptcha');

        $recaptchaCheck = (new RecaptchaService)->check($recaptcha);

        if (!$recaptchaCheck) {
            return redirect()->route('register.step1')->withErrors([
                'msg' => 'کپچا معتبر نیست',
            ]);
        }

        if (User::whereMobile($mobile)->exists()) {
            return back()->withErrors([
                'msg' => 'شماره موبایل قبلا ثبت شده لطفا از قسمت ورود وارد شوید',
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
        }


        return view('auth.register-step2', compact('waitTime', 'mobile', 'isCodeSend'));
    }

    // register process
    public function registerProcess(Request $request) {
        $verifyCode = $request->get('verify_code');
        $mobile = $request->get('mobile');
        $username = $request->get('username');
        $password = $request->get('password');
        $recaptcha = $request->get('recaptcha');

        $recaptchaCheck = (new RecaptchaService)->check($recaptcha);

        if (!$recaptchaCheck) {
            return redirect()->route('register.step1')->withErrors([
                'msg' => 'کپچا معتبر نیست',
            ]);
        }

        if (User::whereMobile($mobile)->exists()) {
            return back()->withErrors([
                'msg' => 'شماره موبایل قبلا ثبت شده لطفا از قسمت ورود وارد شوید',
            ]);
        }

        if (!VerifyCode::whereMobile($mobile)->whereCode($verifyCode)->exists()) {
            return redirect("auth/register/confirm?mobile=$mobile")->withErrors([
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
        $this->storeAffiliate(Cookie::get('ref_code'), $user->id);
        Auth::login($user);

        return redirect()->intended('/chat');
    }

    // forgotPassword step1
    public function forgotPasswordStep1(Request $request) {
        return view('auth.forgot-step1');
    }

    // forgotPassword step2
    public function forgotPasswordStep2(Request $request) {
        $mobile = $request->get('mobile');
        $verifyCode = mt_rand(1000, 9999);
        $waitTime = null;
        $isCodeSend = false;
        $recaptcha = $request->get('recaptcha');

        $recaptchaCheck = (new RecaptchaService)->check($recaptcha);

        if (!$recaptchaCheck) {
            return redirect()->route('forgot-password.step1')->withErrors([
                'msg' => 'کپچا معتبر نیست',
            ]);
        }

        if (!User::whereMobile($mobile)->exists()) {
            return back()->withErrors([
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
        }

        return view('auth.forgot-step2', compact('waitTime', 'mobile', 'isCodeSend'));
    }

    // forgot password process process
    public function forgotPasswordProcess(Request $request) {
        $verifyCode = $request->get('verify_code');
        $mobile = $request->get('mobile');
        $password = $request->get('password');
        $recaptcha = $request->get('recaptcha');

        $recaptchaCheck = (new RecaptchaService)->check($recaptcha);

        if (!$recaptchaCheck) {
            return redirect()->route('forgot-password.step1')->withErrors([
                'msg' => 'کپچا معتبر نیست',
            ]);
        }

        $user = User::whereMobile($mobile)->first();
        if (!$user) {
            return back()->withErrors([
                'msg' => 'شماره موبایل وارد شده صحیح نیست',
            ]);
        }

        if (!VerifyCode::whereMobile($mobile)->whereCode($verifyCode)->exists()) {
            return redirect("auth/forgot-password/confirm?mobile=$mobile")->withErrors([
                'msg' => 'کد تایید وارد شده صحیح نیست',
            ]);
        }

        VerifyCode::whereMobile($mobile)->whereCode($verifyCode)->delete();

        $user->password = Hash::make($password);
        $user->save();
        Auth::login($user);

        return redirect()->intended('/chat');
    }

    private function storeAffiliate($refCode, $userId) {

        if ($refCode == '' or $refCode == null) {
            return false;
        }

        if (Affiliate::whereUserId($userId)->exists()) {
            return false;
        }

        $userByRefCode = User::whereRefCode($refCode)->first();

        if (!$userByRefCode) {
            return false;
        }

        Affiliate::create([
            'referral_id' => $userByRefCode->id,
            'user_id' => $userId
        ]);
    }
}
