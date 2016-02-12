#!/usr/bin/env php
<?php

require __DIR__.'/../vendor/autoload.php';
$config = require __DIR__.'/config.php';

$client = new Octopush\Api\Client($config['email'], $config['api_key']);

$response = $client->getCredit();

var_dump($response);
