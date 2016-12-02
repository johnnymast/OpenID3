<?php
namespace OpenID3\Parser;

class OpenID3V2 implements ParserInterface
{
    const TAG22 = '2.2';
    const TAG23 = '2.3';
    const TAG24 = '2.4';
    const TAG_UNKNOWN = 'Unknown';

    /**
     * @var \SplTempFileObject
     */
    protected $file = null;

    /**
     * @var string
     */
    protected $tag_version = self::TAG_UNKNOWN;

    /**
     * OpenID3V23 constructor.
     * @param \SplFileObject $file
     */
    public function __construct(\SplFileObject $file)
    {
        $this->file = $file;
    }

    /**
     * @return bool
     */
    public function hasTag()
    {
        $result = false;
        if ($this->file) {
            $this->file->fseek(0, SEEK_SET);
            $tag = $this->file->fread(10);
            if (substr($tag, 0, 3) == 'ID3') {
                $result = true;
            }
        }
        return $result;
    }

    /**
     * Return the tag version.
     *
     * @return string
     */
    public function version()
    {
        return $this->tag_version;
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
