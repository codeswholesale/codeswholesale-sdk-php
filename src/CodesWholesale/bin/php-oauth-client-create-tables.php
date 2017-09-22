#!/usr/bin/php
<?php
require_once dirname(__DIR__) . '../../vendor/autoload.php';

use CodesWholesale\CodesWholesale\Storage\TokenDatabaseStorage;

if($argc > 1) {
    $prefix = $argv[1];
} else { 
    $prefix = '';
}

$queries = TokenDatabaseStorage::createTableQueries($prefix);
foreach($queries as $q) {
    echo $q . PHP_EOL;
}
