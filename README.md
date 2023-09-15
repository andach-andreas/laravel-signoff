# Laravel Signoff by Andach

[![Latest Version on Packagist](https://img.shields.io/packagist/v/andach/laravel-signoff.svg?style=flat-square)](https://packagist.org/packages/andach/laravel-signoff)
[![GitHub Tests Action Status](https://img.shields.io/github/actions/workflow/status/andach/laravel-signoff/run-tests.yml?branch=main&label=tests&style=flat-square)](https://github.com/andach/laravel-signoff/actions?query=workflow%3Arun-tests+branch%3Amain)
[![GitHub Code Style Action Status](https://img.shields.io/github/actions/workflow/status/andach/laravel-signoff/fix-php-code-style-issues.yml?branch=main&label=code%20style&style=flat-square)](https://github.com/andach/laravel-signoff/actions?query=workflow%3A"Fix+PHP+code+style+issues"+branch%3Amain)
[![Total Downloads](https://img.shields.io/packagist/dt/andach/laravel-signoff.svg?style=flat-square)](https://packagist.org/packages/andach/laravel-signoff)

This is a Laravel package to add the ability to sign off another model, to have a second signoff, and includes a Javascript signature pad option

It integrates with https://github.com/szimek/signature_pad to provide a simple image if you provide a pad called "sign". 

## Installation

You can install the package via composer:

```bash
composer require andach/laravel-signoff
```

You can publish the migrations with:

```bash
php artisan signoff:install
```

And if desired, can publish the views with:

```
php artisan vendor:publish --tag=signoff-views
```

### Signature Pad

This package integrates with https://github.com/szimek/signature_pad. To use, you should enable the relevant option in the config file and include the Javascript. 

```
npm install --save signature_pad
```

And then include the javascript in ./js/app.js into your ./resources/js/app.js file. 

## Usage

To use, simply add the `MorphToSignoff` trait and `Signoffable` interface to the model you want to be able to sign off.

```
use Andach\LaravelSignoff\Interfaces\Signoffable;
use Andach\Signoff\Traits\MorphToSignoff;

class MyModel extends Model implements Signoffable
{
    use MorphToSignoff;

    // ...
}
```

Then you can call functions as needed:

```
$model = new MyModel();

// Create a signoff requirement.
$model->signoff()->create([
    // The user_id is optional, and specifies who needs to sign off the model. If null, anyone can sign it off.
    'user_id'                    => 123,
    
    // A boolean flag. Note that if not required, the item can still be signed off by another user.
    'is_second_signoff_required' => true,
    
    //Similarly, limits who can provide the second signoff. 
    'second_user_id'             => 456,
]);

// Check if the model has been signed off.
$model->isFirstSignedOff(); // false
$model->isFullySignedOff(); // false

// Sign off the model. 
$model->doFirstSignoff();

// And now...
$model->isFirstSignedOff(); // true
$model->isFullySignedOff(); // false

// Provide second signoff
$model->doSecondSignoff();

// Finally...
$model->isFirstSignedOff(); // true
$model->isFullySignedOff(); // true
```

## Testing

```bash
composer test
```

## License

The MIT License (MIT). Please see [License File](LICENSE.md) for more information.
