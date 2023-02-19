# NovaPoshta API

Library for connecting your PHP application with NovaPoshta API

[![Build Status](https://travis-ci.org/sergeynezbritskiy/nova-poshta-api.svg?branch=master)](https://travis-ci.org/sergeynezbritskiy/nova-poshta-api)
[![Latest Stable Version](https://poser.pugx.org/sergeynezbritskiy/nova-poshta-api/v/stable)](https://packagist.org/packages/sergeynezbritskiy/nova-poshta-api)
[![Total Downloads](https://poser.pugx.org/sergeynezbritskiy/nova-poshta-api/downloads)](https://packagist.org/packages/sergeynezbritskiy/nova-poshta-api)
[![Latest Unstable Version](https://poser.pugx.org/sergeynezbritskiy/nova-poshta-api/v/unstable)](https://packagist.org/packages/sergeynezbritskiy/nova-poshta-api)
[![License](https://poser.pugx.org/sergeynezbritskiy/nova-poshta-api/license)](https://packagist.org/packages/sergeynezbritskiy/nova-poshta-api)

## Installation

The easiest way to install module is using Composer

```
composer require sergeynezbritskiy/nova-poshta-api"
```

## Notes

For more details please visit [https://developers.novaposhta.ua/documentation]

## Simple usage

Using library is as easy as possible

```php
//create client for connecting with API
$client = new \SergeyNezbritskiy\nova-poshta\Client('<your_api_key>');
//run the request
$result = $client->balance();
```
