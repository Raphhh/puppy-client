# Puppy Client

[![Latest Stable Version](https://poser.pugx.org/raphhh/puppy-client/v/stable.svg)](https://packagist.org/packages/raphhh/puppy-client)
[![Build Status](https://travis-ci.org/Raphhh/puppy-client.png)](https://travis-ci.org/Raphhh/puppy-client)
[![Code Coverage](https://scrutinizer-ci.com/g/Raphhh/puppy-client/badges/coverage.png?b=master)](https://scrutinizer-ci.com/g/Raphhh/puppy-client/)
[![Total Downloads](https://poser.pugx.org/raphhh/puppy-client/downloads.svg)](https://packagist.org/packages/raphhh/puppy-client)
[![Reference Status](https://www.versioneye.com/php/raphhh:puppy-client/reference_badge.svg?style=flat)](https://www.versioneye.com/php/raphhh:puppy-client/references)
[![License](https://poser.pugx.org/raphhh/puppy-client/license.svg)](https://packagist.org/packages/raphhh/puppy-client)

Client to test [puppy](https://github.com/Raphhh/puppy).

Example:


## Call

```php
$client = new Client('public/index.php');
$dom = $client->call('contact');
```

## Click

```php
$client = new Client('public/index.php');
$dom = $client->call('contact');

$link = $dom->find('a')->eq(0)
$result = $client->click($link);
```

## Submit

```php
$client = new Client('public/index.php');
$dom = $client->call('contact');

$form = $dom->find('form')->eq(0)
$result = $client->submit($form);
```
