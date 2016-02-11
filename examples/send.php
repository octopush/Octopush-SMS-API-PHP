#!/usr/bin/env php
<?php

require __DIR__.'/../vendor/autoload.php';
$config = require __DIR__.'/config.php';

$client = new Octopush\Api\Client($config['email'], $config['api_key']);

$client->set_sms_recipients($config['recipients']);
$client->set_sms_sender('Octopush');

echo $client->send('Octopush - Send SMS like a PRO.');
