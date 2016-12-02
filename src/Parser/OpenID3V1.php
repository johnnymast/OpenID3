<?php
namespace OpenID3\Parser;

use OpenID3\exceptions\OpenID3FileException;

class OpenID3V1 implements ParserInterface
{
    const TAG10 = '1.0';
    const TAG11 = '1.1';
    const TAG_UNKNOWN = 'Unknown';

    /**
     * @var \SplTempFileObject
     */
    protected $file = null;

    /**
     * This is the byte positions for ID3v1
     * @var array
     */
    private $headerInfo = [
        'TAG' => [0, 2],
        'Title' => [3, 32],
        'Artist' => [33, 62],
        'Album' => [63, 92],
        'Year' => [93, 96],
        'Comment' => [97, 125],
        'Genre' => [125, 126]
    ];

    /**
     * @var string
     */
    protected $tag_version = self::TAG_UNKNOWN;


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
            $this->file->fseek(-128, SEEK_END);
            $tag = $this->file->fread(128);
            if (substr($tag, 0, 3) == 'TAG') {
                $result = true;
            }
        }
        return $result;
    }

    public function parse()
    {
        $this->file->fseek(-128, SEEK_END);
        $header = $this->file->fread(128);

        $info = [];

        if ($header[125] === "\x00" && $header[126] != "\x00") {
            $this->headerInfo['Comment'] = [97, 122];
            $this->headerInfo['Null'] = [123, 124];
            $this->headerInfo['Track'] = [125, 126];
            $this->headerInfo['Genre'] = [127, 128];
            $this->tag_version = self::TAG10;
        } else {
            $this->tag_version = self::TAG11;
        }

        foreach ($this->headerInfo as $key => $positions) {
            $length = ($positions[1] - $positions[0]) + 1;
            $info[$key] = trim(substr($header, $positions[0], $length), "\x00\x30");
            $info[$key] = trim($info[$key]);
            if ($key === 'Genre' || $key == 'Track') {
                $info[$key] = ord($info[$key]);
            }
        }

        if ($this->tag_version == self::TAG10) {
            unset($info['Null']);
        }

        if (isset($info['TAG']) == true) {
            unset($info['TAG']);
        }

        if ($this->tag_version == self::TAG_UNKNOWN) {
            throw new OpenID3FileException('Could not figure out what version of ID3v1 this file belongs to');
        }

        print_r($info);
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

    public function save()
    {
        // TODO: Implement save() method.
    }

    public function info()
    {
        // TODO: Implement info() method.
    }
}
