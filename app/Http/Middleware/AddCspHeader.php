<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;

class AddCspHeader
{
    /**
     * Handle an incoming request.
     *
     * @return mixed
     * @see https://developer.mozilla.org/en-US/docs/Web/HTTP/Headers/Content-Security-Policy
     * @see https://developer.mozilla.org/en-US/docs/Web/HTTP/Headers/Strict-Transport-Security
     * @see https://developer.mozilla.org/en-US/docs/Web/HTTP/Headers/X-XSS-Protection
     * @see https://developer.mozilla.org/en-US/docs/Web/HTTP/Headers/X-Frame-Options
     * @see https://developer.mozilla.org/en-US/docs/Web/HTTP/Headers/X-Content-Type-Options
     * @see https://developer.mozilla.org/en-US/docs/Web/HTTP/Headers/Referrer-Policy
     * @see https://developer.mozilla.org/en-US/docs/Web/HTTP/Headers/Feature-Policy
     */
    public function handle(Request $request, Closure $next)
    {
        $response = $next($request);

        // If response is a binary file, don't add headers
        if ($response instanceof \Symfony\Component\HttpFoundation\BinaryFileResponse || $response instanceof \Symfony\Component\HttpFoundation\StreamedResponse) {
            return $response;
        }

        // If assets don't load from external websites, or even locally, edit the Content-Security-Policy content, or just remove this middleware completely, up to you!
        $csp_header = "default-src 'self'; script-src 'self' 'unsafe-inline' 'unsafe-eval' *.cloudflare.com; img-src 'self' https: data:; style-src 'self' 'unsafe-inline' fonts.googleapis.com cdnjs.cloudflare.com fonts.bunny.net; font-src 'self' fonts.gstatic.com cdnjs.cloudflare.com fonts.bunny.net data:; object-src 'none'; form-action 'self';";

        if (! \App::isLocal()) {
            $csp_header .= ' upgrade-insecure-requests;';
        }

        $response->header('Content-Security-Policy', $csp_header);

        /// Add these to your nginx config:
        // add_header Strict-Transport-Security "max-age=31536000; includeSubDomains; preload" always;
        // add_header X-XSS-Protection "1; mode=block" always;
        // add_header X-Frame-Options "SAMEORIGIN" always;
        // add_header X-Content-Type-Options "nosniff" always;
        // add_header Referrer-Policy "strict-origin-when-cross-origin" always;

        /// Optional (previously known as Feature-Policy):
        // add_header Permissions-Policy "accelerometer=(), camera=(), geolocation=(), gyroscope=(), magnetometer=(), microphone=(), payment=(), usb=()" always;

        return $response;
    }
}
