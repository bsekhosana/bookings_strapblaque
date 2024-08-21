<?php

return [
    'merchant_id' => env('PAYFAST_MERCHANT_ID', ''),
    'merchant_key' => env('PAYFAST_MERCHANT_KEY', ''),
    'pass_phrase' => env('PAYFAST_PASS_PHRASE', ''),
    'return_url' => env('PAYFAST_RETURN_URL', ''),
    'cancel_url' => env('PAYFAST_CANCEL_URL', ''),
    'notify_url' => env('PAYFAST_NOTIFY_URL', ''),
];
