<?php
namespace OpenID3\Frames;

class Header
{
    protected $identifier;
    protected $version;
    protected $flags;
    protected $size;

    /**
     * @return mixed
     */
    public function getIdentifier()
    {
        return $this->identifier;
    }

    /**
     * @return mixed
     */
    public function getVersion()
    {
        return $this->version;
    }

    /**
     * @return mixed
     */
    public function getFlags()
    {
        return $this->flags;
    }

    /**
     * @return mixed
     */
    public function getSize()
    {
        return $this->size;
    }
}
