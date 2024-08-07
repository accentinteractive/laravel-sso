<?php

return [
    'enabled' => env('SSO_ENABLED'),
    'client_id' => env('SSO_CLIENT_ID'),
    'tenant_id' => env('SSO_TENANT_ID'),
    'client_secret' => env('SSO_CLIENT_SECRET'),
    'client_redirect_url' => env('SSO_CLIENT_REDIRECT_URL'),
    'auth_tenant' => env('SSO_AUTH_TENANT'),
];
