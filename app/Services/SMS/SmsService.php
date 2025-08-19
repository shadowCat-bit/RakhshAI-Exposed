<?php

namespace App\Services\SMS;

use Throwable;

class SmsService {

    private $APIKey = "7642c507a61651f9682nb114";
    private $SecretKey = "mseter-pester";
    private $APIURL = "https://ws.sms.ir/";

    /**
     * Gets API Ultra Fast Send Url.
     *
     * @return string Indicates the Url
     */
    protected function getAPIUltraFastSendUrl() {
        return "api/UltraFastSend";
    }

    /**
     * Gets Api Token Url.
     *
     * @return string Indicates the Url
     */
    protected function getApiTokenUrl() {
        return "api/Token";
    }

    /**
     * Ultra Fast Send Message.
     *
     * @param data[] $data array structure of message data
     * 
     * @return string Indicates the sent sms result
     */
    public function ultraFastSend($data) {
        $token = $this->_getToken($this->APIKey, $this->SecretKey);
        if ($token != false) {
            $postData = $data;

            $url = $this->APIURL . $this->getAPIUltraFastSendUrl();
            $UltraFastSend = $this->_execute($postData, $url, $token);

            $object = json_decode($UltraFastSend);

            $result = false;
            if (is_object($object)) {
                $result = $object->Message;
            } else {
                $result = false;
            }
        } else {
            $result = false;
        }
        return $result;
    }

    /**
     * Gets token key for all web service requests.
     *
     * @return string Indicates the token key
     */
    private function _getToken() {
        $postData = [
            'UserApiKey' => $this->APIKey,
            'SecretKey' => $this->SecretKey,
            'System' => 'php_rest_v_2_0'
        ];
        $postString = json_encode($postData);

        $ch = curl_init($this->APIURL . $this->getApiTokenUrl());
        curl_setopt(
            $ch,
            CURLOPT_HTTPHEADER,
            ['Content-Type: application/json']
        );
        curl_setopt($ch, CURLOPT_HEADER, false);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, false);
        curl_setopt($ch, CURLOPT_POSTFIELDS, $postString);

        $result = curl_exec($ch);
        curl_close($ch);

        $response = json_decode($result);

        $resp = false;
        $IsSuccessful = '';

        $TokenKey = '';

        if (is_object($response)) {
            $IsSuccessful = $response->IsSuccessful;
            if ($IsSuccessful == true) {
                $TokenKey = $response->TokenKey;
                $resp = $TokenKey;
            } else {
                $resp = false;
            }
        }
        return $resp;
    }

    /**
     * Executes the main method.
     *
     * @param postData[] $postData array of json data
     * @param string     $url      url
     * @param string     $token    token string
     * 
     * @return string Indicates the curl execute result
     */
    private function _execute($postData, $url, $token) {
        $postString = json_encode($postData);

        $ch = curl_init($url);
        curl_setopt(
            $ch,
            CURLOPT_HTTPHEADER,
            ['Content-Type: application/json', 'x-sms-ir-secure-token: ' . $token]
        );
        curl_setopt($ch, CURLOPT_HEADER, false);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, false);
        curl_setopt($ch, CURLOPT_POSTFIELDS, $postString);

        $result = curl_exec($ch);
        curl_close($ch);

        return $result;
    }

    /**
     * send verify code.
     */
    public function sendVerifyCode($mobile, $code) {
        try {
            date_default_timezone_set("Asia/Tehran");
            $data = [
                "ParameterArray" => [
                    [
                        "Parameter" => "code",
                        "ParameterValue" => $code
                    ]
                ],
                "Mobile" => $mobile,
                "TemplateId" => "74947"
            ];
            $result = $this->ultraFastSend($data);
            return ['data' => ['result' => true, 'msg' => $result], 'resCode' => 200];
        } catch (Throwable $e) {
            return ['data' => ['result' => false, 'error' => $e->getMessage()], 'resCode' => 500];
        }
    }
}
