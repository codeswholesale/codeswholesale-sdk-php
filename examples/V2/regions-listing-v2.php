<?php
session_start();

require_once '../../vendor/autoload.php';
require_once '../utils.php';

$params = [
    'cw.client_id' => 'ff72ce315d1259e822f47d87d02d261e',
    'cw.client_secret' => '$2a$10$E2jVWDADFA5gh6zlRVcrlOOX01Q/HJoT6hXuDMJxek.YEo.lkO2T6',
    'cw.endpoint_uri' => \CodesWholesale\CodesWholesale::SANDBOX_ENDPOINT,
    'cw.token_storage' => new \CodesWholesale\Storage\TokenSessionStorage()
];

$clientBuilder = new \CodesWholesale\ClientBuilder($params);
$client = $clientBuilder->build();

$regions = $client->getRegions();

displayFilters($regions);

