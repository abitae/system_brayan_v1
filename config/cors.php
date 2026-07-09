<?php

$allowedOrigins = array_values(array_filter(array_map(
    'trim',
    explode(',', (string) env('FRONTEND_ALLOWED_ORIGINS', 'http://localhost:5173,http://127.0.0.1:8000'))
)));

return [
    'paths' => ['api/*'],
    'allowed_methods' => ['GET', 'OPTIONS'],
    'allowed_origins' => $allowedOrigins,
    'allowed_origins_patterns' => [],
    'allowed_headers' => ['*'],
    'exposed_headers' => [],
    'max_age' => 0,
    'supports_credentials' => false,
];
