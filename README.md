# Octopush API

Octopush SMS API PHP client.

## Installation

The recommended way to install Octopush SMS API PHP client is through composer:

```bash
$ composer require octopush/sms-api
```

## Usage

#### Sending simple SMS

```php
<?php

$client = new Octopush\Api\Client('*****@example.com', '***API_KEY***');

$client->setSmsRecipients(['+381********']);
$client->setSmsSender('Octopush');

$client->send('Octopush - Send SMS like a PRO.');
```

For more information see [documentation](http://www.octopush.com/en/api-sms-doc/sms-sendings).

#### Checking your credit

```php
<?php

$client = new Octopush\Api\Client('*****@example.com', '***API_KEY***');

$client->getCredit();
```

For more information see [documentation](http://www.octopush.com/en/api-sms-doc/get-credit).

## Working examples

You can find working examples in `examples` directory.

Before running them, make sure to configure them by editing `config.php` file:

```bash
$ cp config.php.dist config.php
```
