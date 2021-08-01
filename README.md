⚠️ Laravel DB Session Helper is under development - use at your own risk.
# Laravel helper package for the database session driver

[![Latest Version on Packagist](https://img.shields.io/packagist/v/geisi/laravel-db-session-helper.svg?style=flat-square)](https://packagist.org/packages/geisi/laravel-db-session-helper)
[![GitHub Tests Action Status](https://img.shields.io/github/workflow/status/geisi/laravel-db-session-helper/run-tests?label=tests)](https://github.com/geisi/laravel-db-session-helper/actions?query=workflow%3Arun-tests+branch%3Amain)
[![GitHub Code Style Action Status](https://img.shields.io/github/workflow/status/geisi/laravel-db-session-helper/Check%20&%20fix%20styling?label=code%20style)](https://github.com/geisi/laravel-db-session-helper/actions?query=workflow%3A"Check+%26+fix+styling"+branch%3Amain)
[![Total Downloads](https://img.shields.io/packagist/dt/geisi/laravel-db-session-helper.svg?style=flat-square)](https://packagist.org/packages/geisi/laravel-db-session-helper)

This package adds some niceties when using the database session driver in Laravel Projects. Its main purpose is to be
able to filter users by their online state.

It integrates well with Laravel Jetstream applications.

## Installation

You can install the package via composer:

```bash
composer require geisi/laravel-db-session-helper
```

First add HasDatabaseSessions trait to your User model(s):

```php
//User.php
use Illuminate\Foundation\Auth\User as Authenticatable;
use Geisi\LaravelDbSessionHelper\Traits\HasDatabaseSessions

class User extends Authenticatable
{
    use HasDatabaseSessions;
    
    // ...
}
```

You can publish the config file with:
```bash
php artisan vendor:publish --provider="Geisi\LaravelDbSessionHelper\LaravelDbSessionHelperServiceProvider"
```

## Usage

```php
//Query all online users
\App\Models\User::isOnline()->get();
//Query all offline users
\App\Models\User::isOffline()->get();
//Get user online state
var_dump($user->is_online);
// true or false
//Get user last login date
var_dump($user->last_login);
// Carbon instance
```

## Requirements

To be able to run this package you need Laravel >= 8.42.x and PHP => 7.4 or PHP 8.0. In order to query the users session
data the database session driver is needed.

## Configuration

By default the time span to determine if a user is online or offline is 10 minutes. So if a user does not interact with
your application within 10 minutes he is gonna be queried as offline.

You can change this timespan with the login_time_span configuration value.

You can extend or replace our Session model with your own. The only necessary thing to do is to implement the
Geisi\LaravelDbSessionHelper\Contracts\Session contract interface.

## Beta

This package is currently in Beta state. As we cannot guarantee 100% stability and feature safety we don't recommend using this package in production.
Please submit possible bugs under issues.

## Testing

```bash
composer test
```

## Changelog

Please see [CHANGELOG](CHANGELOG.md) for more information on what has changed recently.

## Contributing

Please see [CONTRIBUTING](.github/CONTRIBUTING.md) for details.

## Security Vulnerabilities

Please review [our security policy](../../security/policy) on how to report security vulnerabilities.

## Credits

- [Tim Geisendörfer](https://github.com/geisi)
- [All Contributors](../../contributors)

## License

The MIT License (MIT). Please see [License File](LICENSE.md) for more information.
