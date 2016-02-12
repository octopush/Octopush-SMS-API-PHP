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

$client->setSmsRecipients(['+336********']);
$client->setSmsSender('Octopush');

$client->send('Octopush - Send SMS like a PRO.');
```

```
array:9 [
  "error_code" => "000"
  "cost" => "0.049"
  "balance" => "0"
  "sending_date" => "1455291116"
  "number_of_sendings" => "1"
  "currency_code" => "€"
  "successs" => array:1 [
    "success" => array:4 [
      "recipient" => "+336*******"
      "country_code" => "FR"
      "cost" => "0.049"
      "sms_needed" => "1"
    ]
  ]
  "failures" => []
]
```

For more information see [documentation](http://www.octopush.com/en/api-sms-doc/sms-sendings).

#### Sending delayed SMS

```php
<?php

$client = new Octopush\Api\Client('*****@example.com', '***API_KEY***');

$client->setSmsRecipients(['+336********']);
$client->setSmsSender('Octopush');
$client->setSmsMode($client::SMS_MODE_DELAYED);
$client->setSendingTime(new \DateTime('+6 hours'));

$client->send('Octopush - Send SMS like a PRO.');
```

For more information see [documentation](http://www.octopush.com/en/api-sms-doc/scheduled-sendings).

#### Sending SMS with replies

```php
<?php

$client = new Octopush\Api\Client('*****@example.com', '***API_KEY***');

$client->setSmsRecipients(['+336********']);
$client->setSmsSender('Octopush');
$client->setWithReplies();

$client->send('Octopush - Send SMS like a PRO.');
```

For more information see [documentation](http://www.octopush.com/en/api-sms-doc/sms-with-replies).

#### Checking your credit

```php
<?php

$client = new Octopush\Api\Client('*****@example.com', '***API_KEY***');

$client->getCredit();
```

```
array:2 [
  "error_code" => "000"
  "credit" => "0.18"
]
```

For more information see [documentation](http://www.octopush.com/en/api-sms-doc/get-credit).

## Working examples

You can find working examples in `examples` directory.

Before running them, make sure to configure them by editing `config.php` file:

```bash
$ cp config.php.dist config.php
```
