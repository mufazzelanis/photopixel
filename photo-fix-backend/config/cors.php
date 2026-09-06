<?php

return [

    /*
     * Public content API + form submissions are consumed by the React SPA
     * running on a separate origin (Vite dev server / production host).
     */

    /*
     * `livewire/*` and `storage/*` are included so the Filament admin panel's
     * file uploads keep working when the panel is opened on a host that differs
     * from APP_URL (e.g. 127.0.0.1 vs localhost) — otherwise the browser blocks
     * the upload / preview requests and the uploader spins forever.
     */
    'paths' => ['api/*', 'sanctum/csrf-cookie', 'livewire/*', 'storage/*'],

    'allowed_methods' => ['*'],

    'allowed_origins' => array_filter(explode(',', (string) env(
        'FRONTEND_ORIGINS',
        'http://localhost:5173,http://127.0.0.1:5173'
    ))),

    /*
     * In local development the Vite dev server may land on any free port
     * (5173, 5174, 5175, ...). Accept any localhost origin while APP_ENV=local.
     */
    'allowed_origins_patterns' => env('APP_ENV') === 'local'
        ? ['#^http://(localhost|127\.0\.0\.1):\d+$#']
        : [],

    'allowed_headers' => ['*'],

    'exposed_headers' => [],

    'max_age' => 3600,

    'supports_credentials' => false,

];
