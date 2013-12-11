# NAMSHI | Smscountry


This small library provides support for sending Sms messages via Smscountry

## Installation

You can install this library via composer: have a look
at the [package on packagist](https://packagist.org/packages/namshi/smscountry).

÷nclude it into your `composer.json`:

```
"namshi/smscountry": "1.0.*",
```

Pick major and minor version according to your needs.

## Usage

Using this library is super easy:

``` php
<?php

use Namshi\Smscountry\Client;

$smsClient = new Client($username, $password, $senderId, $serviceWsdlUrl);

$smsClient->sendSms($phoneNumber, $body);

```
