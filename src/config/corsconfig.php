<?php

return [
    'allowed_methods' => env('CORS_ALLOWED_METHODS', 'GET, POST, PUT, DELETE, OPTIONS'),
    'allowed_origins' => env('CORS_ALLOWED_ORIGINS', 'http://localhost:8000, http://localhost:8001'),
    'allowed_headers' => env('CORS_ALLOWED_HEADERS', 'Content-Type, Authorization, X-CSRF-TOKEN, Referer, X-Origin')
];