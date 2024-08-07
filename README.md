# Azure AD SSO login management for Laravel

[![Latest Version on Packagist](https://img.shields.io/packagist/v/accentinteractive/laravel-logcleaner.svg?style=flat-square)](https://packagist.org/packages/accentinteractive/laravel-logcleaner)
[![Build Status](https://img.shields.io/travis/accentinteractive/laravel-logcleaner/master.svg?style=flat-square)](https://travis-ci.org/accentinteractive/laravel-logcleaner)
[![Quality Score](https://img.shields.io/scrutinizer/g/accentinteractive/laravel-logcleaner.svg?style=flat-square)](https://scrutinizer-ci.com/g/accentinteractive/laravel-logcleaner)
[![Total Downloads](https://img.shields.io/packagist/dt/accentinteractive/laravel-logcleaner.svg?style=flat-square)](https://packagist.org/packages/accentinteractive/laravel-logcleaner)

- [Installation](#installation) 
- [Register a new Azure AD application](#register-a-new-azure-ad-application) 
- [Config settings](#config-settings)

## Installation

You can install the package via composer:

## Step 1

```bash
composer require accentinteractive/laravel-sso
```
## Step 2

Register your application with the Azure portal. You need a valid Microsoft account and the proper authorization for your company.
For a full manual, see [Registering a new Azure AD application](#register-a-new-azure-ad-application). 

## Step 3

Once your have registered the application with Azure AD, add the proper credentials to your .env file. Get the proper IDs and secrets from https://portal.azure.com/

```shell
SSO_ENABLED=true

# App Registrations › Application › Application (client) ID
SSO_CLIENT_ID="YOUR_CLIENT_ID_HERE"

# App Registrations › Application › Directory (tenant) ID
SSO_TENANT_ID="YOUR_TENANT_ID_HERE"

# App Registrations › Application › Client credentials › New client secret
SSO_CLIENT_SECRET="YOUR_CLIENT_SECRET_HERE"

# App Registrations › Application › Redirect URIs (platform 'Web')
SSO_CLIENT_REDIRECT_URL="https://YOURDOMAIN.COM/login"

SSO_AUTH_TENANT=common
```

## Step 4

Add the middleware to your 'web' middleware group to place all endpoints behind SSO, or to another group if you want to guard only several of your endpoints..
`\Accentinteractive\LaravelSso\Http\Middleware\AuthenticateSSO::class,`

For Laravel >10, place it in bootstrap/app.php.
```php
// [...]
->withMiddleware(function (Middleware $middleware) {

    // Register multitenancy middleware
    $middleware->appendToGroup('web', [
        \Accentinteractive\LaravelSso\Http\Middleware\AuthenticateSSO::class,
    ]);
```

For Laravel <=10, place it in app/Http/Kernel.php.
```php
'web' => [
    // [...]
    \Accentinteractive\LaravelSso\Http\Middleware\AuthenticateSSO::class,
],
```

## Step 5

Optionally you can publish the config file with:
```
php artisan vendor:publish --provider="Accentinteractive\LaravelSso\LaravelSsoServiceProvider" --tag="config"
```

## Register a new Azure AD application

For Azure AD Single Sign On to work properly, you must supply the following Azure AD credentials in your .env file:
- `Application (client) ID`
- `Directory (tenant) ID`
- `Client Secret`
- `Redirect URI`

Important: your Client Secret has an expiration date. Before the secret expires, make sure to create another new secret and supply it in in .env, so you employees can continue to log using SSO. A good expiration time would be 12 or 24 months.

- To create the Azure AD Plan Ahead application. IDs and secrets, do the following;
    - Go to Azure AD while logged in as Microsoft User for your organization: https://portal.azure.com/.
    - Go to App Registrations (https://portal.azure.com/#view/Microsoft_AAD_RegisteredApps/ApplicationsListBlade).
    - Click 'New Registration' to add your application.
      - Enter a name.
      - Select 'Accounts in this organizational directory only'.
      - Click 'Register'.
    - Make note of the `Application (client) ID`
    - Make note of the `Directory (tenant) ID`
    - Click 'Redirect URIs'.
        - Under 'Web', click 'Add URI'.
        - Enter the correct redirect URI (https://YOURDOMAIN.COM/login) and hit [ENTER]
        - Make note of the redirect URL.
    - Go back to the app Registration and click 'Client Credentials'.
        - Click 'New Client Secret'.
        - Enter a name for the secret.
        - Choose an expiry period (maximum 24 months).
        - Click 'Add'.
        - Make note of the 'Value' for your Client secret. Important: You can only view a secret once, directly after creation.
    - Go back to the app Registration and go to Manage › Manifest.
      - In the XML, edit "allowPublicClient" to say false.
      - In the XML, edit "oauth2AllowIdTokenImplicitFlow" to say true.
      - Click Save.
    - Before the secret expires, make sure to create another new secret and enter it to to your .env file in time, so you can continue to log with SSO.

## Config settings
You can pass config settings to modify the behaviour.

You can also pass options directly. 

### Testing

``` bash
composer test
```

### Changelog

Please see [CHANGELOG](CHANGELOG.md) for more information what has changed recently.

## Contributing

Please see [CONTRIBUTING](CONTRIBUTING.md) for details.

### Security

If you discover any security related issues, please email joost@accentinteractive.nl instead of using the issue tracker.

## Credits

- [Joost van Veen](https://github.com/accentinteractive)
- [All Contributors](../../contributors)

## License

The MIT License (MIT). Please see [License File](LICENSE.md) for more information.
