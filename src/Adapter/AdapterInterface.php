<?php
namespace OpenID3\Adapter;


interface AdapterInterface
{
    /**
     * AdapterInterface constructor.
     * @param $filename
     */
    public function __construct($filename = '');

    /**
     * Initialize the file
     * @return bool
     */
    public function initialize();

    /**
     * @return bool
     */
    public function did_initialize();

    /**
     * @return bool
     */
    public function terminate();

    /**
     * This function should read the MP3 file and
     * for OpenID3\Reader.
     *
     * @param int $size
     * @return mixed
     */
    public function read($size = 0);
}