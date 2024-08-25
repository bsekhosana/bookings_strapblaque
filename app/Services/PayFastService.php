<?php

namespace App\Services;

use Illuminate\Support\Facades\Http;

class PayFastService
{
    protected $merchantId;

    protected $merchantKey;

    protected $passPhrase;

    protected $returnUrl;

    protected $cancelUrl;

    protected $notifyUrl;

    protected $testUrl = 'https://4d9c-41-122-7-49.ngrok-free.app';

    public function __construct()
    {
        $this->merchantId = config('payfast.merchant_id');
        $this->merchantKey = config('payfast.merchant_key');
        $this->passPhrase = config('payfast.pass_phrase');
        // $this->returnUrl = config('payfast.return_url');
        // $this->cancelUrl = config('payfast.cancel_url');
        // $this->notifyUrl = config('payfast.notify_url');

        $this->returnUrl = \App::isProduction() ? config('payfast.return_url') : "$this->testUrl/payfast/return";
        $this->cancelUrl = \App::isProduction() ? config('payfast.cancel_url') : "$this->testUrl/admin/payment/cancel";
        $this->notifyUrl = \App::isProduction() ? config('payfast.notify_url') : "$this->testUrl/payfast/notify";
    }

    public function createPayment(array $data)
    {
        // Prepare payment data
        $paymentData = array_merge($data, [
            'merchant_id' => $this->merchantId,
            'merchant_key' => $this->merchantKey,
            'return_url' => $this->returnUrl,
            'cancel_url' => $this->cancelUrl,
            'notify_url' => $this->notifyUrl,
            'amount' => number_format($data['amount'], 2, '.', ''),
            'item_name' => $data['item_name'],
            'subscription_type' => 1,
            'cycles' => 0,
            'frequency' => 3
        ]);

        // Generate signature for security
        $signature = $this->generateSignature($paymentData);
        $paymentData['signature'] = $signature;

        return $paymentData;
    }


    public function createSubscriptionRepaymentData(array $data)
    {
        $subscriptionData = array_merge($data, [
            'merchant_id' => $this->merchantId,
            'merchant_key' => $this->merchantKey,
            'return_url' => $this->returnUrl,
            'cancel_url' => $this->cancelUrl,
            'notify_url' => $this->notifyUrl,
        ]);

        if ($this->passPhrase) {
            $subscriptionData['passphrase'] = $this->passPhrase;
        }

        $signature = $this->generateSignature($subscriptionData);
        $subscriptionData['signature'] = $signature;

        return $subscriptionData;
    }

    public function generateSignature($data)
    {
        $passPhrase = config('payfast.pass_phrase');

        if ($passPhrase !== null) {
            $data['passphrase'] = $passPhrase;
        }

        // Sort the array by key, alphabetically
        ksort($data);

        //create parameter string
        $pfParamString = http_build_query($data);

        return md5($pfParamString);
    }

    public function validateSignature($data)
    {
        $signature = $data['signature'];
        unset($data['signature']);

        return $signature === $this->generateSignature($data);
    }

}
