<?php
error_reporting(E_ALL);
ini_set('display_errors', true);

/**
 * We want to make sure we load the correct autoloader
 * where ever we are.
 */
if (is_file(__DIR__ . '/../vendor/autoload.php')) {
    require_once __DIR__ . '/../vendor/autoload.php';
} else {
    require_once __DIR__ . '/../../../autoload.php';
}