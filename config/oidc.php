<?php

return [

    'discovery' => env('OIDC_DISCOVERY_ENDPOINT'),
    'verify_certs' => (bool) env('OIDC_VERIFY_CERTS', true),

    'client_id' => env('OIDC_CLIENT_ID'),
    'client_secret' => env('OIDC_CLIENT_SECRET'),

    'scopes' => env('OIDC_SCOPES', 'openid'),

];
