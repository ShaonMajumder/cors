<?php

namespace ShaonMajumder\Cors\Http\Services;

use Illuminate\Http\Request;

class CorsService
{
    protected $allowedOrigins;

    public function __construct()
    {
        $this->allowedOrigins = array_map('trim', explode(',', config('corsconfig.allowed_origins', 'http://localhost:8000')));
    }

    /**
     * Get the allowed origin based on the request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return string|null
     */
    public function getAllowedOrigin(Request $request, $default=null)
    {
        // $this->allowedOrigins = [
        //     'http://localhost:8000'
        // ];
        $origin = $request->header('Origin');
        return in_array($origin, $this->allowedOrigins) ? $origin : $default;
    }
}
