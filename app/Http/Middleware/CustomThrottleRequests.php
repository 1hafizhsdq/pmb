<?php
namespace App\Http\Middleware;

use Illuminate\Routing\Middleware\ThrottleRequests as BaseThrottleRequests;
use Illuminate\Http\Request;

class CustomThrottleRequests extends BaseThrottleRequests
{
    protected function resolveRequestSignature($request)
    {
        return sha1($request->ip() . '|' . $request->userAgent());
    }

    protected function resolveMaxAttempts($request, $maxAttempts)
    {
        return $maxAttempts;
    }

    protected function resolveDecayMinutes($request, $decayMinutes)
    {
        return $decayMinutes;
    }
}