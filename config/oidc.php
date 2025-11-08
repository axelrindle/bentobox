<?php

return [

    /*
    |--------------------------------------------------------------------------
    | OpenID Endpoint Configuration
    |--------------------------------------------------------------------------
    |
    | Most identity providers (IdP) expose a discovery endpoint which serves
    | information about certain well-known endpoints. Specify the endpoint
    | and whether to verify ssl certificates during requests.
    |
    | Example: "https://iam.bento.local/realms/bento/.well-known/openid-configuration"
    |
    */

    'discovery' => env('OIDC_DISCOVERY_ENDPOINT'),
    'verify_certs' => (bool) env('OIDC_VERIFY_CERTS', true),

    /*
    |--------------------------------------------------------------------------
    | Client Credentials
    |--------------------------------------------------------------------------
    |
    | This options are used to specify the client credentials the application
    | uses to authenticate against the IdP and to request user authentication
    | with the IdP.
    |
    */

    'client_id' => env('OIDC_CLIENT_ID'),
    'client_secret' => env('OIDC_CLIENT_SECRET'),

    /*
    |--------------------------------------------------------------------------
    | Scopes
    |--------------------------------------------------------------------------
    |
    | Scopes define what kind of information about a user is returned
    | from the IdP to the application. We require certain defaults to be
    | respected by the IdP. Furthermore values and data may differ between
    | different IdPs. Consult your IdP for more information.
    |
    | Values *must* be comma-separated.
    |
    */

    'scopes' => env('OIDC_SCOPES', 'openid,email,profile'),

];
