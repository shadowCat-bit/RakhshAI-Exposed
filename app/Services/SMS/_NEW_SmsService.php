<?php

namespace App\Services\SMS;

use Throwable;

class SmsService {

    private $apiKey = "7641n507a97252f9682dba10";

    /**
     * send verify code.
     */
    public function sendVerifyCode($mobile, $code) {
        try {
            date_default_timezone_set("Asia/Tehran");

            $curl = curl_init();
            curl_setopt_array(
                $curl,
                [
                    CURLOPT_URL => 'https://api.sms.ir/v1/send/verify',
                    CURLOPT_RETURNTRANSFER => true,
                    CURLOPT_ENCODING => '',
                    CURLOPT_MAXREDIRS => 10,
                    CURLOPT_TIMEOUT => 0,
                    CURLOPT_FOLLOWLOCATION => true,
                    CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
                    CURLOPT_CUSTOMREQUEST => 'POST',
                    CURLOPT_POSTFIELDS => '{"mobile": "' . $mobile . '","templateId": 74947,"parameters": [{"name": "code","value": "' . $code . '"}]}',
                    CURLOPT_HTTPHEADER => ['Content-Type: application/json', 'Accept: text/plain', 'x-api-key: ' . $this->apiKey],
                ]
            );
            $response = curl_exec($curl);
            curl_close($curl);

            dd($response);

            return ['data' => ['result' => true, 'msg' => $response], 'resCode' => 200];
        } catch (Throwable $e) {

            dd($e);
            return ['data' => ['result' => false, 'error' => $e->getMessage()], 'resCode' => 500];
        }
    }
}
