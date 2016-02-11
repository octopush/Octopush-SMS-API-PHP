#!/usr/bin/env php
<?php

require __DIR__.'/../vendor/autoload.php';
$config = require __DIR__.'/config.php';

$client = new Octopush\Api\Client($config['email'], $config['api_key']);

$client->setSmsRecipients($config['recipients']);
$client->setSmsSender('Octopush');
$client->setSimulationMode();

echo $client->send('Octopush - Send SMS like a PRO.');
