<?php
namespace OpenID3;

/**
 * Class MediaFile
 * @package OpenID3
 */
class MediaFile extends BinaryReader
{

    /**
     * @var bool
     */
    protected $parsed = false;

    /**
     * @var array
     */
    protected $tags = [];

    /**
     * @return array
     */
    public function getTags()
    {
        return $this->tags;
    }

    /**
     * @param array $tags
     */
    public function setTags($tags = [])
    {
        $this->tags = $tags;
    }

    /**
     * @param bool $parsed
     */
    public function setParsed($parsed = false)
    {
        $this->parsed = $parsed;
    }

    /**
     * @return bool
     */
    public function isParsed()
    {
        return $this->parsed;
    }
}
