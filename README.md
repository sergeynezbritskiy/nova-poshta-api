# NovaPoshta API

Library for connecting your PHP application with NovaPoshta API

[![Scrutinizer Code Quality](https://scrutinizer-ci.com/g/sergeynezbritskiy/nova-poshta-api/badges/quality-score.png?b=master)](https://scrutinizer-ci.com/g/sergeynezbritskiy/nova-poshta-api/?branch=master)
[![Code Coverage](https://scrutinizer-ci.com/g/sergeynezbritskiy/nova-poshta-api/badges/coverage.png?b=master)](https://scrutinizer-ci.com/g/sergeynezbritskiy/nova-poshta-api/?branch=master)
[![Build Status](https://scrutinizer-ci.com/g/sergeynezbritskiy/nova-poshta-api/badges/build.png?b=master)](https://scrutinizer-ci.com/g/sergeynezbritskiy/nova-poshta-api/build-status/master)
[![Code Intelligence Status](https://scrutinizer-ci.com/g/sergeynezbritskiy/nova-poshta-api/badges/code-intelligence.svg?b=master)](https://scrutinizer-ci.com/code-intelligence)

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

## Configuration

In order to use this library you need to generate an API key **[here](https://new.novaposhta.ua/)**
in `Налаштування` -> `Безпека` -> `Створити ключ`:

## Usage

Using library is as easy as possible

```php
//create client for connecting with API
$client = new \SergeyNezbritskiy\NovaPoshta\Client('<your_api_key>');
//run the request
$result = $client->address->getCities();
```

## Notes

For more details please visit [https://developers.novaposhta.ua/documentation]
