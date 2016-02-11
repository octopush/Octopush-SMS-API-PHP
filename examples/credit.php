#!/usr/bin/env php
<?php

require __DIR__.'/../vendor/autoload.php';
$config = require __DIR__.'/config.php';

$client = new Octopush\Api\Client();

$client->set_user_login($config['email']);
$client->set_api_key($config['api_key']);

echo $client->getCredit();
