<?php
namespace OpenID3\Parser;
use OpenID3\Adapter\AdapterInterface;

interface ParserInterface {
    public function __construct(AdapterInterface $adapter);
    public function parse();
	public function save();
	public function info();
}