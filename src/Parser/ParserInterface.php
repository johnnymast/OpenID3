<?php
namespace OpenID3\Parser;

use OpenID3\MediaFile;

interface ParserInterface
{
    public function __construct(MediaFile $file);

    public function hasTag();

    public function parse();

    public function version();
}
