<?php
require 'autoload.php';
error_reporting(E_ALL);
ini_set('display_errors', true);

use OpenID3\Reader;
use OpenID3\MediaFile;

try {
    $reader = new OpenID3\Reader(
        new MediaFile('../youGotmail.mp3')
    );

    $info = $reader->parse();

} catch (OpenID3FileException $e) {
    print_r($e);
}


echo 'Done';