<?php
require 'autoload.php';

use OpenID3\Reader;
use OpenID3\MediaFile;

try {
    $reader = new OpenID3\Reader(
        new MediaFile('../ebert.mp3')
    );

    $info = $reader->parse();
    print_r($info->getTags());

} catch (MediaFileException $e) {
    print_r($e);
} catch (Exception $e) {
    print_r($e);
}