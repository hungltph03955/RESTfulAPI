<?php

namespace App\Http\Middleware;

use Closure;
use App\Traits\ApiResponser;
use Illuminate\Http\Response;
use Illuminate\Routing\Middleware\ThrottleRequests;

class CustomThrottleRequests extends ThrottleRequests
{
    use ApiResponser;

    protected function buildResponse($key, $maxAttempts)
    {
        $response = $this->errorResponse('Too Many Attempts', Response::HTTP_TOO_MANY_REQUESTS);
        $retryAfter = $this->limiter->availableIn($key);
        return $this->addHeaders(
            $response, $maxAttempts,
            $this->calculateRemainingAttempts($key, $maxAttempts, $retryAfter),
            $retryAfter
        );
    }
}
