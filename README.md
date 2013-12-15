# NAMSHI | SMSCountry


This small library provides support for sending Sms messages via SMSCountry

## Installation

Installation can be done via composer, as the
library is already on [packagist](https://packagist.org/packages/namshi/smscountry).

The library uses semantic versioning for its API,
so it is recommended to use a stable minor version
(1.0, 1.1, etc.) and stick to it when declaring dependencies
through composer:

```
"namshi/smscountry": "1.0.*",
```

Pick major and minor version according to your needs.

## Usage

Using this library is super easy:

``` php
<?php

use Namshi\SMSCountry\Client;

$smsClient = new Client($username, $password, $senderId, $serviceWsdlUrl);

$smsClient->sendSms($phoneNumber, $body);

```
