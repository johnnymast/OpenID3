<?php
namespace OpenID3;

class MediaFile extends \SplFileObject
{

    /**
     * @var bool
     */
    protected $parsed = false;


    /**
     * @return bool
     */
    public function isParsed()
    {
        return $this->parsed;
    }
}
