<?php
/**
 * Created by PhpStorm.
 * User: maciejklowan
 * Date: 27/04/2018
 * Time: 15:35
 */

use CodesWholesale\Resource\Import;

session_start();

require_once '../vendor/autoload.php';
require_once 'utils.php';

$params = [
    /**
     * API Keys
     * These are common api keys, you can use it to test integration.
     */
    'cw.client_id' => '664700994a02e6e887e3a80e5f454a9e',
    'cw.client_secret' => '$2a$10$zqSM3hnJGjB9GvDqcTUsYO6uKm1Nd.bVmpPmA1HYPuJqMXDRpBy4q',
    /**
     * CodesWholesale ENDPOINT
     */
    'cw.endpoint_uri' => \CodesWholesale\CodesWholesale::SANDBOX_ENDPOINT,
    /**
     * Due to security reasons you should use SessionStorage only while testing.
     * In order to go live you should change it do database storage.
     *
     * If you want to use database storage use code below.
     *
     * new \CodesWholesale\Storage\TokenDatabaseStorage(
     * new PDO('mysql:host=localhost;dbname=your_db_name', 'username', 'password'))
     *
     * Also remember to use SQL code included in import.sql file
     *
     */
    'cw.token_storage' => new \CodesWholesale\Storage\TokenSessionStorage()
];

$clientBuilder = new \CodesWholesale\ClientBuilder($params);
$client = $clientBuilder->build();


$registeredImport = Import::registerImport([
    "filters" => [
        "regions"        => [
            "WORLDWIDE"
        ],
        "languages"      => [
            "Multilanguage"
        ],
        "platforms"      => [
            "Steam"
        ],
        "productIds"     => [

        ],
        "inStockDaysAgo" => 0
    ],
    "territory" => "english",
    "webHookUrl" => "http://your_post_back_url.com"
]);

displayRegisteredImport($registeredImport);