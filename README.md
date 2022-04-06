# Control your Laravel feature flags through a clean Filament interface.

[![Latest Version on Packagist](https://img.shields.io/packagist/v/ryangjchandler/filament-feature-flags.svg?style=flat-square)](https://packagist.org/packages/ryangjchandler/filament-feature-flags)
[![GitHub Tests Action Status](https://img.shields.io/github/workflow/status/ryangjchandler/filament-feature-flags/run-tests?label=tests)](https://github.com/ryangjchandler/filament-feature-flags/actions?query=workflow%3Arun-tests+branch%3Amain)
[![GitHub Code Style Action Status](https://img.shields.io/github/workflow/status/ryangjchandler/filament-feature-flags/Check%20&%20fix%20styling?label=code%20style)](https://github.com/ryangjchandler/filament-feature-flags/actions?query=workflow%3A"Check+%26+fix+styling"+branch%3Amain)
[![Total Downloads](https://img.shields.io/packagist/dt/ryangjchandler/filament-feature-flags.svg?style=flat-square)](https://packagist.org/packages/ryangjchandler/filament-feature-flags)

This packages provide a graphical wrapper around [ryangjchandler/laravel-feature-flags](https://github.com/ryangjchandler/laravel-feature-flags).

## Installation

You can install the package via Composer:

```bash
composer require ryangjchandler/filament-feature-flags
```

You should also follow the [installation instructions for underlying package](https://github.com/ryangjchandler/laravel-feature-flags#installation);

## Usage

Once installed, this package will register a new "Features" resource.

![Empty resource](art/empty-resource.png)

### Adding a new flag

To add a new flag, click the "Add Feature" button and you'll be presented with a form.

![Empty create form](art/create-form.png)

The only _required_ field in the form is the "Name" field. The "Description" field is optional and only serves as metadata for users.

You can toggle the value of flag by switching the toggle input labelled "Enabled".

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

- [Ryan Chandler](https://github.com/ryangjchandler)
- [All Contributors](../../contributors)

## License

The MIT License (MIT). Please see [License File](LICENSE.md) for more information.
