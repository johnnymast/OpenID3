<?php
namespace OpenID3;

use OpenID3\exceptions\MediaFileException;

class Reader
{

    /**
     * @var MediaFile
     */
    protected $file;

    /**
     * @var string
     */
    protected $filename = '';

    /**
     * @var ParserInterface
     */
    protected $parser = null;

    /**
     * Reader constructor.
     * @param MediaFile $mediaFile
     */
    public function __construct(MediaFile $mediaFile)
    {
        $this->file = $mediaFile;
        $this->filename = $mediaFile->getFilename();
    }

    /**
     * @return MediaFile
     */
    public function getMediaFile()
    {
        return $this->file;
    }

    /**
     * @return mixed
     * @throws OpenID3FileException
     */
    public function parse()
    {
        if (!$this->file) {
            throw new MediaFileException('invalid media file');
        }

        if ($this->file == false) {
            throw new MediaFileException($this->file->getFilename() . ' is not readable');
        }

        $found = false;

        foreach (['OpenID3\Parser\OpenID3V2', 'OpenID3\Parser\OpenID3V1'] as $class) {
            $parser = new $class($this->file);
            if ($parser->hasTag() == true) {
                $this->parser = $parser;
                $found = true;
                break;
            }
        }
        if ($found == true) {
            $info = $parser->parse();
            return $info;
        }
        throw new MediaFileException('We could not identify ' . $this->file->getFilename());
    }
}
