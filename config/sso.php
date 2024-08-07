<?php

return [
    /*
     * Enable or disable Single Sign On.
     */
    'enabled' => env('SSO_ENABLED', false),

    /*
     * Register your application at https://portal.azure.com
     * Copy the 'Application (client) ID'.
     * For a full manual see README.
     */
    'client_id' => env('SSO_CLIENT_ID'),

    /*
     * Register your application at https://portal.azure.com
     * Copy the 'Directory (tenant) ID'.
     * For a full manual see README.
     */
    'tenant_id' => env('SSO_TENANT_ID'),

    /*
     * Register your application at https://portal.azure.com
     * Register a new Client secret for the application.
     * Copy the 'Value' of the new Client secret.
     * For a full manual see README.
     */
    'client_secret' => env('SSO_CLIENT_SECRET'),

    /*
     * Register your application at https://portal.azure.com
     * Register a new Redirect URI for the application (Web).
     * Copy the redirect URL for the application.
     * For a full manual see README.
     */
    'client_redirect_url' => env('SSO_CLIENT_REDIRECT_URL'),

    /*
     * Is always 'common'.
     */
    'auth_tenant' => env('SSO_AUTH_TENANT', 'common'),
];
