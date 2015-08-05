<?php
error_reporting(E_ALL);
ini_set("display_errors", 1);

if (!file_exists($vendor = __DIR__ . '/../vendor/autoload.php')) {
    throw new RuntimeException('Install dependencies to run unit tests.');
}

require_once $vendor;