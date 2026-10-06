# Laravel Tipi Filament Support

Shared Filament-oriented support utilities used by Laravel Tipi Filament packages.

## Requirements

- PHP 8.5+
- Laravel 12

## Installation

```bash
composer require laravel-tipi/filament-support
```

## Validation

`Tipi\Filament\Validation\FilamentValidator` validates data with Laravel's validator and remaps validation errors to a Filament form state path.

```php
use Tipi\Filament\Validation\FilamentValidator;

$data = FilamentValidator::validate(
    data: ['name' => $name],
    rules: ['name' => ['required', 'string']],
    statePath: 'data',
);
```

Use `FilamentValidator::fail()` when a domain failure needs to be attached to a particular form field.

## License

MIT.
