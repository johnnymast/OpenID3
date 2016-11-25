<?php
namespace OpenID3\Parser;

interface ParserInterface
{
    public function __construct(\SplFileObject $file);

    public function has_tag();

    public function parse();

    public function save();

    public function info();

    public function version();
}