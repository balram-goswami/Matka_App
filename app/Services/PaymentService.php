<?php

namespace App\Services;

class PaymentService
{
    protected $pkToken;
    protected $skToken;
    public function __construct() {
        $this->pkToken = 'pk_test_0d39a31dvnBel58308d4';
        $this->skToken = 'sk_test_5d4af5d4lV3W9Qy6d064649bc18a';
    }
    public function doPayment($amount = 0, $currency = 'ZAR') {
        $data = [
            'token' => $this->pkToken,
            'amountInCents' => $amount,
            'currency' => 'ZAR'
        ];
        $secret_key = $this->skToken;
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL,"https://online.yoco.com/v1/charges/");
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_POST, true);
        curl_setopt($ch, CURLOPT_USERPWD, $secret_key . ":");
        curl_setopt($ch, CURLOPT_POSTFIELDS, http_build_query($data));
        $result = curl_exec($ch);
        curl_close($ch);
        return json_decode($result);
    }
}