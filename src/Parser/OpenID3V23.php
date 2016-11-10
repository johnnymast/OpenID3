<?php
namespace OpenID3\Parser;
use OpenID3\Adapter\AdapterInterface;

class OpenID3V23 implements ParserInterface
{
    public function __construct(AdapterInterface $adapter) {
        die('Constructed 2.3');
    }

    public function parse()
    {
        // TODO: Implement parse() method.
    }

    public function save()
    {
        // TODO: Implement save() method.
    }

    public function info()
    {
        // TODO: Implement info() method.
    }

}