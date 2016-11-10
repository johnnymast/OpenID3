<?php
require 'autoload.php';
error_reporting(E_ALL);
ini_set('display_errors', true);

use OpenID3\Adapter\Filesystem;
use OpenID3\Reader;


$reader = new OpenID3\Reader(
    new OpenID3\adapter\Filesystem(dirname(__FILE__) . "\\..\\c.mp3")
);

$info = $reader->parse();

print_r($info);

echo 'Done';