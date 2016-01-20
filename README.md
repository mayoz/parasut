# Parasut

**An easy-to-use Parasut's API with PHP.**

[![Latest Version on Packagist](https://img.shields.io/packagist/v/mayoz/parasut.svg?style=flat-square)](https://packagist.org/packages/mayoz/parasut)
[![Software License](https://img.shields.io/badge/license-MIT-brightgreen.svg?style=flat-square)](LICENSE.md)
[![Build Status](https://img.shields.io/travis/mayoz/parasut/master.svg?style=flat-square)](https://travis-ci.org/mayoz/parasut)

## Install

Via Composer

``` bash
$ composer require mayoz/parasut
```

## Usage

The following gateways are provided by this documentation:

 * [parasut](https://www.parasut.com/)

```php
<?php

include 'vendor/autoload.php';

use Parasut\Client;

// create a new client instance
$parasut = new Client([
    'client_id'     => 'YOUR-CLIENT-ID',
    'client_secret' => 'YOUR-CLIENT-SECRET',
    'username'      => 'YOUR-USERNAME',
    'password'      => 'YOUR-PASSWORD',
    'company_id'    => 'YOUR-COMPANY-ID',
    'grant_type'    => 'password',
    'redirect_uri'  => 'urn:ietf:wg:oauth:2.0:oob',
]);

// authorization request
$parasut->authorize();

// create a new contact
$contact = $parasut->make('contact')->create([
    'name'         => 'ABC LTD. STI.',
    'contact_type' => 'company',
    'email'        => 'user@example.com',
    'tax_number'   => '1234567890',
    'tax_office'   => 'Beyoglu',
    'category_id'  => null,
    'address_attributes' => [
        'address' => 'Guzel Mahalle Istanbul',
        'phone'   => '123 123 4567'
        'fax'     => null,
    ],
    'contact_people_attributes' => [
        [
            'name'  => 'Ahmet Bilir',
            'phone' => '532 123 4567',
            'email' => 'person@example.com',
            'notes' => 'Muhasebe Sorumlusu',
        ],
    ],
]);

// the contact token value
$contactToken = $contact['contact']['id'];

// create a new purchase bill
$purchase = $parasut->make('purchase')->create([
    'description'    => 'Büyük tedarikçi techizat alımı',
    'invoice_id'     => '1',
    'invoice_series' => 'A',
    'item_type'      => 'invoice',
    'issue_date'     => '2016-01-15',
    'contact_id'     => $contactToken,
    'category_id'    => null,
    'archived'       => null,
    'details_attributes' => [
        [
            'product_id'     => 9, // the parasut products
            'quantity'       => 1,
            'unit_price'     => 100,
            'vat_rate'       => 18,
            'discount_type'  => 'amount',
            'discount_value' => 0,
        ],
    ],
]);

// the billing token value
$purchaseToken = $purchase['purchase_invoice']['id'];

// pay the bill
$paid = $parasut->make('purchase')->paid($purchaseToken, [
    'account_id'    => 12,
    'amount'        => 118,
    'exchange_rate' => '1.0'
    'date'          => '2016-01-20',
    'description'   => 'Your paid description',
]);

var_dump($paid);
```

For general usage instructions, please see the main [Parasut](https://api.parasut.com/docs) api documentation.

## Security

If you discover any security related issues, please email srcnckr@gmail.com instead of using the issue tracker.

## Credits

- [Sercan Çakır](https://github.com/mayoz)
- [All Contributors](../../contributors)

## License

The MIT License (MIT). Please see [License File](LICENSE.md) for more information.
