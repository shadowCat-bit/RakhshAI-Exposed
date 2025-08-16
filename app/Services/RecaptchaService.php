<?php

namespace App\Services;

use App\Models\Character;
use App\Models\Option;
use App\Models\Tone;
use GuzzleHttp\Client as GuzzleClient;
use Illuminate\Support\Facades\Http;
use OpenAI;
use Psr\Http\Message\RequestInterface;
use Psr\Http\Message\ResponseInterface;

class RecaptchaService {

    // check is recaptcha is valid or not
    public function check($recaptcha) {

        if (env('APP_ENV') === 'local') {
            return true;
        }

        $siteVerify = Http::asForm()
            ->post('https://www.google.com/recaptcha/api/siteverify', [
                'secret' => config('services.recaptcha.secret'),
                'response' => $recaptcha,
            ]);

        if ($siteVerify->failed()) {
            return false;
        }

        if ($siteVerify->successful()) {
            $body = $siteVerify->json();

            if ($body['success'] !== true) {
                return false;
            }

            if ($body['score'] < 0.3) {
                return false;
            }

            return true;
        }
    }
}
