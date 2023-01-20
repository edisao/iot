<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Log;
use Illuminate\Http\Request;

use App\Helpers\Constants;
use App\Libraries\AuthUtil;

class LogContextMiddleware
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle(Request $request, Closure $next)
    {
        $authUtil = new AuthUtil();
        $constants = new Constants();

        $session_id = $authUtil->getServiceContextValue($constants->contextSessionId);
        $sitio = $authUtil->getServiceContextValue($constants->contextSitio);
        $username = $authUtil->getServiceContextValue($constants->contextUsername);
        Log::withContext(['Sitio' => $sitio, 'Username' => $username, 'SessionId' => $session_id]);
        //Log::withContext(['uuid' => (string) Str::uuid()]);
        return $next($request);
    }
}
