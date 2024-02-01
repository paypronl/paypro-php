# PayPro PHP Library

[![build](https://github.com/paypronl/paypro-php/actions/workflows/build.yml/badge.svg?branch=master)](https://github.com/paypronl/paypro-php/actions/workflows/build.yml)
[![License: MIT](https://img.shields.io/badge/License-MIT-blue.svg)](https://opensource.org/licenses/MIT)

The PayPro PHP library can be used to make integrating with the PayPro API easier when using PHP.
It provides easy to use classes to interact with all resources available through the API.

It also provides the following:

- Built-in pagination support
- Easy configuration
- Webhook request verification helpers

## Requirements

- PHP >= 7.2

## Installation

### Composer

You can install the library through [Composer](https://getcomposer.org/)

```sh
composer require paypro/paypro-php
```

To use the library, use Composer to autoload:

```php
require_once 'vendor/autoload.php';

```

### Manually

If you don't use Composer you can download the files from GitHub. To use the libary require the `init.php` file

```php
require_once '/path/to/paypro-php/init.php';
```

## Dependencies

The library requires the following dependencies:

- [curl](https://secure.php.net/manual/en/book.curl.php)
- [json](https://secure.php.net/manual/en/book.json.php)

## Getting started

In order to use the API you need to have a valid API key.
You can find your API key in the [PayPro dashboard](https://app.paypro.nl/developers/api-keys)

Example of using the API:

```php
$paypro = new \PayPro\Client('pp_...');

# Creating a payment
$payment = $paypro->payments->create(['amount' => 500, 'currency' => 'EUR', 'description' => 'Test Payment']);

# Retrieving all subscriptions
$subscriptions = $paypro->subscriptions->list();

# Retrieving a single customer
$customer = $paypro->customers->get('CUSSDGDCJVZH5K');

```

## Development

If you want to contribute to this project you can fork the repository. Create a new branch, add your feature and create a pull request. We will look at your request and determine if we want to add it.

To run all the tests with [PHPUnit](https://phpunit.de/):

```sh
./vendor/bin/phpunit
```

To run the [code formatter](https://cs.symfony.com/):

```sh
./vendor/bin/php-cs-fixer fix -v .
```

To analyze the code with [PHPStan](https://phpstan.org/)

```sh
bin/console
```
