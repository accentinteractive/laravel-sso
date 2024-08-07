# Azure AD SSO login management for Laravel

[![Latest Version on Packagist](https://img.shields.io/packagist/v/accentinteractive/laravel-logcleaner.svg?style=flat-square)](https://packagist.org/packages/accentinteractive/laravel-logcleaner)
[![Build Status](https://img.shields.io/travis/accentinteractive/laravel-logcleaner/master.svg?style=flat-square)](https://travis-ci.org/accentinteractive/laravel-logcleaner)
[![Quality Score](https://img.shields.io/scrutinizer/g/accentinteractive/laravel-logcleaner.svg?style=flat-square)](https://scrutinizer-ci.com/g/accentinteractive/laravel-logcleaner)
[![Total Downloads](https://img.shields.io/packagist/dt/accentinteractive/laravel-logcleaner.svg?style=flat-square)](https://packagist.org/packages/accentinteractive/laravel-logcleaner)

- [Installation](#installation) 
- [Examples](#usage) 
- [Config settings](#config-settings)

## Installation

You can install the package via composer:

```bash
composer require accentinteractive/laravel-sso
```

Optionally you can publish the config file with:
```
php artisan vendor:publish --provider="Accentinteractive\LaravelSso\LaravelSsoServiceProvider" --tag="config"
```

Add the middleware to your 'web' middleware group to place all endpoints behind SSO.
`\App\Http\Middleware\AuthenticateSSO::class,`


## Usage

- Set SSO in the tenant's .env file. Example: `_env_files/local/accent.env`
- For local environments, simply copy the SSO credentials from _env_files/local/accent.env`.
- See https://portal.azure.com/#view/Microsoft_AAD_RegisteredApps/ApplicationMenuBlade/~/Overview/appId/37bb4827-3f9c-4fc6-b7e8-16659b98442e/isMSAApp~/false
- To create an Azure AD app (manual for clients):
    - For Azure AD Single Sign On to work properly, you must supply the following Azure AD credentials to Accent Interactive:
        - `Application (client) ID`
        - `Directory (tenant) ID`
        - `Client Secret` (you can create one under 'Client Credentials')
        - `Redirect URI` (you can create one under 'Redirect URIs')
    - Important: your Client Secret has an expiration date. Before the secret expires, make sure to create another new secret and supply it to Accent Interactive in time, so your employees can continue to log into Plan Ahead. A good expiration time would be 12 or 24 months.
    - To create the Azure AD Plan Ahead application. IDs and secrets, do the following;
        - Go to Azure AD while logged in as Microsoft User: https://portal.azure.com/.
        - Go to Azure Active Directory › App Registrations.
        - Add New Registration for Plan Ahead. Name it: `planahead.nl`
        - Make note of the `Application (client) ID`
        - Make note of the `Application (client) ID`
        - Click 'Redirect URIs'.
            - For every Plan Ahead instance, create the proper Redirect URI and click save. Make note of the redirect URL.
            - A proper redirect URI has the syntax `https://YOURTENANT.planahead.nl/login`
        - Go back to the Registration for Plan Ahead and click 'Client Credentials'.
            - For every Plan Ahead instance, create a 'New Client Secret' and make note of the client secret.
            - Important: You can only view a secret in Azure AD immediately after creation.
            - Before the secret expires, make sure to create another new secret and supply it to Accent Interactive in time, so your employees can continue to log into Plan Ahead.
            - A good expiration time would be 12 or 24 months.

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
