<?php
namespace OpenID3;

class MediaFile extends \SplFileObject
{

    /**
     * @var bool
     */
    protected $is_parsed = false;

    /**
     * @return bool
     */
    public function isIsParsed()
    {
        return $this->is_parsed;
    }
}
