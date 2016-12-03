<?php
require 'autoload.php';
error_reporting(E_ALL);
ini_set('display_errors', true);

use OpenID3\Reader;
use OpenID3\MediaFile;
use OpenID3\Exceptions\MediaFileException;

try {
    $reader = new OpenID3\Reader(
        new MediaFile('../youGotmail.mp3')
    );

    $info = $reader->parse();

} catch (MediaFileException $e) {
    print_r($e);
} catch (Exception $e) {
    print_r($e);
}


echo 'Done';
