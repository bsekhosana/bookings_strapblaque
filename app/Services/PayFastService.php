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

    public function __construct()
    {
        $this->merchantId = config('payfast.merchant_id');
        $this->merchantKey = config('payfast.merchant_key');
        $this->passPhrase = config('payfast.pass_phrase');
        $this->returnUrl = config('payfast.return_url');
        $this->cancelUrl = config('payfast.cancel_url');
        $this->notifyUrl = config('payfast.notify_url');
    }

    public function createPayment(array $data)
    {
        $paymentData = [
            'merchant_id' => $this->merchantId,
            'merchant_key' => $this->merchantKey,
            'return_url' => $this->returnUrl,
            'cancel_url' => $this->cancelUrl,
            'notify_url' => $this->notifyUrl,
            'amount' => number_format($data['amount'], 2, '.', ''),
            'item_name' => $data['item_name'],
        ];

        $signature = $this->generateSignature($paymentData);
        $paymentData['signature'] = $signature;

        $urlString = \App::isProduction() ? 'https://www.payfast.co.za/eng/process' : 'https://sandbox.payfast.co.za/onsite/process';

        $response = Http::post($urlString, $paymentData);

        return $response->json();
    }

    public function generateSignature(array $data)
    {
        ksort($data);
        $queryString = http_build_query($data);

        if ($this->passPhrase) {
            $queryString .= '&passphrase='.urlencode($this->passPhrase);
        }

        return md5($queryString);
    }
}
