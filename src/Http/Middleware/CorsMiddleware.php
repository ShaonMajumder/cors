<?php

namespace ShaonMajumder\Cors\Http\Middleware;

use Shaonmajumder\Cors\Http\Services\CorsService;
use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\StreamedResponse;

class CorsMiddleware
{
    protected $corsService;
    protected $allowedRequestMethods;
    protected $allowedRequestHeaders;

    public function __construct(CorsService $corsService)
    {
        $this->corsService = $corsService;
        $this->allowedRequestMethods = config('corsconfig.allowed_methods', 'GET, POST, PUT, DELETE, OPTIONS');
        $this->allowedRequestHeaders = config('corsconfig.allowed_headers', 'Content-Type, Authorization, X-CSRF-TOKEN, Referer, X-Origin');
    }

    public function handle(Request $request, Closure $next)
    {
        // Handle OPTIONS request
        if ($request->getMethod() == 'OPTIONS') {
            return response()->json('OK')
                ->header('Access-Control-Allow-Origin', $this->corsService->getAllowedOrigin($request))
                ->header('Access-Control-Allow-Methods', $this->allowedRequestMethods)
                ->header('Access-Control-Allow-Headers', $this->allowedRequestHeaders)
                ->header('Access-Control-Allow-Credentials', 'true');
        }

        // Handle other requests (POST, GET, etc.)
        $response = $next($request);

        if ($response instanceof StreamedResponse) {
            $response->headers->set('Access-Control-Allow-Origin', $this->corsService->getAllowedOrigin($request)) ;
        } else {
            $response->header('Access-Control-Allow-Origin', $this->corsService->getAllowedOrigin($request))
                ->header('Access-Control-Allow-Methods', $this->allowedRequestMethods)
                ->header('Access-Control-Allow-Headers', $this->allowedRequestHeaders)
                ->header('Access-Control-Allow-Credentials', 'true');
        }

        return $response;
    }
}
